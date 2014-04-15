<?
require_once 'config.php';
require_once 'lists.php';
require_once 'functions.php';

// Increase script memory limit to allow processing of many files.

ini_set("memory_limit","512M");
ini_set('max_execution_time', 300);

$regex = "/\[(.*?)\]/";

// Create Data Object Containers

$MatchData = new MatchData();

$MapData = new MapData();
	
$PlayerData = new PlayerData();

$UnitData = new UnitData();

$AbilityData = new AbilityData();

$IdleData = new IdleData();

$BuildData = new BuildData();

$BirthData = new BirthData();

$DeathData = new DeathData();

$ResearchData = new ResearchData();

$PeriodicData = new PeriodicData();

$i = 0;

$Container = array (
	$i++ => $MatchData,
	$i++ => $MapData,
	$i++ => $PlayerData,
	$i++ => $UnitData,
	$i++ => $AbilityData,
	$i++ => $IdleData,
	$i++ => $BuildData,
	$i++ => $BirthData,
	$i++ => $DeathData,
	$i++ => $ResearchData,
	$i++ => $PeriodicData
);

// Count Number of Files Processed

$File = 0;

// Data Parsing Function. Takes the raw XML Data, creates an array of values, and inserts the values into a container.

function parseData($File, $Index, $Container, $Key, $Value){
	
	$Splitter = "|";
	
	$Entry = 0;
	
	foreach($Key as $Event){
		
		$Data = explode($Splitter, $Value[$Entry]['text'], -1);
		
		if($Index = 0 || 1){
		$Container->addData($File, $Entry++, $Data);
		}else{
		$Container->addData($File, ($Data[0] - 1), $Data);
		$Entry++;
		}
	}
}

