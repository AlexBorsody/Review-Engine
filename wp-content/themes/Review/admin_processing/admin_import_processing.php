<?php
class Importation
{
	public $ads_list = array();
	private $nodekeys = array('title','desc','categoryid', 'price','linkproduct');
	private $result = false;
	private $message = "";
	
	function __construct()
	{
		if ( !empty($_POST) )
		{
			$step = $_POST['step'];
			switch ( $step )
			{
				case 2:
					$this->handle_file();
					break;
				case 3:
					$this->save_ads();
					break;
			}
		}
	}
	
	/**
	 *
	 */
	function handle_file()
	{
		$ext = substr( $_FILES['import_file']['name'], -3);
		
		switch ($ext)
		{
			case 'xml':
				$this->ads_list = $this->read_xml();
				break;
			case 'csv':
				$this->ads_list = $this->read_csv();
				break;
		}
		
	}
	
	function create_temp_file()
	{
		//move file
		$file = dirname($_FILES['import_file']['tmp_name']) . DIRECTORY_SEPARATOR . $_FILES['import_file']['name'] ;
		copy($_FILES['import_file']['tmp_name'], $file);
		return $file;
	}
	
	/**
	 * read xml
	 * @return array of ads :
	 *  - title
	 *  - desc
	 *  - categoryid
	 *  - authorid
	 *  - price
	 *  - address
	 *  - country
	 *  - phone
	 */
	function read_xml()
	{
		// prepare resule
		$result = array();
		$file = $this->create_temp_file();
		
		// read xml
		$reader = new DOMDocument();
		$reader->load($file);
		
		$adslist = $reader->getElementsByTagName('product');
		
		$nodekeys = $this->nodekeys;
		foreach($adslist as $ads)
		{
			$new_ads = array();			
			foreach($nodekeys as $key)
			{
				$values = $ads->getElementsByTagName($key);
				$new_ads[$key] = $values->item(0)->nodeValue;
			}
			$result[] = (object)$new_ads;
		}
		// remove temp file
		unlink($file);
		return $result;
	}
	
