<?php
/**
 * This file is used to process the data from the rating management site
 * Processing contain:
 *  - Add global rating
 *  - Edit global rating
 *  - Delete global rating
 *  - Add category's rating from global rating
 *  - Remove category's rating
 *  
 * @name: admin_rating_processing
 * @author: toannm
 *
 *
 */

// message for the processing
$message = '';

// error for the processing
$errors = '';

// global rating in the option
$globalRating = array();
$globalRating = getGlobalRating();
if (empty($globalRating)) $globalRating = array();

// category rating in the option
$rating = array();
$rating = getCategoryRating();
if (empty($rating)) $rating = array();

// get category
$allCat = get_categories(array('hide_empty' => '0'));
$catList = array();
foreach ($allCat as $cat) {
	if ( empty( $cat->parent ) ){
		$catList[] = $cat;
	}
}

// processing data
if (!empty($_POST)){
	// add new rating
	if (!empty($_POST['new_rating'])){
		$rating = $_POST['rating'];
		// validate
		$rating['name'] = trim($rating['name']);
		if (empty( $rating['name'] )){
			$errors .= __('Rating name can not be empty', 're');
		}
		
		// validate pass
		if (empty($errors)){
			$globalRating =  addNewGlobalRating($rating['name'], $globalRating);
			setGlobalRating($globalRating);
			$message = __('Add rating successfully', 're');
		}
	}
	else 
	if (!empty($_POST['save_rate']) ){
		try{
		$ratings = array();
		if (isset( $_POST['cat_rating'] )) {
			$ratings = $_POST['cat_rating'];
		}
		
		//add rating
		setCategoryRating($_POST['category'], $ratings);
		$message = __('Save Rating successfully', 're');
		}
		catch (Exception $ex) {
			
		}
	}
}
// reget it
$globalRating = getGlobalRating();
if (empty($globalRating)) $globalRating = array();

$rating = getCategoryRating();
if (empty($rating)) $rating = array();

$jsonCat = generateJson();


function generateJson(){
	$globalRating = getGlobalRating();
	if (empty($globalRating)) $globalRating = array();
	
	$rating = getCategoryRating();
	if (empty($rating)) $rating = array();

	$jsonCat = array();
	foreach ($rating as $key => $cat){
		if (!empty($cat))
			foreach ($cat as $r){
				$jsonObject = array();
				$jsonObject['id'] = $r;
				$jsonObject['name'] = $globalRating[$r];
				$jsonCat[$key][] = $jsonObject;
			}
	}

	return $jsonCat;
}

// get global rating
function getGlobalRating(){
	return get_option(SETTING_RATING);
}

// get categoires ratings
function getCategoryRating(){
	return get_option(SETTING_CATEGORY_RATING);
}

// set global rating
function setGlobalRating($rating){
	update_option(SETTING_RATING, $rating);
}

//
function setCategoryRating($cat_id, $ratingArray){
	$catRating = getCategoryRating();
	$catRating[$cat_id] = $ratingArray;
	update_option(SETTING_CATEGORY_RATING, $catRating);
}

function addNewGlobalRating($rating, $globalRating){
	$id = newRatingID($globalRating);
	$globalRating[$id] = $rating;
	return $globalRating;
}

//
function newRatingID($globalRating){
	// if global rating has no item
	if (!count($globalRating)) return 'r_' . 1;
	
	// unless: get the count of the array
	$index = count($globalRating);
	while ( isset( $globalRating['r_'.$index] ) ){
		$index++;
	}
	
	return 'r_' . $index;
}
?>