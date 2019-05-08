<?php
include('db_connection.php');
include('db_functions.php');

// We will get some data from the database; we should already have a database connection

if (!isset($_GET['filter_beer']) && !isset($_GET['filter_brewpub']) && !isset($_GET['filter_style'])){
	$query = "SELECT * FROM breweries";
} else {
	$query = "SELECT * FROM breweries WHERE ";
}

$flag_beer = 0;
$flag_brewpub = 0;


if (isset($_GET['filter_beer'])  && $_GET['filter_beer'] != 'True') {
        $flag_beer = 1;
	$filB = $_GET['filter_beer'];

//look for certain values
switch ($filB) {
	case 'Ale':
	case 'Lager':
	case 'Malt':
	case 'StoutPorter':
	case 'Special':
		$query .= "beer_category = '{$filB}'";
		break;
		
	default:
		// $query .= "beer_category = true ";	
}
}


if (isset($_GET['filter_brewpub']) && $_GET['filter_brewpub'] != 'True'){  
	$flag_brewpub = 1;
	$filPub = $_GET['filter_brewpub'];
//look for certain values
	switch ($filPub) {
		case 'Yes':
		case 'No':
			if ($flag_beer == 1) {
				$query .= "AND brewpub = '{$filPub}'";
			} else {
				$query .= "brewpub = '{$filPub}'";
			}
			break;
		
		default:
		//	$query .= "AND brewpub IN ('Yes', 'No')";

	}
}

if (isset($_GET['filter_style']) || $_GET['filter_style'] != 'True' ){
	$filStyle = $_GET['filter_style'];
	switch($filStyle){
	case 'Ale':
	case 'Altbier':
	case 'Amber Ale':
	case 'Berliner Weisse':
	case 'Bitter':
	case 'Blonde':
	case 'IPA':
	case 'Lager':
	case 'Light Ale':
	case 'Other':
	case 'Oyster Stout':
	case 'Pale Ale':
	case 'Pilsner':
	case 'Porter':
	case 'Red Ale':
	case 'Ruby Ale':
	case 'Saison':
	case 'Stout':
		if ($flag_beer == 1 || $flag_brewpub ==1) {
			$query .= " AND type_of_beer = '{$filStyle}';";
		} else {
			$query .= "type_of_beer = '{$filStyle}';";
		}
		break;
	default:
		// $query .= " AND type_of_beer = true;";
	

}
}




//if ($filPub != true) {
//    $query .= " and ";
//}
//$query .= ";";



// this captures all the results as an array in PHP...
$results = db_assocArrayAll($dbh,$query);

// ...however, we want a Javascript array, for the rest of the Javascript to use
echo "<script type='text/javascript'>";
echo "var mapData = ".json_encode($results,JSON_NUMERIC_CHECK);
echo "</script>";
?>