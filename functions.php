<?
// Checks to see if an entry already exists in a table, used to check if a Match, Map, or Player already exists in the Database.
function entry_exists($Database, $Table, $Entry_Type, $Entry){
	// Prepare an SQL statement to execute.
	$stmt = $Database->prepare("SELECT * FROM $Table WHERE $Entry_Type = :Entry");
	// Bind the passed variable to paramter for the SQL statement.
	$stmt->bindParam(':Entry', $Entry);
	// Execute the statement.
	$stmt->execute();
	
	$fetch = $stmt->fetch();
	
	if($fetch[$Entry_Type]){
		return true;
	}else{
		return false;
	}
}

function createParams($Array = array()){
	/*///-Debug-//////
	echo '<u><strong><p>Executing function: '.__Function__.'</p></strong></u>';
	$time_start = microtime(true);
	//*///-Debug-//////
	
	// Takes Raw Insert data keys and changes the keys to BindParams
	$Params = array();
	
	foreach($Array as $Key => $Value){
		$Params[':'.$Key] = $Value;
	}
	
	/*///-Debug-//////
	echo '<p>Function: '.__Function__.' Data Array:</p>';
	foreach ($Params as $Key => $Value){
		echo '<p>'.$Key.' = '.$Value.'</p>';
	}
	//*///-Debug-//////
	
	/*///-Debug-//////
	$time_end = microtime(true);
	$time = round(($time_end - $time_start), 4);
	echo '<p>Completed '.__Function__.' in '. $time .' seconds.</p><br />';
	//*///-Debug-//////
	
	return $Params;
}

function insertSingle($Database, $Table = "", $Data = array()){
	/*///-Debug-//////
	echo '<u><strong><p>Executing function: '.__Function__.'</p></strong></u>';
	$time_start = microtime(true);
	//*///-Debug-//////
	
	$Params = createParams($Data);
	
	$sql = "INSERT INTO ".$Table." (".implode(', ', array_keys($Data)).") VALUES (".implode(', ', array_keys($Params)).")";
	$stmt = $Database->prepare($sql);
	
	/*///-Debug-//////
	echo '<p>Prepared statement: "'.$sql.'", proceeding to bring params.</p>';
	//*///-Debug-//////
	
	foreach ($Data as $Key => &$Value){
		/*///-Debug-//////
		echo '<p>Binding Param: :'.$Key.' = '.$Value.'</p>';
		//*///-Debug-//////
		$stmt->bindValue(':'.$Key, $Value);
	}
	
	try {
		$stmt->execute();
		$Entry_ID = (int) $Database->lastInsertId();
		/*///-Debug-//////
		$time_end = microtime(true);
		$time = round(($time_end - $time_start), 4);
		echo '<p>Success! Inserted Fields: ( '.implode(', ', array_keys($Data)).' ) with Values: ( '.implode(', ', array_values($Data)).' ) into Table: '.$Table.'</p><p>Returning insert ID: '.$Entry_ID.'</p><p>Completed '.__Function__.' in '. $time .' seconds.</p><br />';
		//*///-Debug-//////
		return $Entry_ID;
	} catch (PDOException $Exception){
    	echo '<p>ERROR occured while executing '.__FUNCTION__.' with message: '.$Exception->getMessage().'</p><br />';
		die;
	}
}

