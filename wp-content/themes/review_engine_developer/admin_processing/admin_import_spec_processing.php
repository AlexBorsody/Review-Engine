<?php
class SpecificationImportation
{
	public $data_list = array();
	private $nodekeys = array('title','desc','price','linkproduct');
	private $cat = '';
	private $value_list = array(
										array(
												'label' => 'Title',
												'name' => 'post_title',
												'value' => ''
												),
										array(
												'label' => 'Description',
												'name' => 'post_content',
												'value' => ''
												),
										array(
												'label' => 'Price',
												'name' => PRODUCT_PRICE,
												'value' => ''
												),
										array(
												'label' => "Product's Url",
												'name' => PRODUCT_URL,
												'value' => ''
												),
										 );
	private $result = false;
	private $message = "";
	
	function __construct()
	{
		if ( !empty($_POST) )
		{
			$step 		= $_POST['step'];
			$this->cat 	= $_POST['cat'];
			switch ( $step )
			{
				case 2:
					$this->get_instruction();
					break;
				case 3:
					$this->handle_file();
					break;
				case 4:
					$this->save_data();
					break;
			}
		}
	}
	
	/**
	 * get specification and data from category
	 */
	function get_instruction()
	{
		// get data
		$include_spec 	= $_POST['include_spec'];
		$cat 				= $_POST['cat'];
		$this->cat 		= $cat;
		
		// find specification by category
		$specs 			= get_all_data_spec_by_cat_id_tgt( $cat );
		// find value list
		foreach( $specs as $spec )
		{
			if ( !empty( $spec['value'] ) && is_array( $spec['value']) )
			{
				foreach( $spec['value'] as $value )
				{
					$node = array();
					$node['label'] = $value['value_name'];
					$node['name']  ='spec';
					$node['id']  	= 'g_' . $spec['spec_id'] . '_' . $value['spec_value_id'];
					$node['value']  = '';
					$this->value_list[] = $node;
				}
			}
		}
	}
	
	function fill_bonus_value($cat)
	{		
		// find specification by category
		$specs 			= get_all_data_spec_by_cat_id_tgt( $cat );
		// find value list
		foreach( $specs as $spec )
		{
			if ( !empty( $spec['value'] ) && is_array( $spec['value']) )
			{
				foreach( $spec['value'] as $value )
				{
					$node = array();
					$node['label'] = $value['value_name'];
					$node['name']  ='spec';
					$node['id']  	= 'g_' . $spec['spec_id'] . '_' . $value['spec_value_id'];
					$node['value']  = '';
					$this->value_list[] = $node;
				}
			}
		}
	}
	
