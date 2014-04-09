<?
$db->beginTransaction();
// Gather Player Statistics
$Player = selectFields($db, 'Players', array('Player_ID' => $Player_ID));
$Name = $Player['Player_Name'];
$BnetID = $Player['Bnet_ID'];
$MatchesPlayed = getCountWhere($db, 'Matches', 'Player_ID', $Player_ID);
$MostPicked = 0;
// Determine the Most Picked Race
	$PickedCount = 0;
		$PickedR = getCountWhere($db, 'PlayerData', array('Player_ID', 'Lobby_Race_ID'), array($Player_ID, 1));
			if($PickedR > $PickedCount) { $PickedCount = $PickedR; $MostPicked = 1; }
		$PickedP = getCountWhere($db, 'PlayerData', array('Player_ID', 'Lobby_Race_ID'), array($Player_ID, 2));
			if($PickedP > $PickedCount) { $PickedCount = $PickedP; $MostPicked = 2; }
		$PickedT = getCountWhere($db, 'PlayerData', array('Player_ID', 'Lobby_Race_ID'), array($Player_ID, 3));
			if($PickedT > $PickedCount) { $PickedCount = $PickedT; $MostPicked = 3; }
		$PickedZ = getCountWhere($db, 'PlayerData', array('Player_ID', 'Lobby_Race_ID'), array($Player_ID, 4));
			if($PickedZ > $PickedCount) { $PickedCount = $PickedZ; $MostPicked = 4; }
	$PercentPicked = round((($PickedCount / $MatchesPlayed) * 100),2);
$MostPlayed = 0;
// Determine the Most Played Race
	$PlayedCount = 0;
		$PlayedP = getCountWhere($db, 'PlayerData', array('Player_ID', 'Race_ID'), array($Player_ID, 2));
			if($PlayedP > $PlayedCount) { $PlayedCount = $PlayedP; $MostPlayed = 2; }
		$PlayedT = getCountWhere($db, 'PlayerData', array('Player_ID', 'Race_ID'), array($Player_ID, 3));
			if($PlayedT > $PlayedCount) { $PlayedCount = $PlayedT; $MostPlayed = 3; }
		$PlayedZ = getCountWhere($db, 'PlayerData', array('Player_ID', 'Race_ID'), array($Player_ID, 4));
			if($PlayedZ > $PlayedCount) { $PlayedCount = $PlayedZ; $MostPlayed = 4; }
	$PercentPlayed = round((($PlayedCount / $MatchesPlayed) * 100),2);

$db->commit();

echo '<center>
	<div class="boxnewusers">
		<div class="head">
			<strong>Player Data</strong>
		</div>
		<div class="padnewusers">
			<p>This page acts as a hub for all the data gathered for a particular player.</p>
		</div>
	</div>
</center>
<div class="pagehead">
	<center><h1>'.$Player['Player_Name'].'</h1></center>
</div>
<div class="thin">
	<div class="thinSidebar floatLeft">
		<div class="head">
			<strong>Player Information</strong>
		</div>
		<ul class="stats nobullet">
			<li>
				<strong>Name:</strong>
				<span>'.$Name.'</span>
				<span class="clear"></span>
			</li>
			<li>
				<strong>Bnet ID:</strong>
				<span>'.$BnetID.'</span>
				<span class="clear"></span>
			</li>
			<li>
				<strong>Matches Played:</strong>
				<span>'.$MatchesPlayed.'</span>
				<span class="clear"></span>
			</li>
			<li>
				<strong>Most Picked Race:</strong>
				<span><a title="Matches: '.$PickedCount.' ('.$PercentPicked.'%)" rel=tipsySW class="'.$Races[$MostPicked].'">'.$Races[$MostPicked].'</a></span>
				<span class="clear"></span>
			</li>
			<li>
				<strong>Most Played Race:</strong>
				<span><a title="Matches: '.$PlayedCount.' ('.$PercentPlayed.'%)" rel=tipsySW class="'.$Races[$MostPlayed].'">'.$Races[$MostPlayed].'</a></span>
				<span class="clear"></span>
			</li>
		</ul>
	</div>
	<div class="wideColumn floatRight">
		<div class="head">
			<strong>Race Usage Overview</strong>
		</div>
		<table>
			<thead>
				<tr>
					<th>Lobby Selection:</th>
					<th>Actual Usage:</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div id="Lobby_Selection" style="width:400; height:300"></div>		
					</td>
					<td>
						<div id="Race_Usage" style="width:400; height:300"></div>
					</td>						
				</tr>
			</tbody>
		</table>
		<script type="text/javascript">
';