function insertMultiple($Database, $Table = "", $Data = array(array()), $Keys = array()){
	//*///-Debug-//////
	echo '<u><strong><p>Executing function: '.__Function__.'</p></strong></u>';
	$time_start = microtime(true);
	//*///-Debug-//////
	
	////////// Usage: //////////
	//
	// - $Database is the Database object on which the queries will be made.
	// - $Table is the Name of the Table within the Database that you want to perform a query on.
	// - $Keys is an array of the Co-Relational data. For Example, matching a Owner ID value in UnitData with the Player Entry_ID from PlayerData. 
	// 	 In this examples, $Entry_ID would return an array Key[Player Entry_ID] with Value equal to the last Insert ID (aka the UnitData Entry_ID).
	// - $Fields is an array of all the Column Names to pair with data for the Insert statement.
	// - $RawData is an array of all the each set of field values to insert. The function takes each array of values and implodes them into
	// 	 a comma separated list, which is then encapsulated in between parenthesis. this is done for each of the first level array elements.
	//
	////////// Example Result: //////////
	//
	// Statement for UnitData Insert:
	// 
	// "INSERT INTO UnitData ( Unit_ID, Unit_Type, Unit_Owner ) VALUES ( ( 173539331, 1, 2 ), ( 172490753, 2, 1 ), ( 96206862, 3, 2 ) )"
	//
	// Returned Value:
	//
	// $Entry_ID = array ( 2 = 1, 2 = 1, 3 = 2 ) 
	//
	// Where PlayerData Entry_ID = UnitData Entry_ID
	//
	// This associative data can then be used in the RawData of another Insert Multiple statement, such as with DeathData. Since the raw XML data
	// contained in Bank files associates units to Player #'s instead of unique MySQL entry ID's, this translates the game data relationships to
	// database data relationships. 
	//
	// Finally, this function is more efficient than doing a foreach with the insertSingle function, because insertMultiple accomplishes the same
	// result using only a single large query instead of many smaller ones.

	$Entry_ID = array();
	
	$i = 0;
	
	$Database->beginTransaction();
	foreach($Data as $Row){
		$Entry_ID[] = insertSingle($Database, $Table, $Row);
	}
	$Database->commit();
	
	//*///-Debug-//////
	$time_end = microtime(true);
	$time = round(($time_end - $time_start), 4);
	echo '<p>Success! Inserted all Rows.</p><p>Completed '.__Function__.' in '. $time .' seconds.</p><br />';
	//*///-Debug-//////
	
	return array_combine($Keys, $Entry_ID);
	
}

function updateField($Database, $Table = "", $Field, $Value, $Entry, $ID){
	
	/*///-Debug-//////
	echo '<u><strong><p>Executing function: '.__Function__.'</p></strong></u>';
	$time_start = microtime(true);
	//*///-Debug-//////
	
	$sql = "UPDATE ".$Table." SET ".$Field." = :value WHERE ".$Entry." = ".$ID;
	$stmt = $Database->prepare($sql);
	
	/*///-Debug-//////
	echo '<p>Prepared statement: "'.$sql.'", proceeding to bring params.</p>';
	//*///-Debug-//////
	
	$stmt->bindParam(':value', $Value);
	try {
		$stmt->execute();
	} catch (PDOException $Exception){
    	echo '<p>ERROR occured while executing '.__FUNCTION__.' with message: '.$Exception->getMessage().'</p>';
	}
}

