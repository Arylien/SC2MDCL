<?

// Grab and assign the Match Variables.
$MatchData = selectFields($db, 'MatchData', array('Match_ID' => $Match));

$MatchID = $MatchData['Match_ID'];
$MatchName = $MatchData['Match_Name'];
$MatchDate = date('F jS, Y - g:i A',strtotime($MatchData['Match_Date']));
$GameMode = $Modes[$MatchData['Mode_ID']];
$GameSpeed = $Speeds[$MatchData['Game_Speed']];
// Grab and assign the Map variables.
$MapID = $MatchData['Map_ID'];
$MapData = selectFields($db, 'Maps', array('Map_ID' => $MapID));
$MapName = $MapData['Map_Name'];
$Minimap = getMapImage($MapName, 512);
$LargeMap = getMapImage($MapName, 1024);
$MapSize = $MapData['Map_Size_X']." ,".$MapData['Map_Size_Y'];
$MapPlayable = $MapData['Map_Size_Playable_X']." ,".$MapData['Map_Size_Playable_Y'];
$MapSpawns = '';
$MapSpawns = '';
$MapModes = '';
$MapAuthor = 'Blizzard';
$MapLink = '';
$MapVersion = '';
$MapDate = '';
$MapRating = '';
$MapBookmarks = '';
$Matches = getCountWhere($db, 'MatchData', 'Map_ID', $MapID);


// Grab and assign the Player Variables.

$Players = selectFields($db, 'PlayerData', array('Match_ID' => $Match), null, array('Player_Num' => 'ASC'));

$NumPlayers = count($Players);

$StartLocations = array();

foreach($Players as $Player){
	$StartLocationX = ($Player['Start_Location_X']); 
	$StartLocationY = ($MapData['Map_Size_Y'] - ($Player['Start_Location_Y']));
	$RatioX = ($Minimap['width'] / $MapData['Map_Size_X']);
	$RatioY = ($Minimap['height'] / $MapData['Map_Size_Y']);
	$w = 25;
	$h = 25;
	$x = round(($StartLocationX * $RatioX), 0) - ($w / 2);
	$y = round(($StartLocationY * $RatioY), 0) - ($h / 2);
	$StartLocations[] = '
		<div style="margin: 0; position: absolute; top: '.$x.'px; left: '.$y.'px; z-index: 100;">
			<img alt="Start Location" src="img/icons/startlocation.svg" width="'.$w.'px" height="'.$h.'px" />
		</div>
	';
}

// Echo out our page markup.
echo '
<div class="pagehead">
	<center><h1>['.$GameMode.'] '.$MapName.' - '.$MatchDate.'</h1></center>
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
					<li><a rel=tipsySW title="Click to show a heatmap of unit death locations." href="heatmap.php?page=Map&type=Deaths&map='.$MapID.'">Show Deaths</a></li>
					<li><a rel=tipsySW title="Click to show a heatmap of unit kill locations." href="heatmap.php?page=Map&type=Kills&map='.$MapID.'">Show Kills</a></li>
					<li><a rel=tipsySW title="Click to show a heatmap of deaths and kills. NYI" href="">Show Deaths + Kills</a></li>
				</ul>
			</div>
		</div>
	</div>
';

echo '	
	<div class="mapinfo">
		<div class="head">
			<center><strong>Match Info</strong></center>
		</div>
		<ul>
			<li>
				<strong>Map Name:</strong> 
				<span><a href="maps.php?map='.$MapID.'">'.$MapName.'</a></span>
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
				<strong>Match Date:</strong>
				<span>'.$MatchDate.'</span>
				<span class="clear"></span>
			</li>
			<li>
				<strong>Game Mode:</strong>
				<span>'.$GameMode.'</span>
				<span class="clear"></span>
			</li>
			<li>
				<strong>Players:</strong>
				<span>'.$NumPlayers.'</span>
				<span class="clear"></span>
			</li>
			<li>
				<strong>Game Speed:</strong>
				<span>'.$GameSpeed.'</span>
				<span class="clear"></span>
			</li>
		</ul>
		</ul>
	</div>
	<span class="clear"></span>
';

echo '
	<div class="mapinfo">
		<div class="head">
			<center><strong>Players</strong></center>
		</div>
		<table>
			<thead>
				<tr>
					<th>#</th>
					<th>Player Name</th>
					<th>Race</th>
					<th>Start Location</th>
				</tr>
			</thead>
			<tbody>
';

foreach($Players as $Player){
	echo '
				<tr>
					<td>'.$Player['Player_Num'].'</td>
					<td>
						<a rel=tipsySW title="View Player" style="color: #'.$Player['Color'].';" href="players.php?player='.$Player['Player_ID'].'">
							<strong>
								'.selectFields($db, 'Players', array('Player_ID' => $Player['Player_ID']), 'Player_Name').'
							</strong>
						</a>
					</td>
					<td>
						<center><a rel=tipsySW title="View Race" class="'.$Races[$Player['Race_ID']].'" href="races.php?race='.strtolower($Races[$Player['Race_ID']]).'">'.$Races[$Player['Race_ID']].'</a></center>
					</td>
					<td>
						<span>'.$Player['Start_Location_Y'].', '.$Player['Start_Location_Y'].'</span>
					</td>
				</tr>
	';
}

