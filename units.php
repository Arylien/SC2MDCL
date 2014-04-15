<?
//////////// Header Information ////////////
// Include essential scripts.
require_once 'config.php';
require_once 'lists.php';
require_once 'functions.php';
require_once 'classes.php';

// Include the page header and set script variables.
$PageName = ucwords(basename(__FILE__, '.php'));
$jqueryui = (bool) true;
$tipsy = (bool) true;
//$heatmap = (bool) true;
//$tablesorter = (bool) true;
$sc2 = (bool) true;
require_once 'header.php';
//////////// End of Header ////////////

//////////// Page Contents ////////////

if (isset($_GET['unit']) && is_numeric($_GET['unit'])) {
	$Unit = (int) $_GET['unit'];
	$TechTree = new TechTree($db);

	echo '
	<center>
		<div class="boxnewusers">
			<div class="head">
				<strong>View Unit</strong>
			</div>
			<div class="padnewusers">
				<p>The page for each individual unit or structure will contain both the standard statistics, such as Abilities, Costs, Vitals, etc, as well as more detailed information on that unit or structure\'s performance in game, such as it\'s percent of all units built for that race in particular modes or leagues, it\'s average damage dealth, it\'s cost effectiveness, etc. Ideally, this information will be displayed in an over-time format, allowing users to see how that unit or structure\'s performance has changed over time, and what effect patches have had on it\'s performance and usage. This allows both users and developers get a glimpse at how the metagame is evolving and what the true effects a balance change has made upon a particular unit, structure, or even abilities.</p>
			</div>
		</div>
	</center>
	';
	$TechTree->createUnitPage($db, $Unit);
} else {
	$TechTree = new TechTree($db);
	echo "<center>
			<div class='boxnewusers'>
				<div class='head'>
					<strong>Units</strong>
				</div>
				<div class='padnewusers'>
					<p>Below is a list of each race's basic units. Clicking on any row will go to a page with more information on that individual unit's usage statistics pooled from data collected from every match in the database.</p>
				</div>
			</div>
		</center>
		<div class='thin'>";
	$TechTree->createUnitTable($db);
	
	echo "</div>";
}

//////////// End of Page////////////

// Include the page footer and perform any nescessary cleanup.
require_once 'footer.php';
?>