function selectFields($Database, $Table = string, $WhereArgs, $Fields = null, $OrderBy = array(), $Start = null, $End = null){
	/*///-Debug-//////
	echo '<u><strong><p>Executing function: '.__Function__.'</p></strong></u>';
	$time_start = microtime(true);
	//*///-Debug-//////
	
	// If $Fields was given, use it for $Selection, else Select all fields, ie: SELECT (*)
	if(isset($Fields)){
		// If an array was passed, implode them, ie: SELECT ( Field1, Field2, FieldN ... )
		if (is_array($Fields)){
			$Selection = implode(', ', $Fields);
		// Else if only one field was passed, use it, ie: SELECT Field
		} elseif(is_string($Fields)){
			$Selection = $Fields;
		// If it's neither of these, $Fields is invalid, so die with an Error message.
		} else {
			echo '<p>ERROR: $Fields can only be an Array or a String!</p>';
			die;
		}
	} else {
		$Selection = '*';
	}
	
	// If an array of Where Arguments was passed, construct a WHERE clause. Automatically determine AND and IN, based on the size of the array and the values passed.
	if(count($WhereArgs) >= 1){
		$Where = ' WHERE ';
		$i = 1;
		foreach($WhereArgs as $Index => $Values){
			if(is_array($Values)){
				$params = array();
				for($v = 0; $v < count($Values); $v++){
					$params[] = ':'.$Index.$v;
				}
				$Where .= $Index.' IN ('.implode(',',$params).')'; 
			} else {
				$Where .= $Index.' = :'.$Index;
			}
			if(count($WhereArgs) > 1 && $i < count($WhereArgs)){
				$Where .= ' AND ';
				$i++;
			}
		}
		//echo '<p>Where Clause constructed: "'.$Where.'"</p>';
	} else {
		$Where = '';
	}
	
	// If defined, construct an ORDER BY arguement. If more than one arguement was supplied, comma separate them.
	if(count($OrderBy) > 1){
		$Order = ' ORDER BY ';
		foreach($OrderBy as $Column => $SortOrder){
			$Order = $Order.$Column.' '.$SortOrder.', ';
		}
		$Order = substr($Order, 0 ,-2);
	} elseif(count($OrderBy) == 1) {
		foreach($OrderBy as $Column => $SortOrder){
			$Order = ' ORDER BY '.$Column.' '.$SortOrder;
		}
	} else {
		$Order = '';
	}
	
	// If defined, construct a LIMIT arguement.
	if(isset($Start) && isset($End)){
		$Limit = ' LIMIT '.$Start.', '.$End;
	} else {
		$Limit = '';
	}
	
	$sql = "SELECT ".$Selection." FROM ".$Table.$Where.$Order.$Limit;
	$stmt = $Database->prepare($sql);
	
	/*///-Debug-//////
	echo '<p>Prepared statement: "<span style="color: red;">'.$sql.'</span>", proceeding to bind params.</p>';
	//*///-Debug-//////
	
	// If using an IN clause, loop through abd bind each parameter.
	if(isset($WhereArgs)){
		foreach($WhereArgs as $Index => $Values){
			if(is_array($Values)){
				foreach($Values as $Key => $Value){
					$stmt->bindValue(':'.$Index.$Key, $Value);
					//echo '<p>Bound Parameter :'.$Index.$Key.' = '.$Value.'</p>';
				}
			// Otherwise, bind the single parameter.
			} else {
				$stmt->bindValue(':'.$Index, $Values);
				//echo '<p>Bound Parameter :'.$Index.' = '.$Values.'</p>';
			}
		}
	}
	// Try to execute the SELECt statement, return an error upon failure and end execution.
	try {
		$stmt->execute();
	} catch (PDOException $Exception){
    	echo '<p>ERROR occured while executing '.__FUNCTION__.' with message: '.$Exception->getMessage().'</p>';
		die;
	}
	
	// Count the number of rows affected by the statement.
	$Rowcount = $stmt->rowCount();
	
	/*///-Debug-//////
	echo '<p>Row Count: '.$Rowcount.'</p>';
	//*///-Debug-//////
	
	// If more than one row was affected, Fetch All.
	if($Rowcount > 1){
		$Result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if(is_string($Fields)){
			$SingleField = array();
			foreach($Result as $Row){
				$SingleField[] = $Row[$Fields];
			}
			$Result = $SingleField;
		}
	} else {
		$Result = $stmt->fetch(PDO::FETCH_ASSOC);
		// If only a single field was requested, return that field as a variable, not an array.
		if(is_string($Fields)){
			$Result= $Result[$Fields];
		}
	}
	
	/*///-Debug-//////
	echo '<pre>';
	print_r(var_dump($Result), true);
	echo '</pre>';
	//*///-Debug-//////
	
	/*///-Debug-//////
	$time_end = microtime(true);
	$time = round(($time_end - $time_start), 4);
	echo '<p>Completed '.__Function__.' in '. $time .' seconds.</p><br />';
	//*///-Debug-//////
	
	return $Result;
}
function selection($Fields, $Type){
	if(isset($Fields)){
		// If an array was passed, implode them, ie: SELECT ( Field1, Field2, FieldN ... )
		if (is_array($Fields)){
			$Selection = implode(', ', $Fields);
		// Else if only one field was passed, use it, ie: SELECT Field
		} elseif(is_string($Fields)){
			$Selection = $Fields;
		// If it's neither of these, $Fields is invalid, so die with an Error message.
		} else {
			echo '<p>ERROR: $Fields can only be an Array or a String!</p>';
			die;
		}
	} else {
		$Selection = '*';
	}
	
	if(isset($Type)){
		if($Type === 'Count' || 'COUNT' || 'count'){
			$Result = 'COUNT('.$Selection.')';
		} elseif ($Type === 'Average' || 'AVERAGE' || 'average' || 'AVG' || 'avg'){
			$Result = 'AVG('.$Selection.')';
		} elseif ($Type === 'Sum' || 'SUM' || 'sum'){
			$Result = 'SUM('.$Selection.')';
		} elseif ($Type === 'Min' || 'MIN' || 'min'){
			$Result = 'MIN('.$Selection.')';
		} elseif ($Type === 'Max' || 'MAX' || 'max'){
			$Result = 'MAX('.$Selection.')';
		} else {
			$Result = $Selection;
		}
	} else {
		$Result = $Selection;
	}
	
	return $Result;
}
function getSumOfFieldByEntry($Database, $Table, $Entry_Type, $Entry, $Field){
	// Prepare an SQL statement to execute.
	$stmt = $Database->prepare("SELECT SUM($Field) FROM $Table WHERE $Entry_Type = :Entry");
	// Bind the passed variable to paramter for the SQL statement.
	$stmt->bindParam(':Entry', $Entry);
	// Execute the statement.
	$stmt->execute();
	
	$fetch = $stmt->fetch();
	
	return $fetch['SUM('.$Field.')'];
}
function getAvgOfFieldByEntry($Database, $Table, $Entry_Type, $Entry, $Field){
	// Prepare an SQL statement to execute.
	$stmt = $Database->prepare("SELECT AVG($Field) FROM $Table WHERE $Entry_Type = :Entry");
	// Bind the passed variable to paramter for the SQL statement.
	$stmt->bindParam(':Entry', $Entry);
	// Execute the statement.
	$stmt->execute();
	
	$fetch = $stmt->fetch();
	
	return $fetch['AVG('.$Field.')'];
}
function countRows($Database, $Table = ""){
	$sql = "SELECT COUNT(*) FROM ".$Table;
	$stmt = $Database->prepare($sql);
	try {
		$stmt->execute();
	} catch (PDOException $Exception){
    	echo '<p>ERROR occured while executing '.__FUNCTION__.' with message: '.$Exception->getMessage().'</p>';
	}
	$result = $stmt->fetch();	
	$count = $result[0];
	return $count;
}
function getCountWhere($Database, $Table = string, $Index, $Values){
	/*///-Debug-//////
	echo '<u><strong><p>Executing function: '.__Function__.'</p></strong></u>';
	$time_start = microtime(true);
	//*///-Debug-//////
	
	// Note: Fix this to also handle situations where both Index and Values are arrays.
	// If an array was passed for $Index, then construct an AND statement, ie: WHERE $Index1 = $Value1 AND $Index2 = $Value2 ...
	if(is_array($Index)){
		$In = false;
		$Where = $Index[0].' = :'.$Index[0];
		for($i = 1; $i < count($Index); $i++){
			$Where = $Where.' AND '.$Index[$i].' = :'.$Index[$i];
		}
	} else {
		// If an array was passed for $Values, then construct an IN statement, ie: IN ( Values1, Values2, ValuesN, ...)
		if(is_array($Values)){
			$In = true;
			$Where = $Index.' IN ( '.implode(', ', $Values).' )'; 
		} else {
			$In = false;
			$Where = $Index.' = :'.$Index;
		}
	}
	
	$sql = "SELECT COUNT(*) FROM ".$Table." WHERE ".$Where;
	
	$stmt = $Database->prepare($sql);
	
	// If using an IN clause, loop through abd bind each parameter.
	if($In){
		/*
		foreach($Values as $Key => $Value){
			//echo '<p>Bound '.($Key + 1).' = Value '.$Value.'</p>';
			$stmt->bindParam(($Key + 1), $Value);
		}
		*/
	// Otherwise, bind the single parameter.
	} else {
		if(is_array($Index)){
			for($i = 0; $i < count($Index); $i++){
				$stmt->bindParam(':'.$Index[$i], $Values[$i]);
			}
		} else {
			$stmt->bindParam(':'.$Index, $Values);
		}
	}
	
	/*///-Debug-//////
	echo '<p>Prepared statement: "'.$sql.'"</p>';
	//*///-Debug-//////
	
	try {
		$stmt->execute();
	} catch (PDOException $Exception){
    	echo '<p>ERROR occured while executing '.__FUNCTION__.' with message: '.$Exception->getMessage().'</p>';
		die;
	}
	
	$Result = $stmt->fetch();
	
	$Count = $Result[0];
	
	/*///-Debug-//////
	echo '<p>Returning Count: '.$Count.'</p>';
	//*///-Debug-//////
	
	/*///-Debug-//////
	$time_end = microtime(true);
	$time = round(($time_end - $time_start), 4);
	echo '<p>Completed '.__Function__.' in '. $time .' seconds.</p><br />';
	//*///-Debug-//////
	
	return $Count;
}
function getAvgWhere($Database, $Field = string, $Table = string, $Index = string, $Values){
	/*///-Debug-//////
	echo '<u><strong><p>Executing function: '.__Function__.'</p></strong></u>';
	$time_start = microtime(true);
	//*///-Debug-//////
	
	// TODO: Rewrite this to sanitize the values.
	if(is_string($Values) || is_int($Values)){
		$Where = $Index." = ".$Values;
	} elseif (is_array($Values)){
		$Where = $Index." IN ( ".implode(', ', $Values)." )";
	} else {
		echo '<p>ERROR: $Values must be either a String or an Array.</p>';
		die;
	}
	
	$sql = "SELECT AVG(".$Field.") FROM ".$Table." WHERE ".$Where;
	
	$stmt = $Database->prepare($sql);
	
	/*///-Debug-//////
	echo '<p>Prepared statement: "'.$sql.'", proceeding to bring params.</p>';
	//*///-Debug-//////
	
	try {
		$stmt->execute();
	} catch (PDOException $Exception){
    	echo '<p>ERROR occured while executing '.__FUNCTION__.' with message: '.$Exception->getMessage().'</p>';
		die;
	}
	
	$fetch = $stmt->fetch();
	
	/*///-Debug-//////
	$time_end = microtime(true);
	$time = round(($time_end - $time_start), 4);
	echo '<p>Completed '.__Function__.' in '. $time .' seconds.</p><br />';
	//*///-Debug-//////
	
	return $fetch['AVG('.$Field.')'];
}
function getSumWhere($Database, $Field = string, $Table = string, $Index = string, $Values){
	/*///-Debug-//////
	echo '<u><strong><p>Executing function: '.__Function__.'</p></strong></u>';
	$time_start = microtime(true);
	//*///-Debug-//////
	
	// TODO: Rewrite this to sanitize the values.
	if(is_string($Values) || is_int($Values)){
		$Where = $Index." = ".$Values;
	} elseif (is_array($Values)){
		$Where = $Index." IN ( ".implode(', ', $Values)." )";
	} else {
		echo '<p>ERROR: $Values must be either a String or an Array.</p>';
		die;
	}
	
	$sql = "SELECT SUM(".$Field.") FROM ".$Table." WHERE ".$Where;
	
	$stmt = $Database->prepare($sql);
	
	/*///-Debug-//////
	echo '<p>Prepared statement: "'.$sql.'", proceeding to bring params.</p>';
	//*///-Debug-//////
	
	try {
		$stmt->execute();
	} catch (PDOException $Exception){
    	echo '<p>ERROR occured while executing '.__FUNCTION__.' with message: '.$Exception->getMessage().'</p>';
		die;
	}
	
	$fetch = $stmt->fetch();
	
	/*///-Debug-//////
	$time_end = microtime(true);
	$time = round(($time_end - $time_start), 4);
	echo '<p>Completed '.__Function__.' in '. $time .' seconds.</p><br />';
	//*///-Debug-//////
	
	return $fetch['SUM('.$Field.')'];
}
// $Deaths = countEventsByUnitType($Database, 'DeathData', $ID, 'Triggering_Unit_ID');
// getFieldsByEntryID($Database, $Table = string, $Index = string, $Value = string, $Fields = null)
function getCountByUnitType($Database, $Table, $Search, $Field){
	$Entries = selectFields($Database, 'UnitData', $Search, 'Entry_ID');
	
	if(is_array($Entries)){
		$Count = getCountWhere($Database, $Table, $Field, $Entries);
	}else{
		$Count = 0;
	}
	
	return $Count;
}
// $AKD = round(getAvgByUnitType($Database, 'DeathData', 'Killing_Unit_ID', $ID, 'Distance_Between_Units'), 2);
// $ADD = round(getAvgByUnitType($Database, 'DeathData', 'Triggering_Unit_ID', $ID, 'Distance_Between_Units'), 2);
// getAvgWhere($Database, $Field = string, $Table, $Index = string, $Values)
function getAvgByUnitType($Database, $Table, $Entry_Type, $Search, $Field){
	$Entries = selectFields($Database, 'UnitData', $Search, 'Entry_ID');
	
	if(is_array($Entries)){
		$Average = getAvgWhere($Database, $Field, $Table, $Entry_Type, $Entries);
	}else{
		$Average = 0;
	}
	
	return $Average;
}

