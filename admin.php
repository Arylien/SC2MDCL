<?
//////////// Header Information ////////////
// Include essential scripts.
require_once '../../../phpapps/MDCL/config.php';
require_once 'lists.php';
require_once 'functions.php';

// Include the page header and set script variables.
$PageName = ucwords(basename(__FILE__, '.php'));
$jqueryui = (bool) true;
//$heatmap = (bool) true;
//$tablesorter = (bool) true;
//$uploadify = (bool) true;
require_once 'header.php';
//////////// End of Header ////////////

//////////// Page Contents ////////////

function adminPanel(){
	echo '<center>
	<div class="boxnewusers">
		<div class="head">
			<strong>Site Administration</strong>
		</div>
		<div class="padnewusers">
			<p>This page contains a number of functions to help test site functionality. For example, using Reset Database will delete all database information and reset it to it\'s default structure. THis can be used in conjunction with Rebuild Database, which will reinsert all data from backup Bank files. Download Backup can be used to get a zip file containing all of the backup bank files, which can then be used to test the Upload page.<p/>
		</div>
	</div>
</center>
	<div class="thin">
		<center>
		<div class="box">
			<div class="head">
				<strong>Admin Utilities</strong>
			</div>
			<a title="Drops the current database and resets it to the default structure from a backup file." class="uploadify-button" href="admin.php?action=reset">Reset Database</a>
			<a title="Rebuilds the database from the backup Bank files." class="uploadify-button" href="admin.php?action=rebuild">Rebuild Database</a>
			<a title="Creates and downloads a zip of all the backup Bank files." class="uploadify-button" href="admin.php?action=download">Download Backup</a>
		</div>
	</center>';
}

if (isset($_GET['action']) && $_GET['action'] != '') {
	adminPanel();
	if ($_GET['action'] == 'reset'){
		echo "<center>
			<div class='boxnewusers'>
					<div class='head'>
						<strong>Reset Log</strong>
					</div>
					
					<div style='text-align:left;' class='padnewusers'>
			";
		
		// Drop the current database.
		$stmt = $db->prepare('DROP DATABASE mdcl');
		
		try {
			$stmt->execute() 
			or die(print_r($db->errorInfo(), true));
		} catch (PDOException $e) {
			die("DB ERROR: ". $e->getMessage());
		}
		
		echo '<p>Successfully Dropped Database!</p>';
		
		// Load Backup file.
		$sql = file_get_contents( 'backup/mdcl.sql' );
		$stmt = $db->prepare($sql);
		
		try {
			$stmt->execute() 
			or die(print_r($db->errorInfo(), true));
		} catch (PDOException $e) {
			die("DB ERROR: ". $e->getMessage());
		}
		
		echo '<p>Successfully Reset Database!</p>';
		
		echo "</div>
			</div>
			</center>";
		
	} else if($_GET['action'] == 'rebuild') {
		// Copy all the backup files from the Parsed directory to be reprocssed.
		/*
		foreach(glob('./banks/parsed/MDCL*.SC2Bank') as $bank){
			copy($bank, 'banks/'.basename($bank));
		}
		*/
		$files = glob('./banks/parsed/MDCL*.SC2Bank');

		echo "
			<div class='box'>
					<div class='head'>
						<center><strong>Rebuild Log</strong></center>
					</div>";
		// Parse the Files.
		require_once 'parser.php';
		
		echo "
			</div>
			";
		
	} else if($_GET['action'] == 'download') {
		$files = glob('banks/parsed/MDCL*.SC2Bank');
		foreach ($files as $file){
			echo $file;
		}
		$backup = 'banks/backups/banks.zip';
		create_zip($files, $backup, true, true);
		
		if(file_exists($backup)){
			//Set Headers:
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($backup));
			header('Content-Transfer-Encoding: binary');
			readfile($backup);
		}
	}
} else {
	adminPanel();
}

echo '</div></div>';

//////////// End of Page////////////

// Include the page footer and perform any nescessary cleanup.
require_once 'footer.php';
?>