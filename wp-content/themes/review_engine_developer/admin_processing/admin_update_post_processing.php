<?php
$message = '';
$error = '';
if(isset ($_POST['convert_post']))
{    
    $result = 0;
    $check_ids = isset ($_POST['check_post']) ? $_POST['check_post'] : '';
    if(!empty ($check_ids))
    {
        $result = update_post($check_ids);
    }
    if($result > 0)
    {
        $message = __('You have updated successfully.','re');
    }
    else
    {
        $error = __('Sorry, can not updated. Please try again.','re');
    }
}


if (isset( $_POST['convert_specification'] ))
{
    // do convertation
    //var_dump('test');
    tgt_add_more_tables();
    $message = __('You have converted successfully.','re');
}
?>