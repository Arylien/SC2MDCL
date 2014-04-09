<?
///*
// Count the number of Matches in the Database. 
$numrows = countRows($db, 'Players');

// Set the number of Matches to displayer per page.
$rowsperpage = 10;
// Find out how many pages there will be.
$totalpages = ceil($numrows / $rowsperpage);

$Sort = 'Player_ID';

// if current page is greater than total pages...
if ($currentpage > $totalpages) {
   	// set current page to last page
   	$currentpage = $totalpages;
}
// if current page is less than first page...
if ($currentpage < 1) {
   	// set current page to first page
   	$currentpage = 1;
}

// the offset of the list, based on current page 
$offset = ($currentpage - 1) * $rowsperpage;

// range of num links to show
$range = 10;

// Create a page header
echo '
	<center>
		<div class="boxnewusers">
			<div class="head">
				<strong>Players</strong>
			</div>
			<div class="padnewusers">
				<p>This page contains a list of all the players tracked in the database. Selecting a player will lead to a page with detailed statistics about that player collected from their match history.</p>
			</div>
		</div>
	</center>
	<div class="thin">
';

// Create Table Structure

createPageLinks($totalpages, $currentpage, $range, $rowsperpage);

echo '
		<table>
			<thead>
				<tr class="colhead">
					<td>#</td>
					<td>Player Name</td>
					<td>Matches</td>
				</tr>
			</thead>
			<tbody>
';

// Get all the matches from the Database 
$Selection = selectFields($db, 'Players', null, array('Player_ID', 'Player_Name'), array($Sort => 'DESC'), $offset, $rowsperpage);

// Print out 
$i = (($rowsperpage * $currentpage) - ($rowsperpage - 1));
foreach($Selection as $Player){
	// Row Values
	$Player_ID = $Player['Player_ID'];
	$Player_Name = $Player['Player_Name'];
	$Num_Matches = getCountWhere($db, 'Matches', 'Player_ID', $Player_ID);
	
	// Print out table row.
   	echo '
				<tr>
					<td>'.$i++.'</td>
					<td width="90%"><strong><a rel=tipsySW title="View Player" href="players.php?player='.$Player_ID.'">'.$Player_Name.'</a></strong></td>
					<td width="10%">'.$Num_Matches.'</td>
				</tr>
	';
}
echo '
			</tbody>
		</table>
';

createPageLinks($totalpages, $currentpage, $range, $rowsperpage);

echo '
	</div>
';

//*/
?>