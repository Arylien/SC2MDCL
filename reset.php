<?

function resetDatabase($Database){
	// Drop the current database.
	$stmt = $Database->prepare('DROP DATABASE mdcl');
	
	try {
		$stmt->execute() 
		or die(print_r($db->errorInfo(), true));
	} catch (PDOException $e) {
		die("DB ERROR: ". $e->getMessage());
	}
	
	// Load Backup file.
	$sql = file_get_contents( 'backup/mdcl.sql' );
	$stmt = $Database->prepare($sql);
	
	try {
		$stmt->execute() 
		or die(print_r($db->errorInfo(), true));
	} catch (PDOException $e) {
		die("DB ERROR: ". $e->getMessage());
	}	
}

?>