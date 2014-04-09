<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SC2MDCL</title>
<link rel="stylesheet" type="text/css" href="js/tablesorter/themes/blue/style.css" />
<link rel="stylesheet" type="text/css" href="js/jquery-ui/jquery-ui-1.9.2.custom/development-bundle/themes/base/jquery-ui.css" />
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.js"></script> 
<script type="text/javascript" src="js/tablesorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/heatmap/heatmap.js"></script> 
<script type="text/javascript">
	$(function() {
		$( "#Matches" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#Matches li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	});
</script>
<script type="text/javascript">
	$(document).ready(function() { 
		// call the tablesorter plugin 
		$("table").tablesorter({ 
			// enable debug mode 
			debug: true 
		}); 
	}); 
</script>
<style>
	.ui-tabs-vertical { width: 55em; }
	.ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
	.ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
	.ui-tabs-vertical .ui-tabs-nav li a { display:block; }
	.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
	.ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 40em;}
</style>
</head>

<body>
<?

require_once 'parser.php';

///*

echo "<div id='Matches'> <ul>";

// Create a tab for each Match.

for ($Match = 0; $Match < $File; $Match++){
	echo "<li><a href='#Match_".$Match."'>Match ".($Match + 1)."</a></li>";
}

echo "</ul>";

// Create a page for each Match.

for ($Match = 0; $Match < $File; $Match++){
	
	echo "<div id='Match_".$Match."'>";
		
	// Print Match Title and Date.
		
	$anchor = 0;
	
	echo "<a id='".$Match."_".$anchor++."'></a><h1>".$MatchData->getValue($Match,0,2)."</h1><h2>".$MatchData->getValue($Match,0,1)."</h2>";
	
	// Create Heatmap
	
	echo "<div id='deathHeatmapArea_Match=".$Match."' style='".$Container[1]->heatmapStyle($Match)."'></div>";
	
	// Print a Table of Contents
	
	echo "<h3>Table of Contents:</h3><ul>";
	
	foreach($Container as $Data) {
		echo "<li><a href='#".$Match."_".$anchor++."'>". substr(get_class($Data), 0, -4) ." Data</a></li>";	
	}
	echo "</ul>";
	
	$anchor = 1;
	
	// Print the Match Data
	
	foreach($Container as $Data) {
		echo "<a id='".$Match."_".$anchor++."'><h3>". substr(get_class($Data), 0, -4) ." Data:</h3></a>";	
		echo "<a href='#".$Match."_0'>Back to Top</a><br /><br/>";
	
		$Data->buildTable($Match);
	}
	
	// Cleanup
	
	echo "</div>";

}

// Set up the Heatmapping Script.

echo "</div>";

echo "<script type='text/javascript'> \n\nwindow.onload = function(){ \n\n"; 

for ($Match = 0; $Match < $File; $Match++){
	
	$ID = "deathHeatmapArea_Match=".$Match;
	
	echo "var match_".$Match." = h337.create({'element':document.getElementById('".$ID."'), 'radius':10, 'visible':true}); \n\n
	
	var points_".$Match." = { max: 1, data: [\n".$Container[8]->heatmapTriggeringCoords($Match, $Container[1]->getValue($Match, 0, 2))."\n]\n}; \n\n
	
	match_".$Match.".store.setDataSet(points_".$Match."); \n\n";
}

echo "}; \n\n  </script>";

//*/

?>
</body>
</html>