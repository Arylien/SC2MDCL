<?
///*
// Count the number of Matches in the Database. 
$numrows = countRows($db, 'MatchData');

// Set the number of Matches to displayer per page.
$rowsperpage = 10;
// Find out how many pages there will be.
$totalpages = ceil($numrows / $rowsperpage);

$Sort = 'Match_Date';

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

// Create Table Structure

// Create a page header
echo '
	<center>
		<div class="boxnewusers">
			<div class="head">
				<strong>Matches</strong>
			</div>
			<div class="padnewusers">
				<p>This page contains a list of all the matches tracked in the database. Selecting a match will lead to a page with detailed statistics collected during that specific match.</p>
			</div>
		</div>
	</center>
	<div class="thin">
';

createPageLinks($totalpages, $currentpage, $range, $rowsperpage);

echo '
		<table>
			<thead>
				<tr class="colhead">
					<td>#</td>
					<td>Map</td>
					<td>Match Name</td>
					<td>Match Date</td>
					<td>Mode</td>
					<td>Players</td>
					<td>Speed</td>
				</tr>
			</thead>
			<tbody>
';

// Print out 
$Matches = selectFields($db, 'MatchData', null, null, array($Sort => 'DESC'), $offset, $rowsperpage);
$i = (($rowsperpage * $currentpage) - ($rowsperpage - 1));
foreach($Matches as $Match){
	// Row Values
	$MatchID = $Match['Match_ID'];
	$MapID = $Match['Map_ID'];
	$MapData = selectFields($db, 'Maps', array('Map_ID' => $MapID));
   	$MapName = $MapData['Map_Name'];
   	$MatchName = $Match['Match_Name'];
	$MatchDate = date('F jS, Y - g:i A',strtotime($Match['Match_Date']));
	$ModeID = $Match['Mode_ID'];
   	$Mode = selectFields($db, 'Modes', array('Mode_ID' => $ModeID), 'Mode_Name' );
	$NumPlayers = getCountWhere($db, 'PlayerData', 'Match_ID', $MatchID);
	$GameSpeed = $Speeds[$Match['Game_Speed']];
	$MapImage = getMapImage($MapName, 64);
	$MapSize = $MapData['Map_Size_Playable_X']." ,".$MapData['Map_Size_Y'];
	$PlayableSize = $MapData['Map_Size_Playable_Y']." ,".$MapData['Map_Size_Y'];
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
			<tr>
				<td>'.$i++.'</td>
				<td width="128px">
					<div class="mapImgTiny">
						<center>
							<a rel=tipsySW title="'.$MapTooltip.'" href="maps.php?map='.$MapID.'"><img src="'.$MapImage['image'].'"></a>
						</center>
					</div>
				</td>
				<td width="60%">
					<strong><a rel=tipsySW title="View Match" href="matches.php?match='.$MatchID.'">'.$MatchName.'</a></strong>
				</td>
				<td width="40%">
					'.$MatchDate.'
				</td>
				<td>
					<a rel=tipsySW title="View Mode" href="modes.php?mode='.$ModeID.'">'.$Mode.'</a>
				</td>
				<td>
					'.$NumPlayers.'
				</td>
				<td>
					'.$GameSpeed.'
				</td>
			</tr>
	';
}
echo '
		</tbody>
	</table>
';

createPageLinks($totalpages, $currentpage, $range, $rowsperpage);

//*/
?>