echo '
			</tbody>
		</table>
	</div>
';

echo '
</div>
<div class="thin clear"></div>
<div class="thin clear">
	<div class="box">
		<div class="head">
			<center><strong>Player Performance Overview</strong></center>
		</div>
		<div id="statsTabs">
			<ul class="tabs">
				<li class="tab"><a rel=tipsySW title="Actions Per Minute" href="graph.php?match='.$Match.'&graph=APM">APM</a></li>
				<li class="tab"><a rel=tipsySW title="Average Minerals Stockpiled" href="graph.php?match='.$Match.'&graph=AMS">AMS</a></li>
				<li class="tab"><a rel=tipsySW title="Average Vespene Stockpiled" href="graph.php?match='.$Match.'&graph=AVS">AVS</a></li>
				<li class="tab"><a rel=tipsySW title="Combat Efficiency" href="graph.php?match='.$Match.'&graph=CE">CE</a></li>
				<li class="tab"><a rel=tipsySW title="Supply Efficiency" href="graph.php?match='.$Match.'&graph=SE">SE</a></li>
				<li class="tab"><a rel=tipsySW title="Damage Dealt" href="graph.php?match='.$Match.'&graph=DD">DD</a></li>
				<li class="tab"><a rel=tipsySW title="Energy Spent" href="graph.php?match='.$Match.'&graph=ES">ES</a></li>
				<li class="tab"><a rel=tipsySW title="Economy Energy Available" href="graph.php?match='.$Match.'&graph=EEA">EEA</a></li>
				<li class="tab"><a rel=tipsySW title="Economy Energy Total" href="graph.php?match='.$Match.'&graph=EET">EET</a></li>
				<li class="tab"><a rel=tipsySW title="Life Spent" href="graph.php?match='.$Match.'&graph=LS">LS</a></li>
				<li class="tab"><a rel=tipsySW title="Damage Taken" href="graph.php?match='.$Match.'&graph=DT">DT</a></li>
				<li class="tab"><a rel=tipsySW title="Shields Damage Taken" href="graph.php?match='.$Match.'&graph=SDT">SDT</a></li>
				<li class="tab"><a rel=tipsySW title="Life Healed" href="graph.php?match='.$Match.'&graph=LH">LH</a></li>
				<li class="tab"><a rel=tipsySW title="Shields Regenerated" href="graph.php?match='.$Match.'&graph=SR">SR</a></li>
				<li class="tab"><a rel=tipsySW title="Minerals Gathered" href="graph.php?match='.$Match.'&graph=MG">MG</a></li>
				<li class="tab"><a rel=tipsySW title="Mineral Collection Rate" href="graph.php?match='.$Match.'&graph=MC">MC</a></li>
				<li class="tab"><a rel=tipsySW title="Minerals Received" href="graph.php?match='.$Match.'&graph=MR">MR</a></li>
				<li class="tab"><a rel=tipsySW title="Minerals Spent" href="graph.php?match='.$Match.'&graph=MS">MS</a></li>
				<li class="tab"><a rel=tipsySW title="Minerals Traded" href="graph.php?match='.$Match.'&graph=MT">MT</a></li>
				<li class="tab"><a rel=tipsySW title="Minerals Available" href="graph.php?match='.$Match.'&graph=MA">MA</a></li>
				<li class="tab"><a rel=tipsySW title="Vespene Gathered" href="graph.php?match='.$Match.'&graph=VG">VG</a></li>
				<li class="tab"><a rel=tipsySW title="Vespene Collection Rate" href="graph.php?match='.$Match.'&graph=VC">VC</a></li>
				<li class="tab"><a rel=tipsySW title="Vespene Received" href="graph.php?match='.$Match.'&graph=VR">VR</a></li>
			</ul>
			<br />
			<ul class="tabs">
				<li class="tab"><a rel=tipsySW title="Vespene Spent" href="graph.php?match='.$Match.'&graph=VS">VS</a></li>
				<li class="tab"><a rel=tipsySW title="Vespene Traded" href="graph.php?match='.$Match.'&graph=VT">VT</a></li>
				<li class="tab"><a rel=tipsySW title="Vespene Available" href="graph.php?match='.$Match.'&graph=VA">VA</a></li>
				<li class="tab"><a rel=tipsySW title="Supply Used" href="graph.php?match='.$Match.'&graph=SU">SU</a></li>
				<li class="tab"><a rel=tipsySW title="Supply Available" href="graph.php?match='.$Match.'&graph=SA">SA</a></li>
				<li class="tab"><a rel=tipsySW title="Supply Killed" href="graph.php?match='.$Match.'&graph=SK">SK</a></li>
				<li class="tab"><a rel=tipsySW title="Supply Lost" href="graph.php?match='.$Match.'&graph=SL">SL</a></li>
				<li class="tab"><a rel=tipsySW title="Army Size" href="graph.php?match='.$Match.'&graph=AS">AS</a></li>
				<li class="tab"><a rel=tipsySW title="Units Trained" href="graph.php?match='.$Match.'&graph=UT">UT</a></li>
				<li class="tab"><a rel=tipsySW title="Units Trained: Minerals Spent" href="graph.php?match='.$Match.'&graph=UTMS">UTMS</a></li>
				<li class="tab"><a rel=tipsySW title="Units Trained: Vespene Spent" href="graph.php?match='.$Match.'&graph=UTVS">UTVS</a></li>
				<li class="tab"><a rel=tipsySW title="Units Lost" href="graph.php?match='.$Match.'&graph=UL">UL</a></li>
				<li class="tab"><a rel=tipsySW title="Units Lost: Mineral Value" href="graph.php?match='.$Match.'&graph=ULMV">ULMV</a></li>
				<li class="tab"><a rel=tipsySW title="Units Lost: Vespene Value" href="graph.php?match='.$Match.'&graph=ULVV">ULVV</a></li>
				<li class="tab"><a rel=tipsySW title="Units Killed" href="graph.php?match='.$Match.'&graph=UK">UK</a></li>
				<li class="tab"><a rel=tipsySW title="Units Killed: Mineral Value" href="graph.php?match='.$Match.'&graph=UKMV">UKMV</a></li>
				<li class="tab"><a rel=tipsySW title="Units Killed: Vespene Value" href="graph.php?match='.$Match.'&graph=UKVV">UKVV</a></li>
				<li class="tab"><a rel=tipsySW title="Worker Count" href="graph.php?match='.$Match.'&graph=WC">WC</a></li>
				<li class="tab"><a rel=tipsySW title="Workers Trained" href="graph.php?match='.$Match.'&graph=WT">WT</a></li>
				<li class="tab"><a rel=tipsySW title="Workers Lost" href="graph.php?match='.$Match.'&graph=WL">WL</a></li>
				<li class="tab"><a rel=tipsySW title="Workers Killed" href="graph.php?match='.$Match.'&graph=WK">WK</a></li>
				<li class="tab"><a rel=tipsySW title="Buildings Built" href="graph.php?match='.$Match.'&graph=BB">BB</a></li>
			</ul>
			<br />
			<ul class="tabs">
				<li class="tab"><a rel=tipsySW title="Buildings Lost" href="graph.php?match='.$Match.'&graph=BL">BL</a></li>
				<li class="tab"><a rel=tipsySW title="Buildings Razed" href="graph.php?match='.$Match.'&graph=BR">BR</a></li>
				<li class="tab"><a rel=tipsySW title="Upgrades Researched" href="graph.php?match='.$Match.'&graph=UR">UR</a></li>
				<li class="tab"><a rel=tipsySW title="Upgrades Mineral Value" href="graph.php?match='.$Match.'&graph=UMV">UMV</a></li>
				<li class="tab"><a rel=tipsySW title="Upgrades Minerals Lost" href="graph.php?match='.$Match.'&graph=UML">UML</a></li>
				<li class="tab"><a rel=tipsySW title="Upgrades Vespene Value" href="graph.php?match='.$Match.'&graph=UVV">UVV</a></li>
				<li class="tab"><a rel=tipsySW title="Upgrades Vespene Lost" href="graph.php?match='.$Match.'&graph=UVL">UVL</a></li>
			</ul>
			<div id="container">
				<div id="graph" class="tab-box"></div>
			</div>
		</div>
		<script type="text/javascript">
			google.load(\'visualization\', \'1\', {packages:[\'corechart\']});  
			$(document).ready(function() { 
				$.getScript(\'graph.php?match='.$Match.'&graph=APM\');  
				$(\'#statsTabs li a\').click(function(event){
					var toLoad = $(this).attr(\'href\');  
					$(\'#load\').remove();
					$(\'#graph div\').remove();
					$(\'#graph\').append(\'<span id="load">LOADING...</span>\');  
					$(\'#load\').fadeIn(\'normal\');   
					$.getScript(toLoad, hideLoader()); 
					function hideLoader() {  
						$(\'#load\').fadeOut(\'normal\');  
					}  
					event.preventDefault();  
				});
				$(\'.mapoptions li a\').click(function(event){
					var toLoad = $(this).attr(\'href\');  
					$(\'#heatmap canvas\').remove();
					$(\'#load\').remove();
					$(\'#heatmap\').append(\'<span id=\"load\">LOADING...</span>\');  
					$(\'#load\').fadeIn(\'normal\');  
					$.getScript(toLoad,hideLoader());
					function hideLoader() {  
						$(\'#load\').fadeOut(\'normal\');  
					}  
					event.preventDefault(); 
				});
			});  
		</script>
	</div>
</div>
';

?>