	function read_csv()
	{
		$result = array();
		
		$filename = $this->create_temp_file();
		$row = 1;
		$file = fopen($filename, "r");
		while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
			$ads = array();
			foreach( $this->nodekeys as $i => $key )
			{
				$ads[$key] = $data[$i];
			}
			$result[] = (object)$ads;
		}
		fclose($file);
		unlink($filename);
		return $result;
	}
	
	function save_ads()
	{
		if ( !empty($_POST['ads'])  )
		{
			// prepare
			$adslist 	= $_POST['ads'];
			$status 		= !empty( $_POST['ads_status'] ) ? $_POST['ads_status'] : "draft";
			$count 		= 0;
			foreach ( $adslist as $ads )
			{
				$id = wp_insert_post(
					array(
						'post_title' => $ads['title'],
						'post_content' => $ads['desc'],
						'post_status' => $status,
						'post_type' => 'product'
					) );
				
				if ( !empty( $id ) )
				{
					// insert category
					wp_set_post_terms( $id, array( $ads['categoryid']), 'category'  );
					
					// insert meta data
					add_post_meta( $id, 'tgt_product_price', $ads['price'] );
					add_post_meta( $id, 'tgt_product_url', $ads['linkproduct'] );
					
					$count++;
				}
			}
			
			// return message
			$this->result = true;
			$this->message = $count > 1 ? $count . __(' products has been inserted','re') : $count . __(' product has been inserted','re');
		}
	}
	
	function display()
	{
		$step = empty($_POST['step']) ? 1 : $_POST['step'];
		switch($step)
		{
			case 1:
				$this->display_step_1();
				break;
			case 2:
				$this->display_step_2();
				break;
			case 3:
				$this->display_step_3();
				break;
		}
	}
	
	function display_step_1()
	{ ?>
		<form action="" method="post" enctype="multipart/form-data" >
			<p > upload csv/xml file</p>
			<input type="file" name="import_file" /><br />
			<input type="hidden" name="step" value="2" />
			<input type="submit" value="Upload" class="button-primary" />
		</form>
		
		<p class="desc">
			<b>CSV sample</b><br/>
			<?php _e("Each line of your csv file describe a product, you must seperate product's information by comma \",\". <br/> Information order is :(title, description, category-id, author-id, price, link product). <br />  ",'re') ?>
			<b>Eg:</b><br />
			<code> "AKG 701","Headphone from akg",5,"265","dailywp.com" <br />
			"AKG 701","Headphone from akg",5,"265","dailywp.com" </code>
		</p>
		<p class="desc">
			<b>XML sample: </b><br/>									
			<b>Eg:</b><br />
			<code>&lt;products&gt;
<br>&nbsp;&nbsp;&nbsp;&lt;product&gt;
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;title&gt;AKG K701&lt;/title&gt;
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;desc&gt;headphone from AKG&lt;/desc&gt;
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;categoryid&gt;5&lt;/categoryid&gt;
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;price&gt;265&lt;/price&gt;
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;linkproduct&gt;dailywp.com &lt;/linkproduct&gt;
<br>&nbsp;&nbsp;&nbsp;&lt;/product&gt;
<br>&nbsp;&nbsp;&nbsp;&lt;product&gt; ... &lt;/product&gt;
<br>&lt;/products&gt;
			</code>
		</p>
		<?php		
	}
	
	function display_step_2()
	{ ?>
		<form action="" method="post">
			<table class="wp-list-table widefat">
				<thead>
					<tr>
						<th width="3%"></th>
						<th width="2%"><?php _e('No','re'); ?></th>
						<th width="10%"><?php _e('Title','re'); ?></th>
						<th width="40%"><?php _e('Description','re'); ?></th>
						<th width="10%"><?php _e('Cat ID','re'); ?></th>
						<th width="10%"><?php _e('Price','re'); ?></th>
						<th width="25%"><?php _e('Link product','re'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty( $this->ads_list ))  {
						$c = 0;
						foreach ( $this->ads_list as $ads)
						{
						?>					
						<tr>
							<td>
								<input type="checkbox" name="check[<?php echo $c ?>]" checked="checked"/>
								<input type="hidden" name="ads[<?php echo $c ?>][title]" value="<?php echo $ads->title?>" />
								<input type="hidden" name="ads[<?php echo $c ?>][desc]" value="<?php echo $ads->desc?>" />
								<input type="hidden" name="ads[<?php echo $c ?>][categoryid]" value="<?php echo $ads->categoryid?>" />
								<input type="hidden" name="ads[<?php echo $c ?>][price]" value="<?php echo $ads->price?>" />
								<input type="hidden" name="ads[<?php echo $c ?>][linkproduct]" value="<?php echo $ads->linkproduct?>" />
							</td>
							<td><?php $c++; echo $c ?></td>
							<td><?php echo $ads->title ?></td>
							<td><?php echo $ads->desc ?></td>
							<td><?php echo $ads->categoryid ?></td>
							<td><?php echo $ads->price ?></td>
							<td><?php echo $ads->linkproduct ?></td>
						</tr>
					<?php } } else {
						echo '<tr>
							<td colspan="7" align="center"><i>'.__('There is no available field yet!','re').'</i></td>
						</tr>';
					} ?>
				</tbody>
			</table>
			<p>
				<?php _e('Choose status for above products: ', 're'); ?>
				<select name="ads_status" id="">
					<option value="publish">Published</option>
					<option value="draft">Draft</option>
					<option value="pending">Pending Review</option>
				</select>
			</p>
			<p>				
				<?php _e('Import these selected products?','re'); ?>
				<input type="hidden" name="step" value="3" />
				<input type="submit" value="Yes, Save these products" class="button-primary" />
			</p>	
		</form>
		<?php 
	}
	
	function display_step_3()
	{ 	?>
		<?php if( $this->result ) { ?>
		<div class="updated below-h2"><?php echo $this->message ?></div>
		<?php } ?>
		<p>
			<?php _e( 'You have imported products successfully. Now you can ', 're' ) ?>
			<a href="<?php echo HOME_URL ?>/wp-admin/admin.php?page=review-engine-admin-import"><?php _e( ' import another file ' , 're' ) ?></a> <?php _e( ' or ' , 're' ) ?>
			<a href="<?php echo HOME_URL ?>/wp-admin/edit.php?post_type=product"><?php _e( ' go to list products page' , '' ) ?></a>
		</p>
		<?php
	}
}

$importation = new Importation();
?>