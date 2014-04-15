<?
//////////// Header Information ////////////
header('Content-Type: text/javascript');
// Include essential scripts.
require_once 'config.php';
require_once 'lists.php';
require_once 'functions.php';
//////////// End of Header ////////////

//////////// Page Contents ////////////
if (isset($_GET['match']) && is_numeric($_GET['match'])) {
	$Match = (int) $_GET['match'];
	
	// Grab the players from the specified match.
	$Players = selectFields($db, 'PlayerData', array('Match_ID' => $Match), null, array('Player_Num' => 'ASC'));
}

if (isset($_GET['graph']) && is_string($_GET['graph'])) {
	$Graph = (string) $_GET['graph'];
}

switch($Graph){
	case 'APM':
		$Stat = 'APM';
		$Title = 'Actions Per Minute';
		$vAxisTitle = 'Actions Per Minute';
		$hAxisTitle = 'Game Time';
		break;
	case 'AMS':
		$Stat = 'Average_Minerals_Stockpiled';
		$Title = 'Average Minerals Stockpiked';
		$vAxisTitle = 'Average Minerals Stockpiled';
		$hAxisTitle = 'Game Time';
		break;
	case 'AVS':
		$Stat = 'Average_Vespene_Stockpiled';
		$Title = 'Average Vespene Stockpiled';
		$vAxisTitle = 'Average Vespene Stockpiled';
		$hAxisTitle = 'Game Time';
		break;
	case 'CE':
		$Stat = 'Combat_Efficiency';
		$Title = 'Combat Efficiency';
		$vAxisTitle = 'Efficiency Score';
		$hAxisTitle = 'Game Time';
		break;
	case 'SE':
		$Stat = 'Supply_Efficiency';
		$Title = 'Supply Efficiency';
		$vAxisTitle = 'Efficiency Score';
		$hAxisTitle = 'Game Time';
		break;
	case 'DD':
		$Stat = 'Damage_Dealt';
		$Title = 'Damage Dealt';
		$vAxisTitle = 'Damage';
		$hAxisTitle = 'Game Time';
		break;
	case 'ES':
		$Stat = 'Energy_Spent';
		$Title = 'Energy Spent';
		$vAxisTitle = 'Energy';
		$hAxisTitle = 'Game Time';
		break;
	case 'EEA':
		$Stat = 'Economy_Energy_Available';
		$Title = 'Economy Energy Available';
		$vAxisTitle = 'Energy';
		$hAxisTitle = 'Game Time';
		break;
	case 'EET':
		$Stat = 'Economy_Energy_Total';
		$Title = 'Economy Energy Total';
		$vAxisTitle = 'Energy';
		$hAxisTitle = 'Game Time';
		break;
	case 'LS':
		$Stat = 'Life_Spent';
		$Title = 'Life Spent';
		$vAxisTitle = 'Life';
		$hAxisTitle = 'Game Time';
		break;
	case 'DT':
		$Stat = 'Damage_Taken';
		$Title = 'Damage Taken';
		$vAxisTitle = 'Damage';
		$hAxisTitle = 'Game Time';
		break;
	case 'SDT':
		$Stat = 'Shields_Damage_Taken';
		$Title = 'Sheilds Damage Taken';
		$vAxisTitle = 'Damage';
		$hAxisTitle = 'Game Time';
		break;
	case 'LH':
		$Stat = 'Life_Healed';
		$Title = 'Life Healed';
		$vAxisTitle = 'Life';
		$hAxisTitle = 'Game Time';
		break;
	case 'SR':
		$Stat = 'Shields_Regenerated';
		$Title = 'Shields Regenerated';
		$vAxisTitle = 'Shields';
		$hAxisTitle = 'Game Time';
		break;
	case 'MG':
		$Stat = 'Minerals_Gathered';
		$Title = 'Minerals Gathered';
		$vAxisTitle = 'Minerals';
		$hAxisTitle = 'Game Time';
		break;
	case 'MC':
		$Stat = 'Minerals_Collection_Rate';
		$Title = 'Mineral Collection Rate';
		$vAxisTitle = 'Collection Rate';
		$hAxisTitle = 'Game Time';
		break;
	case 'MR':
		$Stat = 'Minerals_Received';
		$Title = 'Minerals Received';
		$vAxisTitle = 'Minerals';
		$hAxisTitle = 'Game Time';
		break;
	case 'MS':
		$Stat = 'Minerals_Spent';
		$Title = 'Minerals Spent';
		$vAxisTitle = 'Minerals';
		$hAxisTitle = 'Game Time';
		break;
	case 'MT':
		$Stat = 'Minerals_Traded';
		$Title = 'Minerals Traded';
		$vAxisTitle = 'Minerals';
		$hAxisTitle = 'Game Time';
		break;
	case 'MA':
		$Stat = 'Minerals_Available';
		$Title = 'Minerals Available';
		$vAxisTitle = 'Minerals';
		$hAxisTitle = 'Game Time';
		break;
	case 'VG':
		$Stat = 'Vespene_Gathered';
		$Title = 'Vespene Gathered';
		$vAxisTitle = 'Vespene';
		$hAxisTitle = 'Game Time';
		break;
	case 'VC':
		$Stat = 'Vespene_Collection_Rate';
		$Title = 'Vespene Collection Rate';
		$vAxisTitle = 'Collection Rate';
		$hAxisTitle = 'Game Time';
		break;
	case 'VR':
		$Stat = 'Vespene_Received';
		$Title = 'Vespene Received';
		$vAxisTitle = 'Vespene';
		$hAxisTitle = 'Game Time';
		break;
	case 'VS':
		$Stat = 'Vespene_Spent';
		$Title = 'Vespene Spent';
		$vAxisTitle = 'Vespene';
		$hAxisTitle = 'Game Time';
		break;
	case 'VT':
		$Stat = 'Vespene_Traded';
		$Title = 'Vespene Traded';
		$vAxisTitle = 'Vespene';
		$hAxisTitle = 'Game Time';
		break;
	case 'VA':
		$Stat = 'Vespene_Available';
		$Title = 'Vespene Available';
		$vAxisTitle = 'Vespene';
		$hAxisTitle = 'Game Time';
		break;
	case 'SU':
		$Stat = 'Supply_Used';
		$Title = 'Supply Used';
		$vAxisTitle = 'Supply';
		$hAxisTitle = 'Game Time';
		break;
	case 'SA':
		$Stat = 'Supply_Available';
		$Title = 'Supply Available';
		$vAxisTitle = 'Supply';
		$hAxisTitle = 'Game Time';
		break;
	case 'SK':
		$Stat = 'Supply_Killed';
		$Title = 'Supply Killed';
		$vAxisTitle = 'Supply';
		$hAxisTitle = 'Game Time';
		break;
	case 'SL':
		$Stat = 'Supply_Lost';
		$Title = 'Supply Lost';
		$vAxisTitle = 'Supply';
		$hAxisTitle = 'Game Time';
		break;
	case 'AS':
		$Stat = 'Army_Size';
		$Title = 'Army Size';
		$vAxisTitle = 'Army Size';
		$hAxisTitle = 'Game Time';
		break;
	case 'UT':
		$Stat = 'Units_Trained';
		$Title = 'Units Trained';
		$vAxisTitle = '# of Units Trained';
		$hAxisTitle = 'Game Time';
		break;
	case 'UTMS':
		$Stat = 'Units_Trained_Minerals_Spent';
		$Title = 'Units Trained: Minerals Spent';
		$vAxisTitle = 'Minerals Spent';
		$hAxisTitle = 'Game Time';
		break;
	case 'UTVS':
		$Stat = 'Units_Trained_Vespene_Spent';
		$Title = 'Units Trained: Vespene Spent';
		$vAxisTitle = 'Vespene Spent';
		$hAxisTitle = 'Game Time';
		break;
	case 'UL':
		$Stat = 'Units_Lost';
		$Title = 'Units Lost';
		$vAxisTitle = '# of Units Lost';
		$hAxisTitle = 'Game Time';
		break;
	case 'ULMV':
		$Stat = 'Units_Lost_Mineral_Value';
		$Title = 'Units Lost: Mineral Value';
		$vAxisTitle = 'Mineral Value';
		$hAxisTitle = 'Game Time';
		break;
	case 'ULVV':
		$Stat = 'Units_Lost_Vespene_Value';
		$Title = 'Units Lost: Vespene Value';
		$vAxisTitle = 'Vespene Value';
		$hAxisTitle = 'Game Time';
		break;
	case 'UK':
		$Stat = 'Units_Killed';
		$Title = 'Units Killed';
		$vAxisTitle = '# of Units Killed';
		$hAxisTitle = 'Game Time';
		break;
	case 'UKMV':
		$Stat = 'Units_Killed_Mineral_Value';
		$Title = 'Units Killed: Mineral Value';
		$vAxisTitle = 'Mineral Value';
		$hAxisTitle = 'Game Time';
		break;
	case 'UKVV':
		$Stat = 'Units_Killed_Vespene_Value';
		$Title = 'Units Killed: Vespene Value';
		$vAxisTitle = 'Vespene Value';
		$hAxisTitle = 'Game Time';
		break;
	case 'WC':
		$Stat = 'Worker_Count';
		$Title = 'Worker Count';
		$vAxisTitle = 'Workers';
		$hAxisTitle = 'Game Time';
		break;
	case 'WT':
		$Stat = 'Workers_Trained';
		$Title = 'Workers Trained';
		$vAxisTitle = 'Workers';
		$hAxisTitle = 'Game Time';
		break;
	case 'WL':
		$Stat = 'Workers_Lost';
		$Title = 'Workers Lost';
		$vAxisTitle = 'Workers';
		$hAxisTitle = 'Game Time';
		break;
	case 'WK':
		$Stat = 'Workers_Killed';
		$Title = 'Workers Killed';
		$vAxisTitle = 'Workers';
		$hAxisTitle = 'Game Time';
		break;
	case 'BB':
		$Stat = 'Structures_Built';
		$Title = 'Buildings Built';
		$vAxisTitle = 'Buildings';
		$hAxisTitle = 'Game Time';
		break;
	case 'BL':
		$Stat = 'Structures_Lost';
		$Title = 'Buildings Lost';
		$vAxisTitle = 'Buildings';
		$hAxisTitle = 'Game Time';
		break;
	case 'BR':
		$Stat = 'Structures_Razed';
		$Title = 'Buildings Razed';
		$vAxisTitle = 'Buildings';
		$hAxisTitle = 'Game Time';
		break;
	case 'UR':
		$Stat = 'Upgrades_Researched';
		$Title = 'Upgrades Researched';
		$vAxisTitle = 'Upgrades';
		$hAxisTitle = 'Game Time';
		break;
	case 'UMV':
		$Stat = 'Upgrades_Mineral_Value';
		$Title = 'Upgrades Mineral Value';
		$vAxisTitle = 'Mineral Value';
		$hAxisTitle = 'Game Time';
		break;
	case 'UML':
		$Stat = 'Upgrades_Minerals_Lost';
		$Title = 'Upgrades Minerals Lost';
		$vAxisTitle = 'Minerals Lost';
		$hAxisTitle = 'Game Time';
		break;
	case 'UVV':
		$Stat = 'Upgrades_Vespene_Value';
		$Title = 'Upgrades Vespene Value';
		$vAxisTitle = 'Vespene Value';
		$hAxisTitle = 'Game Time';
		break;
	case 'UVL':
		$Stat = 'Upgrades_Vespene_Lost';
		$Title = 'Upgrades Vespene Lost';
		$vAxisTitle = 'Vespene Lost';
		$hAxisTitle = 'Game Time';
		break;
	default:
		die;
}

