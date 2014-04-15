<?
//////////// Header Information ////////////
// Include essential scripts.
require_once 'config.php';
require_once 'lists.php';
require_once 'functions.php';

// Include the page header and set script variables.
$PageName = ucwords(basename(__FILE__, '.php'));
$jqueryui = (bool) true;
$lightbox = (bool) true;
$heatmap = (bool) true;
$gchart = (bool) true;
//$tablesorter = (bool) true;
require_once 'header.php';
//////////// End of Header ////////////

//////////// Page Contents ////////////

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
	$currentpage = (int) $_GET['page'];
	require('list_maps.php');
} else if (isset($_GET['map']) && is_numeric($_GET['map'])) {
	$Map = (int) $_GET['map'];
	require('view_map.php');
} else {
	$currentpage = 1;
	require('list_maps.php');
}

//////////// End of Page////////////

// Include the page footer and perform any nescessary cleanup.
require_once 'footer.php';
?>