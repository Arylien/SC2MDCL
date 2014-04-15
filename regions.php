<?
//////////// Header Information ////////////
// Include essential scripts.
require_once 'config.php';
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
			<center><strong>Regions</strong></center>
		</div>
		<div class="article">
			<p>Placeholder page for Regional Statistics. From here you will be able to get some general information about each region and begin to filter searches by region.</p>
		</div>
	</div>
</div>';

//////////// End of Page////////////

// Include the page footer and perform any nescessary cleanup.
require_once 'footer.php';
?>