// Loop through each Bank File and read it's contents.
foreach ($files as $bank) { 
	// Create a new Log Div
	echo '
		<div id="log-'.$File.'">
	';
	
	$Match_Name = substr(basename($bank, ".SC2Bank"), 4);
	
	// If the match already exists in the database, skip it.
	if(entry_exists($db,"MatchData","Match_Name",$Match_Name) === true){
		
		echo '
				<h3>Match '.$Match_Name.' already exists in the Database! Skipping...</h3>
				<div>
					<p>Retreiving Match ID for Uploads list.<p>
				</div>
			</div>
		';
		
		$uploads[$Match_Name] = selectFields($db, 'MatchData', array('Match_Name' => $Match_Name), 'Match_ID');
		
		$parsedDir = 'banks/parsed/';
		
		if(file_exists($parsedDir.basename($bank)) && $bank !== $parsedDir.basename($bank)){
			//unlink($bank);
		} elseif ($bank !== $parsedDir.basename($bank)) {
			rename($bank, $parsedDir.basename($bank));
		} else {
		}
	// Otherwise, parse the Bank's data and insert it into the database.	
	}else{
		//*//-Debug-/////
		echo '
			<h3>Match '.$Match_Name.' not found, adding to Database.</h3>
			<div>
				<p>Parsing File Data...</p><br />
		';
		$time_start = microtime(true);
		//*//-Debug-/////
		
		// Load the XML file to be parsed.
		$xml = simplexml_load_file($bank);
		
		// Grab the file's creation time.
		clearstatcache();
		$Match_Date = date('Y-m-d H:i:s',filectime($bank));
		
		// Create Key and Value variables for each data type.
		
		// Match Data
		$MatchData_Key = $xml->xpath("/Bank/Section[@name='MatchData']/Key[@*]");
		$MatchData_Value = $xml->xpath("/Bank/Section[@name='MatchData']/Key[@name='MatchData']/*");
		
		// Map Data
		$MapData_Key = $xml->xpath("/Bank/Section[@name='MapData']/Key[@*]");
		$MapData_Value = $xml->xpath("/Bank/Section[@name='MapData']/Key[@name='MapData']/*");	
		
		// Player Data
		$PlayerData_Key = $xml->xpath("/Bank/Section[@name='PlayerData']/Key[@*]");
		$PlayerData_Value = $xml->xpath("/Bank/Section[@name='PlayerData']/Key[@*]/*");	
		
		// Unit Data
		$UnitData_Key = $xml->xpath("/Bank/Section[@name='UnitData']/Key[@*]");
		$UnitData_Value = $xml->xpath("/Bank/Section[@name='UnitData']/Key[@*]/*");
		
		// Ability Data
		$AbilityData_Key = $xml->xpath("/Bank/Section[@name='AbilityData']/Key[@*]");
		$AbilityData_Value = $xml->xpath("/Bank/Section[@name='AbilityData']/Key[@*]/*");
		
		// Ability Data
		$IdleData_Key = $xml->xpath("/Bank/Section[@name='IdleData']/Key[@*]");
		$IdleData_Value = $xml->xpath("/Bank/Section[@name='IdleData']/Key[@*]/*");
		
		// Build Data
		$BuildData_Key = $xml->xpath("/Bank/Section[@name='BuildData']/Key[@*]");
		$BuildData_Value = $xml->xpath("/Bank/Section[@name='BuildData']/Key[@*]/*");	
		
		// Birth Data
		$BirthData_Key = $xml->xpath("/Bank/Section[@name='BirthData']/Key[@*]");
		$BirthData_Value = $xml->xpath("/Bank/Section[@name='BirthData']/Key[@*]/*");
	
		// Death Data
		$DeathData_Key = $xml->xpath("/Bank/Section[@name='DeathData']/Key[@*]");
		$DeathData_Value = $xml->xpath("/Bank/Section[@name='DeathData']/Key[@*]/*");
	
		// Research Data
		$ResearchData_Key = $xml->xpath("/Bank/Section[@name='ResearchData']/Key[@*]");
		$ResearchData_Value = $xml->xpath("/Bank/Section[@name='ResearchData']/Key[@*]/*");
	
		// Periodic Data
		$PeriodicData_Key = $xml->xpath("/Bank/Section[@name='PeriodicData']/Key[@*]");
		$PeriodicData_Value = $xml->xpath("/Bank/Section[@name='PeriodicData']/Key[@*]/*");		
		
		$i = 0;
		
		$Data_Keys = array (
			$i++ => $MatchData_Key,
			$i++ => $MapData_Key,
			$i++ => $PlayerData_Key,
			$i++ => $UnitData_Key,
			$i++ => $AbilityData_Key,
			$i++ => $IdleData_Key,
			$i++ => $BuildData_Key,
			$i++ => $BirthData_Key,
			$i++ => $DeathData_Key,
			$i++ => $ResearchData_Key,
			$i++ => $PeriodicData_Key
		);
	
		$i = 0;
		
		$Data_Values = array (
			$i++ => $MatchData_Value,
			$i++ => $MapData_Value,
			$i++ => $PlayerData_Value,
			$i++ => $UnitData_Value,
			$i++ => $AbilityData_Value,
			$i++ => $IdleData_Value,
			$i++ => $BuildData_Value,
			$i++ => $BirthData_Value,
			$i++ => $DeathData_Value,
			$i++ => $ResearchData_Value,
			$i++ => $PeriodicData_Value
		);
		
		// Create Class Objects
		
			// MatchData Object
			
			$i = 0;
			
			$data = explode("|", $MatchData_Value[0]['text'], -1);
			
			$inputData = array (
				$data[$i++],  // Match ID
				$Match_Date,  // Match Date
				$data[$i++],  // Map Name
				$data[$i++],  // Game Mode
				$data[$i++]   // Game Speed
			);
			
			$MatchData->addData($File, 0, $inputData);
			
			// Loop through remaining Objects.
			
			for($i = 1; $i < count($Container); $i++){
				parseData($File, $i, $Container[$i], $Data_Keys[$i], $Data_Values[$i]);
			}
			
			//*//-Debug-/////
			$time_end = microtime(true);
			$time = round(($time_end - $time_start), 4);
			echo '
					<p>Finished Parsing File Data, completed in '.$time.' seconds.</p>
				</div>
			';
			//*//-Debug-/////
			
			// Add raw Data to the Database.
			
			//*//-Debug-/////
			echo '
				<h3>Inserting parsed data into Database...</h3>
				<div id="insert-log-'.$File.'">
			';
			$time_start = microtime(true);
			//*//-Debug-/////
			
			if(entry_exists($db,"Maps","Map_Name",$MapData->getValue($File, 0, 0)) === true){
				$Map_ID = selectFields($db, "Maps", array("Map_Name" => $MapData->getValue($File, 0, 0)), "Map_ID");
			}else{
				echo '
					<p>Map '.$MapData->getValue($File, 0, 0).' does not already exist in Database, inserting it and grabbing it\'s ID.</P><br />
				';
				$MapData->insertData($db, $File);
				$Map_ID = $MapData->getEntryID($File, 0);
			}
			
			$MatchData->insertData($db, $Match_Date, $Map_ID, $File);	
			
			$PlayerData->insertData($db, $File, $MatchData->getEntryID($File, 0));
			
			$UnitData->insertData($db, $File, $PlayerData->getEntryIDs($File), $Races);
			
			$BuildData->insertData($db, $File, $UnitData->getEntryIDs($File));
			
			$BirthData->insertData($db, $File, $UnitData->getEntryIDs($File));
			
			$DeathData->insertData($db, $File, $UnitData->getEntryIDs($File));
			
			$ResearchData->insertData($db, $File, $UnitData->getEntryIDs($File));
			
			$PeriodicData->insertData($db, $File, $PlayerData->getEntryIDs($File));
			
			//*//-Debug-/////
			$time_end = microtime(true);
			$time = round(($time_end - $time_start), 4);
			echo '
				<p>Success! Data insertion completed in '. $time .' seconds.</p>
			';
			//*//-Debug-/////
			
		// Cleanup
		
		$uploads[$Match_Name] = $MatchData->getEntryID($File, 0);
		
		$File++;
		
		// After processing 10 files, reset the data objects to free up some memory.
		if($File = 10){
			$File = 0;
			
			unset($MatchData);
			$MatchData = new MatchData();
			
			unset($MapData);
			$MapData = new MapData();
			
			unset($PlayerData);
			$PlayerData = new PlayerData();
			
			unset($UnitData);
			$UnitData = new UnitData();
			
			unset($AbilityData);
			$AbilityData = new AbilityData();
			
			unset($IdleData);
			$IdleData = new IdleData();
			
			unset($BuildData);
			$BuildData = new BuildData();
			
			unset($BirthData);
			$BirthData = new BirthData();
			
			unset($DeathData);
			$DeathData = new DeathData();
			
			unset($ResearchData);
			$ResearchData = new ResearchData();
			
			unset($PeriodicData);
			$PeriodicData = new PeriodicData();
			
			$i = 0;
			
			unset($Container);
			$Container = array (
				$i++ => $MatchData,
				$i++ => $MapData,
				$i++ => $PlayerData,
				$i++ => $UnitData,
				$i++ => $AbilityData,
				$i++ => $IdleData,
				$i++ => $BuildData,
				$i++ => $BirthData,
				$i++ => $DeathData,
				$i++ => $ResearchData,
				$i++ => $PeriodicData
			);
		}
		
		unset($xml);
		
		$parsedDir = 'banks/parsed/';
		
		if(file_exists($parsedDir.basename($bank)) && $bank !== $parsedDir.basename($bank)){
			//unlink($bank);
		} elseif ($bank !== $parsedDir.basename($bank)) {
			rename($bank, $parsedDir.basename($bank));
		} else {
		}
		
		// Close the inserr Log Div, then the Match Log Div.
		echo '
				</div>
			</div>
		';
		
	}
}

?>