function mergeSimilarPoints($Points){
	$Results = array();
	for($i = 0; $i < count($Points); $i++) {
		$x = round($Points[$i]['x'] * 2) / 2;
		$y = round($Points[$i]['y'] * 2) / 2;
		$hash = (int)(($x*10) . ($y*10));
		$Results[$hash]['x'] = $x;
		$Results[$hash]['y'] = $y;
		$Results[$hash]['c'] = (empty($Results[$hash]['c']) ? 0 : $Results[$hash]['c']) + 1;
	}
  	
  	return $Results;
}

function getMapImage($Name = string, $Size, $Save = true){
	// Used to get an image of the specified Map in the specified size, or creates one if it doesn't already exist.
	
	require_once('classes.php');
	
	$Map_Name = str_ireplace(' ', '_', $Name);
	
	if((is_string($Size) && $Size === ('Tiny' || 'tiny')) || (is_int($Size) && $Size === 64)){
		$Type = 'tiny';
		$Dimensions = 64;
	} elseif ((is_string($Size) && $Size === ('Thumb' || 'thumb')) || (is_int($Size) && $Size === 128)){
		$Type = 'thumb';
		$Dimensions = 128;
	} elseif ((is_string($Size) && $Size === ('Small' || 'small')) || (is_int($Size) && $Size === 256)){
		$Type = 'small';
		$Dimensions = 256;
	} elseif ((is_string($Size) && $Size === ('Medium' || 'medium')) || (is_int($Size) && $Size === 512)){
		$Type = 'medium';
		$Dimensions = 512;
	} elseif ((is_string($Size) && $Size === ('Large' || 'large')) || (is_int($Size) && $Size === 1024)){
		$Type = 'large';
		$Dimensions = 1024;
	} elseif ((is_string($Size) && $Size === ('Fullsize' || 'fullsize' || 'full'))){
		$Image = 'img/maps/'.$Map_Name.'.jpg';
		return $Image;
	} else {
		echo '<p>ERROR: No Size defined in '.__Function__.'</p>';
		die;
	}
	
	$Image = new resizeImage();
		
	
	$File = 'img/maps/'.$Type.'/'.$Map_Name.'_'.$Type.'.jpg';
	
	// If the file of the specified size already exists, grab it's data, else create a file of that size and grab it's data.
	if(file_exists($File)){
		$Image->load($File);
		$ImageData['image'] = $File;
		$ImageData['height'] = $Image->getHeight();
		$ImageData['width'] = $Image->getWidth();
	}else{
		$Image->load('img/maps/'.$Map_Name.'.jpg');
		$Image->scaleProportional($Dimensions); 
		$Image->save('img/maps/'.$Type.'/'.$Map_Name.'_'.$Type.'.jpg');
		$ImageData['image'] = $File;
		$ImageData['height'] = $Image->getHeight();
		$ImageData['width'] = $Image->getWidth();
	}
	
	return $ImageData;
}

