<?
/*///-Debug-//////
echo '<p>Generating '.$PageName.'</p>';
$time_start = microtime(true);
//*///-Debug-//////
$db->beginTransaction();

// Grab Data from the Database.
$MapData = selectFields($db, 'Maps', array('Map_ID' => $Map));

// Assign some of the map Variables.
$MapID = $Map;
$MapName = $MapData['Map_Name'];
$Minimap = getMapImage($MapName, 512);
$LargeMap = getMapImage($MapName, 1024);
$MapSize = $MapData['Map_Size_X']." ,".$MapData['Map_Size_Y'];
$MapPlayable = $MapData['Map_Size_Playable_X']." ,".$MapData['Map_Size_Playable_Y'];
$MapSpawns = '';
$MapModes = '';
$MapAuthor = 'Blizzard';
$MapLink = '';
$MapVersion = '';
$MapDate = '';
$MapRating = '';
$MapBookmarks = '';
$Matches = selectFields($db, 'MatchData', array('Map_ID' => $MapID), 'Match_ID');
$MatchesPlayed = count($Matches);
$RLobby = array();
$PLobby = array();
$TLobby = array();
$ZLobby = array();
$PMatches = array();
$TMatches = array();
$ZMatches = array();
if(count($Matches) <= 1){
$RLobby[] = selectFields($db, 'PlayerData', array('Lobby_Race_ID' => 1, 'Match_ID' => $Matches), selection(null,'Count'));
$PLobby[] = selectFields($db, 'PlayerData', array('Lobby_Race_ID' => 2, 'Match_ID' => $Matches), selection(null,'Count'));
$TLobby[] = selectFields($db, 'PlayerData', array('Lobby_Race_ID' => 3, 'Match_ID' => $Matches), selection(null,'Count'));
$ZLobby[] = selectFields($db, 'PlayerData', array('Lobby_Race_ID' => 4, 'Match_ID' => $Matches), selection(null,'Count'));
		
$PMatches[] = selectFields($db, 'PlayerData', array('Race_ID' => 2, 'Match_ID' => $Matches), selection(null,'Count'));
$TMatches[] = selectFields($db, 'PlayerData', array('Race_ID' => 3, 'Match_ID' => $Matches), selection(null,'Count'));
$ZMatches[] = selectFields($db, 'PlayerData', array('Race_ID' => 4, 'Match_ID' => $Matches), selection(null,'Count'));	
} else {
	foreach($Matches as $Match){	
		$RLobby[] = selectFields($db, 'PlayerData', array('Lobby_Race_ID' => 1, 'Match_ID' => $Match), selection(null,'Count'));
		$PLobby[] = selectFields($db, 'PlayerData', array('Lobby_Race_ID' => 2, 'Match_ID' => $Match), selection(null,'Count'));
		$TLobby[] = selectFields($db, 'PlayerData', array('Lobby_Race_ID' => 3, 'Match_ID' => $Match), selection(null,'Count'));
		$ZLobby[] = selectFields($db, 'PlayerData', array('Lobby_Race_ID' => 4, 'Match_ID' => $Match), selection(null,'Count'));
		
		$PMatches[] = selectFields($db, 'PlayerData', array('Race_ID' => 2, 'Match_ID' => $Match), selection(null,'Count'));
		$TMatches[] = selectFields($db, 'PlayerData', array('Race_ID' => 3, 'Match_ID' => $Match), selection(null,'Count'));
		$ZMatches[] = selectFields($db, 'PlayerData', array('Race_ID' => 4, 'Match_ID' => $Match), selection(null,'Count'));
	}
}
$db->commit();

/*///-Debug-//////
echo '<pre>';
print_r(var_dump($UnitIDs), true);
echo '</pre>';
//*///-Debug-//////

// Echo out our page markup.
echo '
<div class="pagehead">
	<center><h1>'.$MapName.'</h1></center>
</div>
<div class="thin">
';

echo '	
	<div class="minimap">
		<div class="head">
			<strong>'.$MapName.'</strong>
		</div>
		<div class="map">
			<div class="mapImgMedium">
				<a class="lightbox" title="'.$MapName.'" href="'.$LargeMap['image'].'">
					<div style="background-image: url(\''.$Minimap['image'].'\'); margin: auto; position: relative; height: '.$Minimap['height'].'px; width: '.$Minimap['width'].'px;" id="heatmap">	
					</div>
				</a>
			</div>
			<div class="mapoptions">
			<div class="head">
				<strong>Display Options</strong>
			</div>
			<ul>
				<li><a rel=tipsySW title="Click to show Map. Clears any overlays." href="">Show Map</a></li>
				<li><a rel=tipsySW title="Click to show Start Locations. NYI" href="">Show Start Locations</a></li>
				<li><a rel=tipsySW title="Click to show a heatmap of unit death locations." href="heatmap.php?page=Map&type=Deaths&map='.$Map.'">Show Deaths</a></li>
				<li><a rel=tipsySW title="Click to show a heatmap of unit kill locations." href="heatmap.php?page=Map&type=Kills&map='.$Map.'">Show Kills</a></li>
				<li><a rel=tipsySW title="Click to show a heatmap of deaths and kills. NYI" href="">Show Deaths + Kills</a></li>
			</ul>
		</div>
		</div>
	</div>
