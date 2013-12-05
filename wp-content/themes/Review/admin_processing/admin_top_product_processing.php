<?php
$message = '';
$error = '';
$product = '';
if(isset ($_POST['add_top_product']))
{
    $result = 0;
    $check = isset ($_POST['check_product']) ? $_POST['check_product'] : '';
    $product = isset($_POST['search_product']) ? $_POST['search_product'] : '';
    if(!empty($check))
    {
        foreach($check as $ch)
        {
            $result = add_top_product($ch);
        }
        if($result > 0)
            $message = __('Adding top product successfully', 're');
        else if($result == -1) $error = __('Sorry, this product already exists in the top product.', 're');
        else $error = __('Sorry, cant not add this product in top.', 're');
    }
    else $error = __('ERROR: Please choose product.', 're');
}
elseif(isset ($_POST['save-sort-product'])) {
    $product_sorted = isset ($_POST['top_product']) ? $_POST['top_product'] : '';   
    $display_top = isset ($_POST['display_homepage']) ? $_POST['display_homepage'] : '';    
	update_option(PRODUCT_TOP_DISPLAY, $display_top);
    update_option(PRODUCT_TOP, $product_sorted);
    $re = get_option(PRODUCT_TOP);   
    $message = __('You have successfully arranged for top product','re');     
}
?>