function createPageLinks($totalpages, $currentpage, $range, $rowsperpage){

	echo "<div class='linkbox'>";
	
	// if not on page 1, don't show back links
	if ($currentpage > 1) {
	   // show << link to go back to page 1
	   echo " <strong><a href='{$_SERVER['PHP_SELF']}?page=1'><< First</a></strong> ";
	   // get previous page num
	   $prevpage = $currentpage - 1;
	   // show < link to go back to 1 page
	   echo " <strong><a href='{$_SERVER['PHP_SELF']}?page=$prevpage'>< Previous</a></strong> ";
	}
	
	// loop to show links to range of pages around current page
	for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
		// if it's a valid page number...
		if (($x > 0) && ($x <= $totalpages)) {
			$min = (1 + (($x - 1) * $rowsperpage));
			$max = ($rowsperpage + (($x - 1) * $rowsperpage));
			// if we're on current page...
			if ($x == $currentpage) {
				// 'highlight' it but don't make a link
				echo " <strong>".$min."-".$max."</strong> ";
				// if not current page...
			} else {
				// make it a link
				if ($x > $currentpage) {
					echo "|";
				}
				echo " <strong><a href='{$_SERVER['PHP_SELF']}?page=$x'>".$min."-".$max."</a></strong> ";
				if ($x < $currentpage) {
					echo "|";
				}
			}
		
		}
	   
	}
					 
	// if not on last page, show forward and last page links        
	if ($currentpage != $totalpages) {
	   // get next page
	   $nextpage = $currentpage + 1;
		// echo forward link for next page 
	   echo " <strong><a href='{$_SERVER['PHP_SELF']}?page=$nextpage'>Next ></a></strong> ";
	   // echo forward link for lastpage
	   echo " <strong><a href='{$_SERVER['PHP_SELF']}?page=$totalpages'>Last >></a></strong> ";
	}
	
	echo "</div>";
}

function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);
	
	if(strlen($hex) == 3) {
	  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
	  $r = hexdec(substr($hex,0,2));
	  $g = hexdec(substr($hex,2,2));
	  $b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	//return implode(",", $rgb); // returns the rgb values separated by commas
	return $rgb; // returns an array with the rgb values
}

function rgb2hex($rgb) {
	$hex = "";
	$hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
	$hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
	$hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);
	
	return $hex;
}

function create_zip($files = array(),$destination = '',$keepstructure = false, $overwrite = false) {
	// Zip archive function modified based on script provided by David Walsh http://davidwalsh.name/create-zip-php
	
	if(file_exists($destination) && !$overwrite) { return false; }
	$valid_files = array();
	
	if(is_array($files)) {
		foreach($files as $file) {
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	
	if(count($valid_files)) {
		
		$zip = new ZipArchive();
		
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		
		foreach($valid_files as $file) {
			
			if ($keepstructure = true){
				$filename = basename($file);
			} else {
				$filename = $file;
			}
			$zip->addFile($file,$filename);
		}
		
		$zip->close();
	
		return file_exists($destination);
	
	} else {
		return false;
	}
}

?>