';
	
echo '	
		<div class="mapinfo">
			<div class="head">
				<center><strong>Map Info</strong></center>
			</div>
			<ul>
				<li><strong><u>Basic Info:</u></strong></li>
				<li>
					<strong>Map Name:</strong> 
					<span>'.$MapName.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Start Locations:</strong>
					<span>'.$MapSpawns.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Size:</strong>
					<span>'.$MapSize.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Playable Area:</strong>
					<span>'.$MapPlayable.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Supported Modes:</strong>
					<ul>
						'.$MapModes.'
					</ul>
					<span class="clear"></span>
				</li>
			</ul>
			<ul>
				<li><strong><u>Arcade Info:</u></strong></li>
				<li>
					<strong>Author:</strong> 
					<span>'.$MapAuthor.'</spawn>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Arcade Link:</strong>
					<span>'.$MapLink.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Latest Version:</strong>
					<span>'.$MapVersion.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Version Date:</strong>
					<span>'.$MapDate.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Rating:</strong>
					<span>'.$MapRating.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Matches Played:</strong> 
					<span>'.$MatchesPlayed.'</span>
					<span class="clear"></span>
				</li>
				<li>
					<strong>Bookmarks:</strong> 
					<span>'.$MapBookmarks.'</span>
					<span class="clear"></span>
				</li>
			</ul>
		</div>
		<span class="clear"></span>
	</div>
	<div class="thin clear"></div>
	<div class="thin">
		<div class="head">
			<strong><center>Map Race Breakdown</center></strong>
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
					['Protoss', 	".array_sum($PMatches)."],
					['Terran', 		".array_sum($TMatches)."],
					['Zerg', 		".array_sum($ZMatches)."]
				]);
			
				// Set Usage chart options
				var UsageOptions = {
						'backgroundColor'	: 	{fill:'transparent'},
						'is3D'				:	true,
						'legend'			:	{position:'none'},
						'pieSliceText'		:	'label',
						'width'				:	400,
						'height'			:	300,
						'colors'			:	['#0c95fa','#28ac44','#f58c46']
					};
				
				// Create the Lobby table.
				var Lobby = new google.visualization.DataTable();
				
				Lobby.addColumn('string', 'Race');
				Lobby.addColumn('number', 'Times Selected');
				Lobby.addRows([
					['Protoss', 	".array_sum($PLobby)."],
					['Terran', 		".array_sum($TLobby)."],
					['Zerg', 		".array_sum($ZLobby)."],
					['Random', 		".array_sum($RLobby)."]
				]);
			
				// Set Lobby chart options
				var LobbyOptions = {
						'backgroundColor'	: 	{fill:'transparent'},
						'is3D'				:	true,
						'legend'			:	{position:'none'},
						'pieSliceText'		:	'label',
						'width'				:	400,
						'height'			:	300,
						'colors'			:	['#0c95fa','#28ac44','#f58c46','#BE63B6']
					};
				
				// Instantiate and draw the Usage chart, passing in some options.
				var UsageChart = new google.visualization.PieChart(document.getElementById('Race_Usage'));
				UsageChart.draw(Usage, UsageOptions);
				
				// Instantiate and draw the Lobby chart, passing in some options.
				var LobbyChart = new google.visualization.PieChart(document.getElementById('Lobby_Selection'));
				LobbyChart.draw(Lobby, LobbyOptions);
			}
 
			$(document).ready(function() {
				$('.mapoptions li a').click(function(event){
					var toLoad = $(this).attr('href');  
					$('#heatmap canvas').remove();
					$('#load').remove();
					$('#heatmap').append('<span id=\"load\">LOADING...</span>');  
					$('#load').fadeIn('normal');  
					$.getScript(toLoad,hideLoader());
					function hideLoader() {  
						$('#load').fadeOut('normal');  
					}  
					event.preventDefault(); 
				});  
			});  
";

echo '
		</script>
	</div>
';

/*///-Debug-//////
$time_end = microtime(true);
$time = round(($time_end - $time_start), 4);
echo '<p>Completed in '. $time .' seconds.</p><br />';
//*///-Debug-//////

?>