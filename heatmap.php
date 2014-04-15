<?
//////////// Header Information ////////////
header('Content-Type: text/javascript');
// Include essential scripts.
require_once 'config.php';
require_once 'lists.php';
require_once 'functions.php';
//////////// End of Header ////////////

//////////// Page Contents ////////////
$PageMap = false;
$PageMatch = false;
$Coords = array();
$jsData = array();

if (isset($_GET['page']) && is_string($_GET['page'])) {
	$Page = (string) $_GET['page'];
	if($Page === 'Map'){
		$PageMap = true;
	} elseif ($Page === 'Match') {
		$PageMatch = true;
	} else {
		die;
	}
}
if (isset($_GET['type']) && is_string($_GET['type'])) {
	$Type = (string) $_GET['type'];
	if($Type === 'Deaths' || 'Triggering_Unit'){
		$Type = 'Triggering_Unit';
	} elseif ($Type === 'Kills' || 'Killing_Unit') {
		$Type = 'Killing_Unit';
	} else {
		die;
	}
}
if (isset($_GET['map']) && is_numeric($_GET['map'])) {
	$Map = (int) $_GET['map'];
}
if (isset($_GET['match']) && is_numeric($_GET['match'])) {
	$Match = (int) $_GET['match'];
}


$db->beginTransaction();
$MapData = selectFields($db, 'Maps', array('Map_ID' => $Map));
$MapName = $MapData['Map_Name'];
$Minimap = getMapImage($MapName, 512);
if($PageMatch){
	$PlayerData = selectFields($db, 'PlayerData', array('Match_ID' => $Match), 'Player_Num');
	$Players = array();
	foreach($PlayerData as $Entry){
		$Players[$Entry] = $Entry;
	}
	$Units = array();
	foreach($Players as $ID){
		$Units[] = selectFields($db, 'UnitData', array('Unit_Owner' => $ID), 'Entry_ID');
	}
	foreach($Players as $Player){
		foreach($Units[$Player] as $Unit){
			$Event = selectFields($db, 'DeathData', array($Type.'_ID' => $Unit));
			if(isset($Event[$Type.'_Location_X']) && isset($Event[$Type.'_Location_Y'])){
				$EventX = $Event[$Type.'_Location_X'];
				$EventY = ($MapData['Map_Size_Y'] - $Event[$Type.'_Location_Y']);
				$Coords[] = array( 'x' => $EventX, 'y' => $EventY);
			}
		}
	}
} elseif ($PageMap) {
	$Matches = selectFields($db, 'MatchData', array('Map_ID' => $Map), 'Match_ID');
	foreach($Matches as $Match){
		$PlayerIDs[] = selectFields($db, 'PlayerData', array('Match_ID' => $Match), 'Entry_ID');
	}
	$Units = array();
	foreach($PlayerIDs as $ID){
		$Units[] = selectFields($db, 'UnitData', array('Unit_Owner' => $ID), 'Entry_ID');
	}
	$UnitIDs = array();
	foreach ($Units as $Match){
		foreach($Match as $Unit){
			$UnitIDs[] = (int) $Unit;
		}
	}
	foreach($UnitIDs as $Unit){
		$Event = selectFields($db, 'DeathData', array($Type.'_ID' => $Unit));
		if(isset($Event[$Type.'_Location_X']) && isset($Event[$Type.'_Location_Y'])){
			$EventX = $Event[$Type.'_Location_X'];
			$EventY = ($MapData['Map_Size_Y'] - $Event[$Type.'_Location_Y']);
			$Coords[] = array( 'x' => $EventX, 'y' => $EventY);
		}
	}
} else {
	die;
}

$db->commit();

/*///-Debug-//////
echo '<pre>';
print_r(var_dump($UnitIDs), true);
echo '</pre>';
//*///-Debug-//////

$Points = mergeSimilarPoints($Coords);
$Max = 0;		
foreach($Points as $Point){
	$RatioX = ($Minimap['width'] / $MapData['Map_Size_X']);
	$RatioY = ($Minimap['height'] / $MapData['Map_Size_Y']);
	$x = round(($Point['x'] * $RatioX), 2);
	$y = round(($Point['y'] * $RatioY), 2);
	$c = $Point['c'];
	if($c > $Max){
		$Max = $c;
	}
	$jsData[] = '{x:'.$x.',y:'.$y.',count:'.$c.'}';
}

echo '
var config = {
	element: document.getElementById("heatmap"),
	radius: 5,
	opacity: 50,
	visible: true
};

var heatmap = h337.create(config);

var data = {
	max: '.$Max.',
	data: [
		'.implode(', 
		', $jsData).'
	]
};					 
heatmap.store.setDataSet(data);
';

?>