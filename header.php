<?
// Print out the typical Doctype information and include our basic Stylesheet and commonly used scripts.
echo '
	<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width">
		<!-- Force latest IE rendering engine or ChromeFrame if installed -->
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
		<title>SC2MDCL - '.$PageName.'</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="icon" type="image/x-icon" href="img/icons/sc2.ico" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.1.0.min.js"></script>
		<script src="js/jquery.tipsy.js"></script>
		<link rel="stylesheet" type="text/css" href="css/tipsy.css" />
		<script type="text/javascript">
			$(function() {
				$(\'a[rel=tipsyW]\').tipsy({html: true, fade: true, gravity: \'w\', opacity: 0.95});
				$(\'a[rel=tipsySW]\').tipsy({html: true, fade: true, gravity: \'sw\', opacity: 0.95});
				$(\'a[rel=tipsyNW]\').tipsy({html: true, fade: true, gravity: \'nw\', opacity: 0.95});
			});
			$(document).ready(function() {
				$(\'#toggleRatio\').click(function(){
					$(\'#statsRatio > .hideme\').toggle();
				});
				$(\'#toggleLeague\').click(function(){
					$(\'#statsLeague > .hideme\').toggle();
				});
				$(\'#toggleRace\').click(function(){
					$(\'#statsRace > .hideme\').toggle();
				});
			});
		</script>
';

// Enable jQuery if the file is set to use it.
if (isset($jqueryui)){
	echo '
		<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
	';
}

if (isset($lightbox)){
	echo '
		<script src="js/jquery.colorbox.js"></script>
		<link href="css/colorbox.css" rel="stylesheet" />
		<script type="text/javascript">
			$(document).ready(function() {
				$(".lightbox").colorbox({scalePhotos:true, maxWidth:"95%", maxHeight:"95%"});
			});
		</script>
	';
}

// Enable the Heatmapping script if the file is set to use it.
if (isset($heatmap)){
	echo '
		<script type="text/javascript" src="js/heatmap.js"></script>
	'; 
}

// Enable the Tablesorter script if the file is set to use it.
if (isset($tablesorter)){
	echo '
		<link rel="stylesheet" type="text/css" href="js/tablesorter/themes/blue/style.css" />
		<script type="text/javascript" src="js/tablesorter/jquery.tablesorter.js"></script>
		<script type="text/javascript">
			$(document).ready(function() { 
				// call the tablesorter plugin 
				$(\'table\').tablesorter({ 
					// enable debug mode 
					debug: true 
				}); 
			}); 
		</script>
	';
}

if (isset($uploadify)){
	echo '
		<script type="text/javascript" src="js/uploadify/jquery.uploadify-3.1.min.js"></script>
		<script type="text/javascript" src="js/upload.js"></script>
	';
}

if (isset($sc2)){
	echo '
		<link rel="stylesheet" type="text/css" href="css/game-unit.css" />
		<script type="text/javascript" src="js/core.js"></script>
		<script type="text/javascript" src="js/tooltip.js"></script>
		<script type="text/javascript" src="js/model-rotator.js"></script>
	';
}

if (isset($gchart)){
	echo '
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	';
}

echo '
	</head>
	<body>
		<div id="bgOverlay">
		</div>
		<div id="wrapper">
			<div id="header">
				<div id="userinfo">
					<ul id="userinfo_username">
						<li>
							<a title="NYI" rel=tipsyNW class="username">Saeris</a>
						</li>
						<li class="brackets">
							<a title="NYI" rel=tipsyNW>Admin</a>
						</li>
						<li class="brackets">
							<a title="NYI" rel=tipsyNW>Settings</a>
						</li>
						<li class="brackets">
							<a title="NYI" rel=tipsyNW>Logout</a>
						</li>
					</ul>
					<ul id="userinfo_major">
						<li class="brackets">
							<strong><a href="upload.php">Upload</a></strong>
						</li>
					</ul>
					<ul id="userinfo_stats">
						<li id="stats_wins">
							<a title="NYI" rel=tipsyNW>Wins</a>: <span class="win">5</span>
						</li>
						<li id="stats_losses">
							<a title="NYI" rel=tipsyNW>Loses</a>: <span class="loss">10</span>
						</li>
						<li id="statsRatio">
							<a id="toggleRatio" title="Click to toggle Ratio Colors" rel=tipsyNW>Win %</a>: 	<span class="r50">0.50</span> 
																												<span class="r00 hideme">0.00</span> 
																												<span class="r10 hideme">0.10</span> 
																												<span class="r20 hideme">0.20</span> 
																												<span class="r30 hideme">0.30</span> 
																												<span class="r40 hideme">0.40</span> 
																												<span class="r50 hideme">0.50</span> 
																												<span class="r60 hideme">0.60</span> 
																												<span class="r70 hideme">0.70</span> 
																												<span class="r80 hideme">0.80</span> 
																												<span class="r90 hideme">0.90</span> 
																												<span class="r100 hideme">1.00</span> 
						</li>
						<li id="statsLeague">
							<a id="toggleLeague" title="Click to toggle League Colors" rel=tipsyNW>League</a>:	<span class="bronze">Bronze</span> 
																												<span class="silver hideme">Silver</span> 
																												<span class="gold hideme">Gold</span> 
																												<span class="platinum hideme">Platinum</span> 
																												<span class="diamond hideme">Diamond</span> 
																												<span class="masters hideme">Masters</span> 
																												<span class="grandmaster hideme">Grandmaster</span>
						</li>
						<li id="statsRace">
							<a id="toggleRace" title="Click to toggle Race Colors" rel=tipsyNW>Best Race</a>: 	<span class="Protoss">Protoss</span> 
																												<span class="Terran hideme">Terran</span>
																												<span class="Zerg hideme">Zerg</span>
																												<span class="Random hideme">Random</span>
						</li>
					</ul>
					<ul id="userinfo_minor">
						<li>
							<a title="NYI" rel=tipsyNW onmousedown="Stats(\'inbox\');">Inbox</a>
						</li> |
						<li>
							<a title="NYI" rel=tipsyNW onmousedown="Stats(\'uploads\');">Uploads</a>
						</li> |
						<li>
							<a title="NYI" rel=tipsyNW onmousedown="Stats(\'bookmarks\');">Bookmarks</a>
						</li>
					</ul>
				</div>
				<div id="logo">
					<a href="index.php"></a>
				</div>
				<div id="menu">
					<ul>
						<li id="nav_index">
							<a href="index.php">Home</a>
						</li>
						<li id="nav_about">
							<a href="about.php">About</a>
						</li>
						<li id="nav_regions">
							<a class="hidden" href="regions.php">Regions</a>
							<ul>
								<li>
									<a href="regions.php?region=NA">North America</a>
								</li>
								<li>
									<a href="regions.php?region=EU">Europe</a>
								</li>
								<li>
									<a href="regions.php?region=KR">Korea</a>
								</li>
								<li>
									<a href="regions.php?region=CH">China</a>
								</li>
								<li>
									<a href="regions.php?region=TW">Taiwan</a>
								</li>
								<li>
									<a href="regions.php?region=SEA">Southeast Asia</a>
								</li>
							</ul>
						</li>
						<liid="nav_leagues">
							<a class="hidden" href="leagues.php">Leagues</a>
							<ul>
								<li>
									<a href="leagues.php?league=grandmaster">Grandmaster</a>
								</li>
								<li>
									<a href="leagues.php?league=masters">Masters</a>
								</li>
								<li>
									<a href="leagues.php?league=diamond">Diamond</a>
								</li>
								<li>
									<a href="leagues.php?league=platinum">Platinum</a>
								</li>
								<li>
									<a href="leagues.php?league=gold">Gold</a>
								</li>
								<li>
									<a href="leagues.php?league=silver">Silver</a>
								</li>
								<li>
									<a href="leagues.php?league=bronze">Bronze</a>
								</li>
							</ul>
						</li>
						<li id="nav_modes">
							<a class="hidden" href="modes.php">Modes</a>
							<ul>
								<li>
									<a href="modes.php?mode=1v1">1v1</a>
								</li>
								<li>
									<a href="modes.php?mode=2v2">2v2</a>
								</li>
								<li>
									<a href="modes.php?mode=3v3">3v3</a>
								</li>
								<li>
									<a href="modes.php?mode=4v4">4v4</a>
								</li>
								<li>
									<a href="modes.php?mode=ffa">FFA</a>
								</li>
							</ul>
						</li>
						<li id="nav_maps">
							<a href="maps.php">Maps</a>
							<ul>
								<li>
									<a href="maps.php?players=2">2 Players</a>
								</li>
								<li>
									<a href="maps.php?players=4">4 Players</a>
								</li>
								<li>
									<a href="maps.php?players=6">6 Players</a>
								</li>
								<li>
									<a href="maps.php?players=8">8 Players</a>
								</li>
								<li>
									<a href="maps.php?players=ffa">FFA</a>
								</li>
							</ul>
						</li>
						<li id="nav_matches">
							<a href="matches.php">Matches</a>
						</li>
						<li id="nav_players">
							<a href="players.php">Players</a>
						</li>
						<li id="nav_races">
							<a href="races.php">Races</a>
							<ul>
								<li>
									<a href="races.php?race=protoss">Protoss</a>
								</li>
								<li>
									<a href="races.php?race=terran">Terran</a>
								</li>
								<li>
									<a href="races.php?race=zerg">Zerg</a>
								</li>
							</ul>
						</li>
						<li id="nav_units">
							<a href="units.php">Units</a>
						</li>
					</ul>
				</div>
			</div>
			<div id="content">
';
?>