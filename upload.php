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
$uploadify = (bool) true;
require_once 'header.php';
//////////// End of Header ////////////

//////////// Page Contents ////////////

function uploadControls(){
	echo '
	<div class="thin">
		<center>
		<div class="head">
			<strong>Upload Matches</strong>
		</div>
		<div class="box pad">
			<form action="" method="post" enctype="multipart/form-data">
				<input type="file" name="file_upload" id="file_upload" />
				<a class="uploadify-button" href="javascript:$(\'#file_upload\').uploadify(\'upload\',\'*\')">Upload Files</a>
				<a class="uploadify-button" href="javascript:$(\'#file_upload\').uploadify(\'cancel\', \'*\')">Cancel All Uploads</a>
			</form>
			<noscript>Please enable Javascript to upload match data.</noscript>
		</div>
		</center>
	</div>
	';
}

if (isset($_GET['upload']) && $_GET['upload'] == 'complete') {
	$dir = 'banks/';
	$uploads = array();
	$files = glob('./banks/MDCL*.SC2Bank');
	
	// Create an Upload Log.
	uploadControls();
	echo "<div class='thin'>
		<div class='boxnewusers'>
			<center>
			<div class='head'>
				<strong>Upload Log</strong>
			</div>
			</center>
			<div class='padnewusers'>
	";
	// Parse the Files.
	require_once 'parser.php';
	
	// Create a list of links to the uploaded files.
	echo "</div></div>
		<div class='boxnewusers'>
			<center>
			<div class='head'>
				<strong>Matches successfully added to database!</strong>
			</div>
			</center>
			<table>";
			foreach ($uploads as $name => $id){
				echo "<tr>
					<td><a target='_blank' href='matches.php?match=".$id."'>".$name."</a></td>
				</tr>";
			}
			echo "</table>
		</div>
	</div>";

} else {
	uploadControls();
}

//////////// End of Page////////////

// Include the page footer and perform any nescessary cleanup.
require_once 'footer.php';
?>