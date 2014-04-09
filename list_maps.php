<?
require_once 'lists.php';
require_once 'classes.php';
require_once 'functions.php';

///*
// Count the number of Matches in the Database. 
$numrows = countRows($db, 'Maps');

// Set the number of Matches to displayer per page.
$rowsperpage = 10;
// Find out how many pages there will be.
$totalpages = ceil($numrows / $rowsperpage);

$Sort = 'Map_Name';

// if current page is greater than total pages...
if ($currentpage > $totalpages) {
   	// set current page to last page
   	$currentpage = $totalpages;
}
// if current page is less than first page...
if ($currentpage < 1) {
   	// set current page to first page
   	$currentpage = 1;
}

// the offset of the list, based on current page 
$offset = ($currentpage - 1) * $rowsperpage;

// range of num links to show
$range = 10;

// Get all the matches from the Database
$Selection = selectFields($db, 'Maps', null, null, array($Sort => 'ASC'), $offset, $rowsperpage);

// Create a page header
echo "<center>
			<div class='boxnewusers'>
				<div class='head'>
					<strong>Maps</strong>
				</div>
				<div class='padnewusers'>
					<p>This page contains a list of all the maps tracked in the database. Selecting a map will lead to a page with detailed statistics about that map collected in every match played on that map.</p>
				</div>
			</div>
		</center>
		<div class='thin'>";

// Create Table Structure

createPageLinks($totalpages, $currentpage, $range, $rowsperpage);

echo "<div class='box'>
	<center>
		<div class='head'>
			<strong>Maps</strong>
		</div>
	</center>
<div class='mapThumbs'>";

// Print out 
$i = (($rowsperpage * $currentpage) - ($rowsperpage - 1));
foreach($Selection as $Map){
	
	// Assign some of the map Variables.
	$MapID = $Map['Map_ID'];
   	$MapName = $Map['Map_Name'];
	$MapImage = getMapImage($MapName, 128);
	$MapSize = $Map['Map_Size_X']." ,".$Map['Map_Size_Y'];
	$PlayableSize = $Map['Map_Size_Playable_X']." ,".$Map['Map_Size_Playable_Y'];
	$Matches = getCountWhere($db, 'MatchData', 'Map_ID', $MapID);
	$MapTooltip = '
		<strong>Name:</strong> <span>'.$MapName.'</span>
		<br class=\'clear\'/> 
		<strong>Size:</strong> <span>'.$MapSize.'</span>
		<br class=\'clear\'/> 
		<strong>Playable:</strong> <span>'.$PlayableSize.'</span>
		<br class=\'clear\'/> 
		<strong>Matches Played:</strong> <span>'.$Matches.'</span>
		<br class=\'clear\'/>
		<center>Click to View Map</center>
	';
	
	// Print out table row.
   	echo '
		<div class="mapThumb">
			<div class="mapImgThumb">
				<a title="'.$MapTooltip.'" href="maps.php?map='.$MapID.'" rel=tipsySW><img src="'.$MapImage['image'].'"></a>
			</div>
			<div class="mapName">
				<strong><a rel=tipsySW title="'.$MapTooltip.'" href="maps.php?map='.$MapID.'">'.$MapName.'</a></strong>
			</div>
		</div>
	';
}
echo "<div class='clear'></div></div></div>";

createPageLinks($totalpages, $currentpage, $range, $rowsperpage);

echo '</div>';
//*/
?>