echo "			
			// Load the Visualization API and the piechart package.
			google.load('visualization', '1.0', {'packages':['corechart']});
			
			// Set a callback to run when the Google Visualization API is loaded.
			google.setOnLoadCallback(drawChart);
			
			// Callback that creates and populates a data table, 
			// instantiates the pie chart, passes in the data and
			// draws it.
			function drawChart() {
				
				// Create the Usage table.
				var Usage = new google.visualization.DataTable();
				
				Usage.addColumn('string', 'Race');
				Usage.addColumn('number', 'Matches Played');
				Usage.addRows([
					['Protoss', 	".$PlayedP."],
					['Terran', 		".$PlayedT."],
					['Zerg', 		".$PlayedZ."]
				]);
			
				// Set Usage chart options
				var UsageOptions = {
						'backgroundColor'	: 	{fill:'transparent'},
						'is3D'				:	true,
						'legend'			:	{textStyle:{color: 'white', fontSize: 10}},
						'pieSliceText'		:	'percentage',
						'width'				:	300,
						'colors'			:	['#0c95fa','#28ac44','#f58c46']
					};
				
				// Create the Lobby table.
				var Lobby = new google.visualization.DataTable();
				
				Lobby.addColumn('string', 'Race');
				Lobby.addColumn('number', 'Times Selected');
				Lobby.addRows([
					['Protoss', 	".$PickedP."],
					['Terran', 		".$PickedT."],
					['Zerg', 		".$PickedZ."],
					['Random', 		".$PickedR."]
				]);
			
				// Set Lobby chart options
				var LobbyOptions = {
						'backgroundColor'	: 	{fill:'transparent'},
						'is3D'				:	true,
						'legend'			:	{textStyle:{color: 'white', fontSize: 10}},
						'pieSliceText'		:	'percentage',
						'width'				:	300,
						'colors'			:	['#0c95fa','#28ac44','#f58c46','#BE63B6']
					};
				
				// Instantiate and draw the Usage chart, passing in some options.
				var UsageChart = new google.visualization.PieChart(document.getElementById('Race_Usage'));
				UsageChart.draw(Usage, UsageOptions);
				
				// Instantiate and draw the Lobby chart, passing in some options.
				var LobbyChart = new google.visualization.PieChart(document.getElementById('Lobby_Selection'));
				LobbyChart.draw(Lobby, LobbyOptions);
			}
";

echo '		
		</script>
	</div>	
</div>
<div class="thin clear"></div>
';

// Create a list of the latest Matches.
echo '
<div class="thin">
	<div class="head">
		<strong>Last 10 Matches</strong>
	</div>
	<table>
		<thead>
			<tr class="colhead">
				<td>Mode</td>
				<td>Map Name</td>
				<td>Match Date</td>
				<td>Players</td>
				<td>Speed</td>
				<td>Race</td>
			</tr>
		</thead>
	<tbody>
';

// Select the Match info from the Database.

$top = 10;

$db->beginTransaction();

$Matches = selectFields($db, 'Matches', array('Player_ID' => $Player_ID), null, array('Match_ID' => 'DESC'));
/*
$sql = "SELECT Match_ID FROM Matches WHERE Player_ID = :Player_ID LIMIT 0, $top";
$stmt = $db->prepare($sql);
$stmt->bindParam(':Player_ID', $Player_ID);
$stmt->execute();
*/

if(count($Matches) < 10){ 
	$Count = count($Matches); 
}else{ 
	$Count = 10;
}

//while($Matches = $stmt->fetch()){
for($i = 0; $i < $Count; $i++){
	if(isset($Matches[$i]['Match_ID'])){ 
		$Match = $Matches[$i]; 
	}else{ 
		$Match = $Matches;
	}
	
	$MatchData = selectFields($db, 'MatchData', array('Match_ID' => $Match['Match_ID']));
	$PlayerData = selectFields($db, 'PlayerData', array('Match_ID' => $Match['Match_ID'], 'Player_ID' => $Player_ID));
	
	// Note: This is a temporary fix for AI players, which can appear multiple times per Match. For now, we just grab their first appearance in that match.
	if(isset($PlayerData[0])){
		$Entry = $PlayerData[0];
	} else {
		$Entry = $PlayerData;
	}
	
	// Row Values
	$Match_ID = $MatchData['Match_ID'];
	$Map_ID = $MatchData['Map_ID'];
	$Map_Name = selectFields($db, 'Maps', array('Map_ID' => $Map_ID), 'Map_Name' );
	$Match_Date = date('F jS, Y - g:i A',strtotime($MatchData['Match_Date']));
	$Mode_ID = $MatchData['Mode_ID'];
	$Mode = selectFields($db, 'Modes', array('Mode_ID' => $Mode_ID), 'Mode_Name' );
	$Num_Players = getCountWhere($db, 'PlayerData', 'Match_ID', $Match_ID);
	$Game_Speed = $Speeds[$MatchData['Game_Speed']];
	$Player_Race = $Entry['Race_ID'];
	$Lobby_Race = $Entry['Lobby_Race_ID'];
	
	// Print out table row.
	echo '
		<tr>
			<td><a rel=tipsySW title="View Mode" href="modes.php?mode='.$Mode_ID.'">'.$Mode.'</a></td>
			<td><a rel=tipsySW title="View Map" href="maps.php?map='.$Map_ID.'">'.$Map_Name.'</a></td>
			<td><a rel=tipsySW title="View Match" href="matches.php?match='.$Match_ID.'">'.$Match_Date.'</a></td>
			<td>'.$Num_Players.'</td>
			<td>'.$Game_Speed.'</td>
			<td><a rel=tipsySW title="Lobby Race: '.$Races[$Lobby_Race].', Click to view Race Statistics" class="'.$Races[$Player_Race].'" href="races.php?race='.strtolower($Races[$Player_Race]).'">'.$Races[$Player_Race].'</a></td>
		</tr>
	';
}

$db->commit();

echo '
		</tbody>
	</table>
</div>
';

echo '
	<div class="thin clear">
		<div class="head">
			<strong>Unit Usage Statistics</strong>
		</div>
';

$TechTree = new TechTree($db);
$TechTree->playerUnitTable($db, $Player_ID);

echo '	
	</div>
';

// Close the Main Column
echo '
		</div>
	</div>
</div>
';

?>