	/**
	 * read import file
	 */
	function handle_file()
	{
		$this->cat = $_POST['cat'];
		$cat = $_POST['cat'];
		$ext = substr( $_FILES['import_file']['name'], -3);
		
		$this->fill_bonus_value($cat);
		switch ($ext)
		{
			case 'csv':
				$this->data_list = $this->read_csv();
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
	 * @return array of data :
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
		
		$datalist = $reader->getElementsByTagName('products');
		
		$nodekeys = $this->nodekeys;
		foreach($datalist as $data)
		{
			$new_data = array();			
			foreach($nodekeys as $key)
			{
				$values = $data->getElementsByTagName($key);
				$new_data[$key] = $values->item(0)->nodeValue;
			}
			$result[] = (object)$new_data;
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
			//$data = array();
			//foreach( $this->nodekeys as $i => $key )
			//{
			//	$data[$key] = $data[$i];
			//}
			$product = array();
			foreach( $this->value_list as $i => $value )
			{
				$item 	= 	$value;
				$item['value'] = $data[$i];
				$product[] = $item;
			}
			$result[] = (object)$product;
		}
		fclose($file);
		unlink($filename);
		return $result;
	}
	
	function save_data()
	{
		if ( !empty($_POST['data'])  )
		{
			// prepare
			$datalist 	= $_POST['data'];
			$status 		= !empty( $_POST['data_status'] ) ? $_POST['data_status'] : "draft";
			$count 		= 0;
			$cat 			= $_POST['cat'];
			$i = 0;
			foreach ( $datalist as $index => $data )
			{
				if ( isset( $_POST['check'][$i] )  ) {
					$id = wp_insert_post(
						array(
							'post_title' => $data['post_title'],
							'post_content' => $data['post_content'],
							'post_status' => $status,
							'post_type' => 'product'
						) );
					
					if ( !empty( $id ) )
					{
						// insert category
						wp_set_post_terms( $id, array( $this->cat) , 'category' );
						
						// insert meta data
						add_post_meta( $id, 'tgt_product_price', $data['tgt_product_price'] );
						add_post_meta( $id, 'tgt_product_url', $data['tgt_product_url'] );
						add_post_meta( $id, 'tgt_product_spec', $data['spec'] );
						
						$count++;
					}
				}
				$i++;
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
			case 4:
				$this->display_step_4();
				break;
		}
	}
	
	function display_step_1()
	{ ?>
		<p> <?php _e('<b>NOTE: </b>Please choose one category to process import products with specification. Because each category has it\'s own specification so you must import products in same categories in a same time only','re') ?> </p>
		<form action="" method="post">
			<p>
				<label for=""><?php _e('Category','re') ?></label> <br />
				<?php categories_dropdown( array( 'name' => 'cat' ) ); ?>
			</p>
			<!--<p>
				<input type="checkbox" name="include_spec" id="" value="1"/> <label for="include_spec"><?php _e('Include Specification Importation') ?></label>
			</p>	-->		
			<input type="hidden" name="include_spec" id="" value="0"/>
			<input type="hidden" name="step" value="2" />
			<input type="submit" value="<?php _e('Continue','re') ?>" class="button-primary" />
		</form>		
	<?php
	}
	
	function display_step_2()
	{ ?>
		<form action="" method="post" enctype="multipart/form-data" >
			<p> Upload csv file</p>
			<input type="file" name="import_file" /><br />
			<input type="hidden" name="step" value="3" />
			<input type="hidden" name="cat" value="<?php echo $this->cat ?>" />
			<input type="submit" value="Upload" class="button-primary" />
		</form>
		
		<p class="desc">
			<b><?php _e('Sample','re') ?></b><br/>
			<?php _e("Each line of your csv file describe a product, you must seperate product's information by comma \",\". <br/>  ",'re') ?>
			<b>Eg:</b><br />
			<code>
				<?php
				$count = 0;
				foreach( $this->value_list as $value ) {
					if ( $count > 0) echo ', ';
					$count++;
					echo $value['label'];
				} ?>
				<br />
			</code>
		</p>
		<?php		
	}
	
	function display_step_3()
	{ ?>
		<form action="" method="post">
			
			<table class="wp-list-table widefat">
				<tr>
					<th width="3%"></th>
					<th width="2%"><?php _e('No','re'); ?></th>
					<?php foreach ( $this->value_list as $header )  { ?>
						<th> <?php echo $header['label'] ?> </th>
					<?php } ?>
				</tr>
				<?php
				$c = 0;
				foreach ( $this->data_list as $product_info ) {  ?>
					<tr>
						<td>
							<input type="checkbox" name="check[<?php echo $c ?>]" checked="checked"/>
						</td>
						<td>
							<?php $c++; echo $c ?>
						</td>
						<?php foreach( $product_info as $info ) {
								if ( $info['name'] == 'spec' )
									$name = 'data[' . $c .'][spec][' . $info['id'] . ']';
								else
									$name = 'data[' . $c .'][' . $info['name'] . ']'; 
							?>
							<td>
								<?php echo $info['value']; ?>
								<input type="hidden" name="<?php echo $name ?>" value="<?php echo $info['value'] ?>"/>
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
			</table>
			<?php $cat = get_category( $this->cat ) ?>
			<p> <?php echo __('Import to category ','re') .'<b>'. $cat->name .'</b>' ?>  </p>
			<p>
				<?php _e('Choose status for above products: ', 're'); ?>
				<select name="data_status" id="">
					<option value="publish">Published</option>
					<option value="draft">Draft</option>
					<option value="pending">Pending Review</option>
				</select>
			</p>
			<p>				
				<?php _e('Import these selected products?','re'); ?>
				<input type="hidden" name="step" value="4" />
				<input type="hidden" name="cat" value="<?php echo $this->cat ?>" />
				<input type="submit" value="Yes, Save these products" class="button-primary" />
			</p>	
		</form>
		<?php 
	}
	
	function display_step_4()
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

$importation = new SpecificationImportation();
?>