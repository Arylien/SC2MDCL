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
	require('list_matches.php');
} else if (isset($_GET['match']) && is_numeric($_GET['match'])) {
	$Match = (int) $_GET['match'];
	require('view_match.php');
} else {
	$currentpage = 1;
	require('list_matches.php');
}

//////////// End of Page////////////

// Include the page footer and perform any nescessary cleanup.
require_once 'footer.php';
?>