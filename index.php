<?
//////////// Header Information ////////////
// Include essential scripts.
require_once 'config.php';
require_once 'lists.php';
require_once 'functions.php';
require_once 'classes.php';

// Include the page header and set script variables.
$PageName = "Home";
//$jqueryui = (bool) true;
//$heatmap = (bool) true;
//$tablesorter = (bool) true;
require_once 'header.php';
//////////// End of Header ////////////

//////////// Page Contents ////////////

// Gather Database Statistics
$db->beginTransaction();
$Count_Maps = countRows($db, 'Maps');
$Count_Matches = countRows($db, 'MatchData');
$Count_Players = countRows($db, 'Players');
$Count_Units_Created = countRows($db, 'UnitData');
$Count_Build_Events = countRows($db, 'BuildData');
$Count_Birth_Events = countRows($db, 'BirthData');
$Count_Death_Events = countRows($db, 'DeathData');
$Count_Periodic_Events = countRows($db, 'PeriodicData');
$Count_Research_Events = countRows($db, 'ResearchData');
$db->commit();

echo '
<center>
	<div class="boxnewusers">
		<div class="head">
			<strong>Welcome!</strong>
		</div>
		<div class="padnewusers">
			<p>This is a prototype website for displaying statistics gathered using the Melee Data Collection Library. Data collected from matches stored in SC2Bank files are parsed into a MySQL Database, from which statistics about that match and others are compiled where they can then be displayed via the web in the form of charts and graphs. This website offers both an easy to use and highly extensible tool for examining the gameplay of StarCraft 2. This prototype version serves as a proof of concept, and as such only provides a handful of examples for displaying this enormous amount of data, of which there are thousands of ways to represent it.
			<p/>
		</div>
	</div>
</center>
<div class="thin">
	<div class="sidebar">
		<div class="box">
			<div class="head">
				<strong>Database Statistics</strong>
			</div>
			<ul class="stats nobullet">
				<li>
					<strong>Maps:</strong>
					<span>'.$Count_Maps.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Matches:</strong>
					<span>'.$Count_Matches.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Players:</strong>
					<span>'.$Count_Players.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Units Created:</strong>
					<span>'.$Count_Units_Created.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Build Events:</strong>
					<span>'.$Count_Build_Events.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Birth Events:</strong>
					<span>'.$Count_Birth_Events.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Death Events:</strong>
					<span>'.$Count_Death_Events.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Periodic Events:</strong>
					<span>'.$Count_Periodic_Events.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Research Events:</strong>
					<span>'.$Count_Research_Events.'</span>
					<span class="clear"></span>
				</li>
			</ul>
		</div>
	</div>
	<div class="main_column">
		<div class="box">
';
		
// Create a list of the most recently added Maps.
echo '
			<div class="head">
				<strong>Top 8 Newest Maps</strong>
			</div>
			<div class="mapThumbs">
';

$top = 10;

// Get all the maps from the Database 
$Maps = selectFields($db, 'Maps', null, null, array('Map_ID' => 'Desc'), 0, 8);

// Print out Latest Maps
foreach($Maps as $Map){
	// Assign some of the map Variables.
	$MapID = $Map['Map_ID'];
   	$MapName = $Map['Map_Name'];
	$MapSize = $Map['Map_Size_X']." ,".$Map['Map_Size_Y'];
	$PlayableSize = $Map['Map_Size_Playable_X']." ,".$Map['Map_Size_Playable_Y'];
	$MapImage = getMapImage($MapName, 128);
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
				<a rel=tipsySW title="'.$MapTooltip.'" href="maps.php?map='.$MapID.'"><img src="'.$MapImage['image'].'"></a>
			</div>
			<div class="mapName">
				<strong><a rel=tipsySW title="'.$MapTooltip.'" href="maps.php?map='.$MapID.'">'.$MapName.'</a></strong>
			</div>
		</div>
	';
}
echo '
	<div class="clear">
	</div>
	</div>
	</div>
	<div class="box">
';

// Create a list of the latest Matches.

echo '
		<div class="head">
		<strong>Top 10 Latest Matches</strong>
	</div>
	<table>
		<thead>
			<tr class="colhead">
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

// Select the Match info from the Database.
$Matches = selectFields($db, 'MatchData', null, null, array('Match_Date' => 'DESC'), 0, $top);

// Print out 
foreach($Matches as $Match){
	// Row Values
	$MatchID = $Match['Match_ID'];
	$MapID = $Match['Map_ID'];
	$MapData = selectFields($db, 'Maps', array('Map_ID' => $MapID));
   	$MapName = $MapData['Map_Name'];
   	$MatchName = $Match['Match_Name'];
	$MatchDate = date('F jS, Y - g:i A',strtotime($Match['Match_Date']));
	$ModeID = $Match['Mode_ID'];
   	$Mode = selectFields($db, 'Modes', array('Mode_ID' => $ModeID), 'Mode_Name');
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
	</div>
	<div class="box">
';


// Create a list of the most revently added Players.

echo '
	<div class="head">
		<strong>Top 10 Recently Added Players</strong>
	</div>
	<table>
		<thead>
			<tr class="colhead">
				<td>Player Name</td>
				<td>Matches</td>
			</tr>
		</thead>
	<tbody>
';

// Get all the players from the Database 
$Players = selectFields($db, 'Players', null, null, array('Player_ID' => 'DESC'), 0, $top);

// Print out 
foreach($Players as $Player){
	// Row Values
	$Player_ID = $Player['Player_ID'];
	$Player_Name = $Player['Player_Name'];
	$Num_Matches = getCountWhere($db, 'Matches', 'Player_ID', $Player_ID);
	
	// Print out table row.
   	echo '
		<tr>
			<td width="90%">
				<strong>
					<a rel=tipsySW title="View Player" href="players.php?player='.$Player_ID.'">'.$Player_Name.'</a>
				</strong>
			</td>
			<td width="10%">
				'.$Num_Matches.'
			</td>
		</tr>
	';
}
echo '
			</tbody>
		</table>
	</div>
';


// Close the Main Column
echo '	
			</div>
		</div>
	</div>
';

//////////// End of Page////////////

// Include the page footer and perform any nescessary cleanup.
require_once 'footer.php';
?>