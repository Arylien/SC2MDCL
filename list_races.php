<?

$RLobby = getCountWhere($db, 'PlayerData', 'Lobby_Race_ID', 1);
$PLobby = getCountWhere($db, 'PlayerData', 'Lobby_Race_ID', 2);
$TLobby = getCountWhere($db, 'PlayerData', 'Lobby_Race_ID', 3);
$ZLobby = getCountWhere($db, 'PlayerData', 'Lobby_Race_ID', 4);

$PMatches = getCountWhere($db, 'PlayerData', 'Race_ID', 2);
$TMatches = getCountWhere($db, 'PlayerData', 'Race_ID', 3);
$ZMatches = getCountWhere($db, 'PlayerData', 'Race_ID', 4);

echo '
	<center>
	<div class="boxnewusers">
		<div class="head">
			<strong>Races</strong>
		</div>
		<div class="padnewusers">
			<p>By default, the Races section will provide an overview of some basic statistics for each race. This build includes two graphs that show how Races are being selected via the custom game lobby and how much actual play each Race receives. From here you will be able to go to a page for each individual race and view a number of detailed statistics recorded for that race, such as the number of matches played over time and win rates versus other races categorized by region, league, and game modes.</p>
		</div>
	</div>
	</center>
	<div class="thin">
		<div class="box">
			<div class="head">
				<center><strong>Race Statistics Overview</strong></center>
			</div>
			<table>
				<thead>
					<tr>
						<th>Lobby Selection:</th>
						<th>Actual Usage:</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<div id="Lobby_Selection" style="width:400; height:300"></div>		
						</td>
						<td>
							<div id="Race_Usage" style="width:400; height:300"></div>
						</td>						
					</tr>
				</tbody>
			</table>
		</div>
		<script type="text/javascript">
';

echo "			
			// Load the Visualization API and the piechart package.
			google.load('visualization', '1.0', {'packages':['corechart']});
			
			// Set a callback to run when the Google Visualization API is loaded.
			google.setOnLoadCallback(drawChart);
			
			// Callback that creates and populates a data table, 
			// instantiates the pie chart, passes in the data and
			// draws it.
			function drawChart() {
				
				// Create the Usage table.
				var Usage = new google.visualization.DataTable();
				
				Usage.addColumn('string', 'Race');
				Usage.addColumn('number', 'Matches Played');
				Usage.addRows([
					['Protoss', 	".$PMatches."],
					['Terran', 		".$TMatches."],
					['Zerg', 		".$ZMatches."]
				]);
			
				// Set Usage chart options
				var UsageOptions = {
						'backgroundColor'	: 	{fill:'transparent'},
						'is3D'				:	true,
						'legend'			:	{position:'none'},
						'pieSliceText'		:	'label',
						'width'				:	400,
						'height'			:	300,
						'colors'			:	['#0c95fa','#28ac44','#f58c46']
					};
				
				// Create the Lobby table.
				var Lobby = new google.visualization.DataTable();
				
				Lobby.addColumn('string', 'Race');
				Lobby.addColumn('number', 'Times Selected');
				Lobby.addRows([
					['Protoss', 	".$PLobby."],
					['Terran', 		".$TLobby."],
					['Zerg', 		".$ZLobby."],
					['Random', 		".$RLobby."]
				]);
			
				// Set Lobby chart options
				var LobbyOptions = {
						'backgroundColor'	: 	{fill:'transparent'},
						'is3D'				:	true,
						'legend'			:	{position:'none'},
						'pieSliceText'		:	'label',
						'width'				:	400,
						'height'			:	300,
						'colors'			:	['#0c95fa','#28ac44','#f58c46','#BE63B6']
					};
				
				// Instantiate and draw the Usage chart, passing in some options.
				var UsageChart = new google.visualization.PieChart(document.getElementById('Race_Usage'));
				UsageChart.draw(Usage, UsageOptions);
				
				// Instantiate and draw the Lobby chart, passing in some options.
				var LobbyChart = new google.visualization.PieChart(document.getElementById('Lobby_Selection'));
				LobbyChart.draw(Lobby, LobbyOptions);
			}
";

echo '		
		</script>
	</div>
';

?>