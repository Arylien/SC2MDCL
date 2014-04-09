<?
//////////// Header Information ////////////
// Include essential scripts.
require_once '../../../phpapps/MDCL/config.php';
require_once 'lists.php';
require_once 'functions.php';

// Include the page header and set script variables.
$PageName = ucwords(basename(__FILE__, '.php'));
$jqueryui = (bool) true;
//$heatmap = (bool) true;
//$tablesorter = (bool) true;
$gchart = (bool) true;
$sc2 = (bool) true;
require_once 'header.php';
//////////// End of Header ////////////

//////////// Page Contents ////////////

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
	$currentpage = (int) $_GET['page'];
	require_once('list_players.php');
} else if (isset($_GET['player']) && is_numeric($_GET['player'])) {
	$Player_ID = (int) $_GET['player'];
	require_once 'classes.php';
	require_once('view_player.php');
} else {
	$currentpage = 1;
	require_once('list_players.php');
}

//////////// End of Page////////////

// Include the page footer and perform any nescessary cleanup.
require_once 'footer.php';
?>