// Prepare the graph data.

$PeriodicEvents = array();
$Colors = array();
$PlayerList = array();
$PeriodicData = array();

foreach($Players as $Player){
	$PeriodicEvents[$Player['Player_Num']] = selectFields($db, 'PeriodicData', array('Player_Num' => $Player['Entry_ID']), null, array('Event_ID' => 'ASC'));
	$Colors[] = "'#".$Player['Color']."'";
	$PlayerList[] = "'".selectFields($db, 'Players', array('Player_ID' => $Player['Player_ID']), 'Player_Name')."'";
}

foreach($Players as $Player){
	$Time = 6;
	foreach($PeriodicEvents[$Player['Player_Num']] as $Event){
		$PeriodicData[$Time][$Player['Player_Num']] = $Event;
		$Time += 6;
	}
}

$GraphData = array();

$Time = 6;
foreach($PeriodicData as $Event){
	$data = '["'.gmdate("H:i:s", $Time).'"';
	foreach($Event as $Player){
		$data .= ', '.$Player[$Stat];
	}
	$GraphData[] = $data.' ]';
	$Time += 6;
}

echo "
var data = google.visualization.arrayToDataTable([
	['Game Time', ".implode(',', $PlayerList)."],
	".implode(',
	', $GraphData)."
]);
						
var options = {
	'height'				:	600,	
	'width'					:	'100%',
	'backgroundColor'		: 	{fill: 'transparent'},
	'curveType'				:	'function',
	'interpolateNulls'		:	true,
	'title'					:	'".$Title."',
	'titleTextStyle'		:	{color: '#00D683'},
	'legend'				:	{
									position: 'right', 
									textStyle: {color: '#6EA6CA', fontSize: 10}
								},
	'legend.alignment'		:	'center',
	'vAxis'					:	{
									title: '".$vAxisTitle."', 
									titleTextStyle: {color: '#6EA6CA'}, 
									textStyle: {color: '#3D5F78'},
									gridlines: {color: '#3D5F78', count: 10}
								},
	'hAxis'					:	{
									title: '".$hAxisTitle."',
									titleTextStyle: {color: '#6EA6CA'},
									textStyle: {color: '#3D5F78'}, 
									viewWindowMode: 'maximized',
									slantedText: false,
									maxAlternation: 1,
									gridlines: {color: '#3D5F78', count: 10}
								},
	'colors'				:	[".implode(',', $Colors)."]
};

var chart = new google.visualization.LineChart(document.getElementById('graph'));
chart.draw(data, options);
";
?>