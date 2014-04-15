<?
//////////// Header Information ////////////
// Include essential scripts.
require_once 'config.php';
require_once 'lists.php';
require_once 'functions.php';

// Include the page header and set script variables.
$PageName = ucwords(basename(__FILE__, '.php'));
//$jqueryui = (bool) true;
//$heatmap = (bool) true;
//$tablesorter = (bool) true;
$gchart = (bool) true;
require_once 'header.php';
//////////// End of Header ////////////

//////////// Page Contents ////////////

if (isset($_GET['race']) && is_numeric($_GET['race'])) {
	$Race = $Races[strtolower($_GET['race'])];
	require('view_race.php');
} else {
	require('list_races.php');
}

//////////// End of Page////////////

// Include the page footer and perform any nescessary cleanup.
require_once 'footer.php';
?>