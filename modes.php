<?
//////////// Header Information ////////////
// Include essential scripts.
require_once '../../../phpapps/MDCL/config.php';
require_once 'lists.php';
require_once 'functions.php';

// Include the page header and set script variables.
$PageName = ucwords(basename(__FILE__, '.php'));
//$jquery = (bool) true;
//$heatmap = (bool) true;
//$tablesorter = (bool) true;
require_once 'header.php';
//////////// End of Header ////////////

//////////// Page Contents ////////////

echo '<div class="thin">
	<div class="box">
		<div class="head">
			<center><strong>Modes</strong></center>
		</div>
		<div class="article">
			<p>Placeholder page for Game Mode Statistics. This page will contain information about each game mode (such as 1v1, 2v2, 3v3, 4v4 and FFA) and will allow you to start to filter search results by game modes.</p>
		</div>
	</div>
</div>';

//////////// End of Page////////////

// Include the page footer and perform any nescessary cleanup.
require_once 'footer.php';
?>