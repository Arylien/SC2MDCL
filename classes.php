<?
class TechTree {
	//// Description: Used to create Tech Tree pages. Links to pages with the lastest patch data. ////
	
	//// TO-DO: Update array structure to dynamically populate to future proof against game version updates. ////
	protected $Units = array(
		'Protoss'	=>	array(
							'Probe' 				=> 0,
							'Zealot' 				=> 0,
							'Stalker' 				=> 0,
							'Sentry' 				=> 0,
							'Observer' 				=> 0,
							'Immortal' 				=> 0,
							'Warp_Prism' 			=> 0,
							'Colossus' 				=> 0,
							'Phoenix' 				=> 0,
							'Void_Ray' 				=> 0,
							'High_Templar' 			=> 0,
							'Dark_Templar' 			=> 0,
							'Archon' 				=> 0,
							'Carrier' 				=> 0,
							'Mothership' 			=> 0,
							'Mothership_Core' 		=> 0,
							'Oracle' 				=> 0,
							'Tempest' 				=> 0
						),
		'Terran'	=>	array(
							'SCV' 					=> 0,
							'Marine' 				=> 0,
							'Marauder' 				=> 0,
							'Reaper' 				=> 0,
							'Ghost' 				=> 0,
							'Hellion' 				=> 0,
							'Siege_Tank' 			=> 0,
							'Thor' 					=> 0,
							'Viking' 				=> 0,
							'Medivac' 				=> 0,
							'Raven' 				=> 0,
							'Banshee' 				=> 0,
							'Battlecruiser' 		=> 0,
							'Hellbat' 				=> 0,
							'Widow_Mine' 			=> 0
						
						),
		'Zerg'		=>	array(
							'Drone' 				=> 0,
							'Overlord' 				=> 0,
							'Zergling' 				=> 0,
							'Queen' 				=> 0,
							'Hydralisk' 			=> 0,
							'Baneling' 				=> 0,
							'Overseer' 				=> 0,
							'Roach' 				=> 0,
							'Infestor' 				=> 0,
							'Mutalisk' 				=> 0,
							'Corruptor' 			=> 0,
							'Nydus_Worm' 			=> 0,
							'Ultralisk' 			=> 0,
							'Brood_Lord' 			=> 0,
							'Swarm_Host' 			=> 0,
							'Viper' 				=> 0
						)
	);
	
	protected $Structures = array(
		'Protoss'	=>	array(
							'Nexus' 				=> 0,
							'Pylon' 				=> 0,
							'Assimilator' 			=> 0,
							'Gateway' 				=> 0,
							'Cybernetics_Core' 		=> 0,
							'Stargate' 				=> 0,
							'Fleet_Beaon' 			=> 0,
							'Robotics_Facility' 	=> 0,
							'Twilight_Council' 		=> 0,
							'Robotics_Bay' 			=> 0,
							'Templar_Archives' 		=> 0,
							'Dark_Shrine' 			=> 0
						),
		'Terran'	=>	array(
							'Command_Center' 		=> 0,
							'Supply_Depot' 			=> 0,
							'Refinery' 				=> 0,
							'Barracks' 				=> 0,
							'Engineering_Bay' 		=> 0,
							'Missile_Turret' 		=> 0,
							'Plantetary_Fortress' 	=> 0,
							'Sensor_Tower' 			=> 0,
							'Factory' 				=> 0,
							'Orbital_Command' 		=> 0,
							'Ghost_Academy' 		=> 0,
							'Bunker' 				=> 0,
							'Armory' 				=> 0,
							'Starport' 				=> 0,
							'Fusion_Core' 			=> 0
							
						),
		'Zerg'		=>	array(
							'Hatchery' 				=> 0,
							'Extractor' 			=> 0,
							'Evolution_Chamber' 	=> 0,
							'Spore_Crawler' 		=> 0,
							'Spawning_Pool'			=> 0,
							'Spine_Crawler' 		=> 0,
							'Roach_Warren' 			=> 0,
							'Baneling_Nest' 		=> 0,
							'Lair' 					=> 0,
							'Nydus_Network' 		=> 0,
							'Spire' 				=> 0,
							'Infestation_Pit' 		=> 0,
							'Hydralisk_Den' 		=> 0,
							'Ultralisk_Den' 		=> 0,
							'Greater_Spire' 		=> 0
						)
	);

	public function __construct($Database){
		//// TO-DO: Update function to grab data from the most recent Patch ////
		// Begin a transaction to start a batch query.
		// Grab the Unit Type ID for each Unit.
		foreach ($this->Units as $Race => $Units){
			foreach($Units as $Unit => $ID){
				$Name = str_replace('_', '', $Unit);
				$ID = selectFields($Database, 'Units', array('Unit_Name' => $Name), 'Unit_Type');
				$this->Units[$Race][$Unit] = $ID;
			}
		}
		// Grab the Unit Type ID for each Structure.
		foreach ($this->Structures as $Race => $Structures){
			foreach($Structures as $Structure => $ID){
				$Name = str_replace('_', '', $Structure);
				$ID = selectFields($Database, 'Units', array('Unit_Name' => $Name), 'Unit_Type');
				$this->Structures[$Race][$Structure] = $ID;
			}
		}
	}
	
	public function createUnitList(){
		////Description: Creates a tabbed list of all the basic Unit types. ////
		echo'<div xmlns="http://www.w3.org/1999/xhtml" id="unit-map" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
			<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
				<li class="tab-terran ui-state-default ui-corner-top"><a href="#units-terran">Terran</a></li>
				<li class="tab-protoss ui-state-default ui-corner-top"><a href="#units-protoss">Protoss</a></li>
				<li class="tab-zerg ui-state-default ui-corner-top"><a href="#units-zerg">Zerg</a></li>
			</ul>
			<div class="tab-content">
				<div class="outtop"></div>
				<div class="intop">
				<div class="bottom">';
		foreach ($this->Units as $Race => $Units){
			$Clear = 0;
			echo '<div id="units-'.strtolower($Race).'" class="ui-tabs-panel ui-widget-content ui-corner-bottom"><ul>';
			foreach($Units as $Unit => $ID){
				$Clear++;
				$Name = str_replace('_', ' ', $Unit);
				$Class = strtolower(str_replace('_', '-', $Unit));
				echo '
						<li>
							<a href="units.php?unit='.$ID.'" class="unit-thumb">
							<span class="unit-'.$Class.'"></span>
							'.$Name.'
							</a>
						</li>
				';
				if($Clear == 8){
					$Clear = 0;
					echo '<li class="row-clear">';
				}
			}
			echo '</ul></div>';
		}
		echo '<span class="clear"><!-- --></span>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(function() {
				$("#unit-map").tabs({ selected: 0 });
			});
		</script>';
	}
	
	public function createUnitPage($Database, $Unit){
		$UnitData = selectFields($Database, 'Units', array('Unit_Type' => $Unit));
		$UnitName = $UnitData['Unit_Name'];
		$IconName = strtolower(str_replace('_', '', $UnitName));
		$Race = $UnitData['Race_ID'] + 1;
		global $Races;
		$DisplayName = str_replace('_', ' ', $UnitName);
		//$Kills = getCountByUnitType($Database, 'DeathData', array($Unit => 'Killing_Unit_ID'));
		//$Deaths = getCountByUnitType($Database, 'DeathData', array($Unit => 'Triggering_Unit_ID'));
		echo '
			<div class="thin">
				<div class="head">
					<center><strong>'.$DisplayName.'</strong></center>
				</div>
				<div class="unitModel">
					<div class="model" id="model-'.$IconName.'">
						<div class="viewer" style="background-image: url(\'img/icons/'.$Races[$Race].'/rotate/'.$IconName.'.png\');"></div>
					</div>
					<center><strong>Unit Model</strong></center>
					<script type="text/javascript">
						//<![CDATA[
							$(function() {
								var model0 = new SC2ModelRotator(\'#model-'.$IconName.'\', {
									key: \''.$IconName.'\',
									frameWidth: 212,
									frameHeight: 212,
									sequenceWidth: 6572,
									totalFrames: 31,
									velocity: 10,
									zoom: false,
									rotate: false
								});
							});
						//]]>
					</script>
				</div>	
				<div class="unitstatsbasic">
			</div>
		';
	}
	
	public function playerUnitTable($Database, $Player){
		// Create a Datatables div to hold all out tables
		echo '
			<div id="unit-map" class="box">
				<div>
					<ul class="ui-tabs-nav">
						<li class="tab-protoss"><a href="#units-protoss">Protoss</a></li>
						<li class="tab-terran"><a href="#units-terran">Terran</a></li>
						<li class="tab-zerg"><a href="#units-zerg">Zerg</a></li>
					</ul>
				</div>
		';
		foreach ($this->Units as $Race => $Units){
			$PlayerData = selectFields($Database, 'PlayerData', array('Player_ID' => $Player), 'Entry_ID');
			$BuildCount = array();
			$BuildChart = array();
			$LostCount = array();
			$LostChart = array();
			foreach($Units as $Unit => $ID){
				$BuildCount[$Unit] = selectFields($Database, 'UnitData', array('Unit_Type' => $ID, 'Unit_Owner' => $PlayerData), selection(null,'Count'));
				$BuildChart[] = "['".str_replace('_', ' ', $Unit)."',".$BuildCount[$Unit]."]";
				$LostCount[$Unit] = getCountByUnitType($Database, 'DeathData', array('Unit_Type' => $ID, 'Unit_Owner' => $PlayerData), 'Triggering_Unit_ID');
				$LostChart[] = "['".str_replace('_', ' ', $Unit)."',".$LostCount[$Unit]."]";
			}
			echo '
				<div class="tab-content clear">
					<div id="units-'.strtolower($Race).'" class="ui-tabs-panel">
						<div>
							<div class="head">
								<center><strong>Usage Graphs</strong></center>
							</div>
							<div id="buildChart-'.strtolower($Race).'" style="width:800; height:600"></div>
							<div id="lostChart-'.strtolower($Race).'" style="width:800; height:600"></div>
							<script type="text/javascript">
			';
			
			echo "			
	google.load('visualization', '1.0', {'packages':['corechart']});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var Built = new google.visualization.DataTable();
		
		Built.addColumn('string', 'Unit Type');
		Built.addColumn('number', 'Number Built');
		Built.addRows([
			".implode(',
			',$BuildChart)."
		]);

		var buildOptions = {
				'title'				:	'Total Units Built',
				'titleTextStyle'	:	{color: '#00D683'},
				'backgroundColor'	: 	{fill:'transparent'},
				'is3D'				:	true,
				'legend'			:	{textStyle:{color: 'white', fontSize: 10}},
				'pieSliceText'		:	'percentage',
				'width'				:	800,
				'height'			:	500
			};

		var Lost = new google.visualization.DataTable();
		
		Lost.addColumn('string', 'Unit Type');
		Lost.addColumn('number', 'Number Lost');
		Lost.addRows([
			".implode(',
			',$LostChart)."
		]);

		var lostOptions = {
				'title'				:	'Total Units Lost',
				'titleTextStyle'	:	{color: '#00D683'},
				'backgroundColor'	: 	{fill:'transparent'},
				'is3D'				:	true,
				'legend'			:	{textStyle:{color: 'white', fontSize: 10}},
				'pieSliceText'		:	'percentage',
				'width'				:	800,
				'height'			:	500
			};

		var buildChart = new google.visualization.PieChart(document.getElementById('buildChart-".strtolower($Race)."'));
		buildChart.draw(Built, buildOptions);

		var lostChart = new google.visualization.PieChart(document.getElementById('lostChart-".strtolower($Race)."'));
		lostChart.draw(Lost, lostOptions);
	}
			";
			
			echo '				
							</script>
						</div>
			';
			// Create a datatable for each race
			echo '
						<div class="unit-table">
							<div class="head">
								<center><strong>Unit Table</strong></center>
							</div>
							
							<table>
								<thead>
									<tr class="titles">
										<th id="unit-name-col">Name</th>
										<th>Statistics</th>
									</tr>
								</thead>
								<tbody class="rows">
			';
			
			// Create a row for each Unit Type.
			
			foreach($Units as $Unit => $ID){
				$IconName = strtolower(str_replace('_', '', $Unit));
				$Name = str_replace('_', ' ', $Unit);
				if(array_sum($BuildCount) !== 0){
					$PRU = round(($BuildCount[$Unit] / array_sum($BuildCount) * 100), 2);;
				} else {
					$PRU = 0;
				}
				$Built = $BuildCount[$Unit];
				$Lost = $LostCount[$Unit];
				$BPM = array();
				$LPM = array();
				foreach($PlayerData as $Match){
					$BPM[] = selectFields($Database, 'UnitData', array('Unit_Type' => $ID, 'Unit_Owner' => $Match), selection(null,'Count'));
					$LPM[] = getCountByUnitType($Database, 'DeathData', array('Unit_Type' => $ID, 'Unit_Owner' => $Match), 'Triggering_Unit_ID');
				}
				$ABPM = (count($BPM) > 0) ? round((array_sum($BPM) / count($BPM)), 2) : 0;
				$ALPM = (count($LPM) > 0) ? round((array_sum($LPM) / count($LPM)), 2) : 0;
				$Kills = getCountByUnitType($Database, 'DeathData', array('Unit_Type' => $ID, 'Unit_Owner' => $PlayerData), 'Killing_Unit_ID');
				$UnitData = selectFields($Database, 'UnitData', array('Unit_Type' => $ID, 'Unit_Owner' => $PlayerData), 'Entry_ID');
				$KPU = array();
				if(is_array($UnitData)){
					foreach($UnitData as $Entry){
						$KPU[] = @selectFields($Database, 'DeathData', array('Killing_Unit_ID' => $Entry['Entry_ID']), selection(null,'Count'));
					}
				} else {
					$KPU[] = selectFields($Database, 'DeathData', array('Killing_Unit_ID' => $UnitData['Entry_ID']), selection(null,'Count'));
				}
				$AKPU = (count($KPU) > 0) ? round((array_sum($KPU) / count($KPU)), 2) : 0;
				if (($Kills != 0) && ($Lost != 0)){
					$Ratio = ($Kills / $Lost);
					$KDRatio = round($Ratio, 2).' / 1';
				} else {
					$KDRatio = '-';
				}
				$AKD = round(getAvgByUnitType($Database, 'DeathData', 'Killing_Unit_ID', array('Unit_Type' => $ID, 'Unit_Owner' => $PlayerData), 'Distance_Between_Units'), 2);
				$ADD = round(getAvgByUnitType($Database, 'DeathData', 'Triggering_Unit_ID', array('Unit_Type' => $ID, 'Unit_Owner' => $PlayerData), 'Distance_Between_Units'), 2);
				
				/*///-Debug-//////
				echo '<pre>';
				print_r(var_dump($KPU), true);
				echo '</pre>';
				//*///-Debug-//////
				
				// Create the table row.
				echo '
					<tr onclick="Core.goTo(\'units.php?unit='.$ID.'\')">
						<td>
							<div class="unit-thumb">
								<div class="unit-icon">
									<img src="img/icons/'.strtolower($Race).'/units/btn-unit-'.strtolower($Race).'-'.$IconName.'.png"/>
								</div>
								<div class="unit-name">
									'.$Name.'
								</div>
							</div>
						</td>
						<td>
							<div class="unit-stats">
								<table>
									<thead>
										<tr>
											<th>Statistics:</th>
											<th>Performance:</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td id="stats-performance">
												<ul>
													<li>
														<a title="Total number of units of this type built by this Player." rel=tipsyW>Built</a>
														<span>'.(($Built > 0) ? $Built : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="Number of total kills made with this unit type." rel=tipsyW>Kills</a>
														<span>'.(($Kills > 0) ? $Kills : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="Total number of units of this type lost by this Player." rel=tipsyW>Lost</a>
														<span>'.(($Lost > 0) ? $Lost : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="<b>Average Built Per Match</b>: Average number of units of this type Made per Match." rel=tipsyW>ABPM</a>
														<span>'.$ABPM.'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="<b>Average Lost Per Match</b>: Average number of units of this type Lost per Match." rel=tipsyW>ALPM</a>
														<span>'.$ALPM.'</span>
														<span class="clear"></span>
													</li>
												</ul>
											</td>
											<td id="stats-performance">
												<ul>
													<li>
														<a title="<b>Percent Race Usage</b>: Percent of units of this type made out of all unit types of this Race." rel=tipsyW>%RU</a>
														<span>'.$PRU.'%</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="<b>Average Kills Per Unit</b>: Average number of kills made per unit with this type." rel=tipsyW>AKPU</a>
														<span>'.(($AKPU > 0) ? $AKPU : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="Ratio of Kills made by this unit type per unit of this type that was built." rel=tipsyW>K/D Ratio</a>
														<span>'.$KDRatio.'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="<b>Average Kill Distance</b>: The average distance at which a unit of this type was from it\'s target when it made a kill." rel=tipsyW>AKD</a>
														<span>'.(($AKD > 0) ? $AKD : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="<b>Average Death Distance</b>: The average distance at which a unit of this type was from the unit that killed it." rel=tipsyW>ADD</a>
														<span>'.(($ADD > 0) ? $ADD : '-').'</span>
														<span class="clear"></span>
													</li> 
												</ul>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
				';
				}
			echo '
								</tbody>
							</table>
						</div>
					</div>
				</div>
			';
		}
		// Close the Datatables div
		echo '
			</div>
			<script type="text/javascript">
			//<![CDATA[
				$(function() {
					try {
						Sc2.initRolloverEffect();				
					} catch(e) {}
				});
			//]]>
			$(function() {
				$("#unit-map").tabs({ selected: 0 });
			});
			$(function() {
				$("#accordion").accordion();
			});
			</script>
		';		
	}
	
	// Create a set of tab seperated tables of Units for each rach.
	public function createUnitTable($Database){
		// Create a Datatables div to hold all out tables
		echo '
			<div id="unit-map" class="box">
				<ul class="ui-tabs-nav">
					<li class="tab-protoss"><a href="#units-protoss">Protoss</a></li>
					<li class="tab-terran"><a href="#units-terran">Terran</a></li>
					<li class="tab-zerg"><a href="#units-zerg">Zerg</a></li>
				</ul>
		';
		foreach ($this->Units as $Race => $Units){
		$Clear = 0;
		// Create a datatable for each race
		echo '
			<div class="tab-content unit-table">
				<div id="units-'.strtolower($Race).'" class="ui-tabs-panel">
					<table>
						<thead>
							<tr class="titles">
								<th id="unit-name-col">Name</th>
								<th>Statistics</th>
							</tr>
						</thead>
						<tbody class="rows">
		';
			// Create a row for each Unit Type.
			foreach($Units as $Unit => $ID){
				// Gather some statistics about this unit type.
				$UnitData = selectFields($Database, 'Units', array('Unit_Type' => $ID));
				
				$Clear++;
				$IconName = strtolower(str_replace('_', '', $Unit));
				$Name = str_replace('_', ' ', $Unit);
				$Kills = getCountByUnitType($Database, 'DeathData', array('Unit_Type' => $ID), 'Killing_Unit_ID');
				$Deaths = getCountByUnitType($Database, 'DeathData', array('Unit_Type' => $ID), 'Triggering_Unit_ID');
				if (($Kills != 0) && ($Deaths != 0)){
					$Ratio = ($Kills / $Deaths);
					$KDRatio = round($Ratio, 2).' / 1';
				} else {
					$KDRatio = '-';
				}
				$AKD = round(getAvgByUnitType($Database, 'DeathData', 'Killing_Unit_ID', array('Unit_Type' => $ID), 'Distance_Between_Units'), 2);
				$ADD = round(getAvgByUnitType($Database, 'DeathData', 'Triggering_Unit_ID', array('Unit_Type' => $ID), 'Distance_Between_Units'), 2);
				$Minerals = $UnitData['Mineral_Cost'];
				$Vespene = $UnitData['Vespene_Cost'];
				$Supply = $UnitData['Supply_Cost'];
				$BuildTime = 0;
				$Life = $UnitData['Life'];
				$Shields = $UnitData['Shields'];
				$Energy = $UnitData['Energy'];
				$Armor = $UnitData['Life_Armor'];
				$Speed = $UnitData['Speed'];
				$Accel = $UnitData['Acceleration'];
				$CSpeed = (($Speed * $UnitData['Creep_Speed']) - $Speed);
				$Radius = $UnitData['Radius'];
				
				// Create the table row.
				echo '
					<tr onclick="Core.goTo(\'units.php?unit='.$ID.'\')">
						<td>
							<div class="unit-thumb">
								<div class="unit-icon">
									<img src="img/icons/'.strtolower($Race).'/units/btn-unit-'.strtolower($Race).'-'.$IconName.'.png"/>
								</div>
								<div class="unit-name">
									'.$Name.'
								</div>
							</div>
						</td>
						<td>
							<div class="unit-stats">
								<table>
									<thead>
										<tr>
											<th>Performance:</th>
											<th>Costs:</th>
											<th>Vitals:</th>
											<th>Movement:</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td id="stats-performance">
												<ul>
													<li>
														<a title="Number of total kills recorded for this unit type." rel=tipsyW>Kills</a>
														<span>'.(($Kills > 0) ? $Kills : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="Number of total deaths recorded for this unit type." rel=tipsyW>Deaths</a>
														<span>'.(($Deaths > 0) ? $Deaths : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="Ratio of Kills made by this unit type per unit of this type that was built." rel=tipsyW>K/D Ratio</a>
														<span>'.$KDRatio.'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="Average Kill Distance: The average distance at which a unit of this type was from it\'s target when it made a kill." rel=tipsyW>AKD</a>
														<span>'.(($AKD > 0) ? $AKD : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="Average Death Distance: The average distance at which a unit of this type was from the unit that killed it." rel=tipsyW>ADD</a>
														<span>'.(($ADD > 0) ? $ADD : '-').'</span>
														<span class="clear"></span>
													</li> 
												</ul>
											</td>
											<td id="stats-costs">
												<ul>
													<li>
														<a title="Minerals" rel=tipsyW><img src="img/icons/icon-mineral.gif" alt="Minerals"/></a>
														<span>'.(($Minerals > 0) ? $Minerals : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="Vespene" rel=tipsyW><img src="img/icons/icon-vespene-'.strtolower($Race).'.gif" alt="Vespene"/></a>
														<span>'.(($Vespene > 0) ? $Vespene : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="Supply" rel=tipsyW><img src="img/icons/icon-supply-'.strtolower($Race).'.gif" alt="Supply"/></a>
														<span>'.(($Supply > 0) ? $Supply : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="Build Time" rel=tipsyW><img src="img/icons/icon-buildtime-'.strtolower($Race).'.gif" alt="Time"/></a>
														<span>'.(($BuildTime> 0) ? $BuildTime : '-').'</span>
														<span class="clear"></span>
													</li>
												</ul>
											</td>
											<td id="stats-vitals">
												<ul>
													<li>
														<a title="The base maximum amount of Life for this unit type." rel=tipsyW>Life:</a>
														<span>'.(($Life > 0) ? $Life : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="The base maximum amount of Shields for this unit type." rel=tipsyW>Shields:</a>
														<span>'.(($Shields > 0) ? $Shields : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="The base maximum amount of Energy for this unit type." rel=tipsyW>Energy:</a>
														<span>'.(($Energy > 0) ? $Energy : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="The base Armor value for this unit type." rel=tipsyW>Armor:</a>
														<span>'.(($Armor > 0) ? $Armor : '-').'</span>
														<span class="clear"></span>
													</li>
												</ul>
											</td>
											<td id="stats-movement">
												<ul>
													<li>
														<a title="Base movement speed for this unit type." rel=tipsyW>Speed:</a>
														<span>'.(($Speed > 0) ? $Speed : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="The rate at which this unit type reaches it\'s top speed." rel=tipsyW>Acceleration:</a>
														<span>'.(($Accel > 0) ? $Accel : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="Speed at which this unit type travels on creep." rel=tipsyW>Creep Speed:</a>
														<span>'.(($CSpeed > 0) ? '+'.$CSpeed : '-').'</span>
														<span class="clear"></span>
													</li>
													<li>
														<a title="The radus at which this unit type collides with other units." rel=tipsyW>Radius:</a>
														<span>'.(($Radius > 0) ? $Radius : '-').'</span>
														<span class="clear"></span>
													</li>
												</ul>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
				';
				}
		echo '
						</tbody>
					</table>
				</div>
			</div>
		';
		}
		// Close the Datatables div
		echo '
			</div>
			<script type="text/javascript">
			//<![CDATA[
				$(function() {
					try {
						Sc2.initRolloverEffect();				
					} catch(e) {}
				});
			//]]>
			$(function() {
					$("#unit-map").tabs({ selected: 0 });
				});
			</script>
		';		
		}
	}


class Data {
	
	protected $Entry_ID = array();
		
	protected $Fields = array();
	
	// Data[Match][Entry][Field] = (Value 1, Value 2, Value 3, etc)
	
	protected $Data = array(array());

	function __construct(
		$Match = 0,
		$Event = 0,
		$Data = array()
	){
		$this->Data[$Match][$Event] = $Data;
		asort($this->Data[$Match]);
	}
	
	// Used to add new Data to the container object.
	
	public function addData(
		$Match,
		$Event,
		$Data = array()
	){
		$this->Data[$Match][$Event] = $Data;
	}
	
	public function dumpData($Match, $Entry){
		/*
		$Data = array_combine($this->Fields, $this->Data[$Match][$Entry]);
		echo '<ul>';
		foreach ($Data as $Key => $Value){
			echo '<li>'.$Key.' => '.$Value.'</li>';
		}
		echo '</ul>';
		//*/
		
		echo '<pre>';
		print_r(var_dump($this->Data[$Match][$Entry]), true);
		echo '</pre>';
	}
	
	// Builds an HTML table for the selected Match.
	
	public function buildTable($Match) {
		
		echo "<table id='".get_class($this)."' class='tablesorter'><thead><tr>";
		foreach ($this->Fields as $Value){				
			echo "<th>".$Value."</th>";
		}
				
		echo "</tr></thead><tbody>";
		
		for ($i = 0; $i < count($this->Data[$Match]); $i++){
			
			echo "<tr>";
			
			foreach ($this->Data[$Match][$i] as $Value){	
						
				echo "<td>".$Value."</td>";
				
			}
			
			echo "</tr>";
			
		}
		
		echo "</tbody></table>";
	
	}
		
	public function getEntryID($Match = 0, $Event = 0){
		return $this->Entry_ID[(int)$Match][(int)$Event];
	}
	
	public function getEntryIDs($Match = 0){
		return $this->Entry_ID[$Match];
	}
	
	public function getValue($Match, $Event, $Field){
		return $this->Data[$Match][$Event][$Field];
	}
	
	public function countValues($Match){
	
		$Count = count($this->Data[$Match]);
		
		return $Count;
	
	}
}

class MatchData extends Data {
	
	protected $Fields = array(
		"Match Name",
		"Match Date",
		"Map Name",
		"Game Mode",
		"Game Speed"
	);
	
	public function insertData($Database, $Match_Date, $Map_ID, $Match){
		//*///-Debug-//////
		echo '
			<h3>Running '.get_class($this).' method: '.__Function__.'</h3>
			<div>
		';
		$time_start = microtime(true);
		//*///-Debug-//////
		
		$Mode_ID = ($this->Data[$Match][0][3] + 1);
		
		$Data = array(
			"Match_Name" 	=> substr($this->Data[$Match][0][0], 5),
			"Match_Date"  	=> $Match_Date,
			"Map_ID" 		=> $Map_ID,
			"Mode_ID" 		=> $Mode_ID,
			"Game_Speed" 	=> $this->Data[$Match][0][4]
		);
		
		/*///-Debug-//////
		echo '
			<p>Function: '.__Function__.' Data Array:</p>
		';
		foreach ($Data as $Key => $Value){
			echo '<p>'.$Key.' = '.$Value.'</p>';
		}
		//*/////////////
		
		$this->Entry_ID[$Match][0] = insertSingle($Database, get_class($this), $Data);
		
		//*///-Debug-//////
		$time_end = microtime(true);
		$time = round(($time_end - $time_start), 4);
		echo '
				<p>Completed '.get_class($this).'->'.__Function__.' in '. $time .' seconds.</p>
			</div>
		';
		//*/////////////
	}
	
}

class MapData extends Data {
	
	protected $Fields = array(
		"Map Name",
		"Map Size X",
		"Map Size Y",
		"Map Playable Size X",
		"Map Playable Size Y"
	);
	
	public function insertData($Database, $Match){
		//*///-Debug-//////
		echo '
			<h3>Running '.get_class($this).' method: '.__Function__.'</h3>
			<div>
		';
		$time_start = microtime(true);
		//*///-Debug-//////
		
		$Data = array(
			"Map_Name" 				=> $this->Data[$Match][0][0],
			"Map_Size_X"  			=> $this->Data[$Match][0][1],
			"Map_Size_Y" 			=> $this->Data[$Match][0][2],
			"Map_Size_Playable_X" 	=> $this->Data[$Match][0][3],
			"Map_Size_Playable_Y" 	=> $this->Data[$Match][0][4]
		);
		
		/*///-Debug-//////
		echo '<p>Function: '.__Function__.' Data Array:</p>';
		foreach ($Data as $Key => $Value){
			echo '<p>'.$Key.' = '.$Value.'</p>';
		}
		//*/////////////
		
		$this->Entry_ID[$Match][0] = insertSingle($Database, 'Maps', $Data);
		
		//*///-Debug-//////
		$time_end = microtime(true);
		$time = round(($time_end - $time_start), 4);
		echo '
				<p>Completed '.get_class($this).'->'.__Function__.' in '. $time .' seconds.</p>
			</div>
		';
		//*/////////////
	}
	
	public function heatmapStyle($Match) {
		
		$Value = "position:relative; height:".(($this->Data[$Match][0][2] * 10) / 4)."px; width:".(($this->Data[$Match][0][1] * 10) / 4)."px; background-image:url(\"img/maps/".str_ireplace(" ", "_", $this->Data[$Match][0][0]).".jpg\");";
		
		return $Value;
	
	}
	
}

class PlayerData extends Data {
	
	protected $Player_ID = array(array());
	
	protected $Fields = array(
		"Player ID",
		"Match ID",
		"Player Name",
		"Player Number",
		"Team Number",
		"Player Color",
		"Player Race",
		"Player Lobby Race",	
		"Controller",
		"Handicap",
		"Start Location X",
		"Start Location Y"
	);
	
	public function insertData($Database, $Match = int, $Match_ID = int){
		//*///-Debug-//////
		echo '
			<h3>Running '.get_class($this).' method: '.__Function__.'</h3>
			<div>
		';
		$time_start = microtime(true);
		//*///-Debug-//////
		
		$Keys = array();
		
		$Data = array();
		
		$Player = $this->Data[(int)$Match]; 
		
		// Loop through each Player and create new Datanase entries for them.
		foreach($Player as $Entry){
			// Check to see if the player already has an entry in the Players table, create one if false. In both cases, grab the row index to use as the Player ID.
			//*///-Debug-//////
			echo "<b><u><p>Preparing PlayerData insert data for Player ".$Entry[2]."...</p></u></b>";
			//*///-Debug-//////
			
			$Player_Num = $Entry[3];
			
			if(entry_exists($Database,"Players","Bnet_ID",$Entry[0]) === true){
				//*///-Debug-//////
				echo "<p>Player found! Getting their Player ID.</p>";
				//*///-Debug-//////
				
				$Player_ID = $this->Player_ID[(int)$Match][(int)$Player_Num] = selectFields($Database, "Players", array("Bnet_ID" => $Entry[0]), "Player_ID");
				
				/*///-Debug-//////
				echo '<p>Set Player ID for Player '.$Entry[2].' to '.$Player_ID.'</p>';
				//*///-Debug-//////
			}else{
				//*///-Debug-//////
				echo "<p>Player does not already exist in the Database Adding them and grabbing their ID...</p>";
				//*///-Debug-//////
				
				$Player = array(
					"Bnet_ID" => $Entry[0],
					"Player_Name" => $Entry[2]
				);
				
				/*///-Debug-//////
				echo '<p>Function: '.__Function__.' Player Array:</p>';
				foreach ($Player as $Key => $Value){
					echo '<p>'.$Key.' = '.$Value.'</p>';
				}
				//*///-Debug-//////
				
				// Retrieve this Player's PLayer ID from the Players table. AKA the Insert ID
				$Player_ID = $this->Player_ID[(int)$Match][(int)$Player_Num] = insertSingle($Database, 'Players', $Player);
				
				/*///-Debug-//////
				echo '<p>Set Player ID for Player '.$Entry[2].' to '.$Player_ID.'</p>';
				//*///-Debug-//////
			}
			
			/*///-Debug-//////
			echo '<p>Verifying Player ID...</p>';
			if(isset($Player_ID)){
				echo "<p>Retrieved Player ID: ".$Player_ID." for Player ".$Entry[2].". Creating a new Matches entry for them.</p>";
			} else {
				echo '<p>ERROR Failed to get Player ID! Variable was set to "'.$Player_ID.'"</p>';
				die;	
			}
			//*///-Debug-//////
			
			// Create a new Matches entry to connect the Player entry to the Match entry.
			
			$MatchesData = array(
				"Player_ID" => $Player_ID,
				"Match_ID" => $Match_ID
			);
			
			/*//-Debug-/////
			echo '<p>Function: '.__Function__.' Match Array:</p>';
			foreach ($Match as $Key => $Value){
				echo '<p>'.$Key.' = '.$Value.'</p>';
			}
			//*/////////////
				
			insertSingle($Database, 'Matches', $MatchesData);

			$Keys[] = $Entry[3];
			
			$Data[] = array(
				'Player_ID' 		=> $Player_ID,
				'Match_ID' 			=> $Match_ID,
				'Player_Num' 		=> $Entry[3],
				'Team_Num' 			=> $Entry[4],
				'Color' 			=> rgb2hex(explode(',',$Entry[5])),
				'Race_ID' 			=> $Entry[6],
				'Lobby_Race_ID' 	=> $Entry[7],
				'Controller' 		=> $Entry[8],
				'Handicap' 			=> $Entry[9],
				'Start_Location_X' 	=> $Entry[10],
				'Start_Location_Y' 	=> $Entry[11],
			);
			
			//*///-Debug-//////
			echo "<p>Done preparing data for Player: ".$Entry[2].".</p><br />";
			//*///-Debug-//////
		}
		
		$this->Entry_ID[$Match] = insertMultiple($Database, get_class($this), $Data, $Keys); // Player #
		$this->Entry_ID[$Match][0] = 1; // Neutral Passive
		$this->Entry_ID[$Match][16] = 2; // Neutral Hostile
		
		//*///-Debug-//////
		$time_end = microtime(true);
		$time = round(($time_end - $time_start), 4);
		echo '
				<p>Completed '.get_class($this).'->'.__Function__.' in '. $time .' seconds.</p>
			</div>
		';
		//*///-Debug-//////
	}
	
	public function getPlayerIDs($Match){
		return $this->Player_ID[$Match];
	}
	
}

class UnitData extends Data {
	
	protected $Fields = array(
		"Event ID",
		"Unit ID",
		"Owner",
		"Unit Name",
		"Unit Type",
		"Race ID",
		"Mineral Cost",
		"Vespene Cost",
		"Supply Cost",
		"Supplies Made",
		"Life Armor",
		"Life Max",
		"Life Regen",
		"Shield Armor",
		"Shields",
		"Shields Regen",
		"Starting Energy",
		"Energy",
		"Energy Regen",
		"Speed",
		"Creep Speed",
		"Acceleration",
		"Turning Rate",
		"Radius",
		"Mover",
		"Footprint",
		"Sight Radius"
	);
	
	public function insertData($Database, $Match = int, $Player_IDs = array(), $Races = array()){
		//*///-Debug-//////
		echo '
			<h3>Running '.get_class($this).' method: '.__Function__.'</h3>
			<div>
		';
		$time_start = microtime(true);
		//*///-Debug-//////

		$Keys = array();
		
		$Data = array();
		
		$Database->beginTransaction();
		
		$Unit = $this->Data[(int)$Match];
		
		foreach($Unit as $Entry){
			
			$Unit_ID = $Entry[1];
			$Owner = $Entry[2];	
			$Unit_Name = str_replace('Unit/Name/','', $Entry[3]);
			$Race_ID = $Races[$Entry[5]];
			
			if(entry_exists($Database,"Units","Unit_Name",$Unit_Name) === true){
				/*///-Debug-//////
				echo "<p>Unit Type found! Getting it's ID.</p>";
				//*///-Debug-//////
				
				$Unit_Type = selectFields($Database, "Units", array("Unit_Name" => $Unit_Name), "Unit_Type");
			
			}else{
				//*///-Debug-//////
				echo "<p>Unit Type ".$Unit_Name." does not already exist in the Database. Adding it and grabbing it's ID...</p>";
				//*///-Debug-//////
				
				// NOTE: Currently using  key exists and isset ?: to default to null for unset keys. Not intended to be a long term solution.
				$Unit = array(
					"Unit_Name" 		=> $Unit_Name,
					"Unit_ID" 			=> isset($Entry[4]) ? $Entry[4] : null,
					"Race_ID" 			=> $Race_ID,
					"Mineral_Cost" 		=> isset($Entry[6]) ? $Entry[6] : null,
					"Vespene_Cost" 		=> isset($Entry[7]) ? $Entry[7] : null,
					"Supply_Cost" 		=> isset($Entry[8]) ? $Entry[8] : null,
					"Supplies_Made" 	=> isset($Entry[9]) ? $Entry[9] : null,
					"Life" 				=> isset($Entry[10]) ? $Entry[10] : null,
					"Life_Regen" 		=> isset($Entry[11]) ? $Entry[11] : null,
					"Life_Armor" 		=> isset($Entry[12]) ? $Entry[12] : null,
					"Shields" 			=> isset($Entry[13]) ? $Entry[13] : null,
					"Shield_Regen" 		=> isset($Entry[14]) ? $Entry[14] : null,
					"Shield_Armor" 		=> isset($Entry[15]) ? $Entry[15] : null,
					"Starting_Energy" 	=> isset($Entry[16]) ? $Entry[16] : null,
					"Energy" 			=> isset($Entry[17]) ? $Entry[17] : null,
					"Energy_Regen" 		=> isset($Entry[18]) ? $Entry[18] : null,
					"Speed" 			=> isset($Entry[19]) ? $Entry[19] : null,
					"Creep_Speed" 		=> isset($Entry[20]) ? $Entry[20] : null,
					"Acceleration" 		=> isset($Entry[21]) ? $Entry[21] : null,
					"Turning_Rate" 		=> isset($Entry[22]) ? $Entry[22] : null,
					"Radius" 			=> isset($Entry[23]) ? $Entry[23] : null,
					"Mover" 			=> isset($Entry[24]) ? $Entry[24] : null,
					"Footprint" 		=> isset($Entry[25]) ? $Entry[25] : null,
					"Sight_Radius"  	=> isset($Entry[26]) ? $Entry[26] : null
				);
				
				/*//-Debug-/////
				echo '<p>Function: '.__Function__.' Unit Array:</p>';
				foreach ($Unit as $Key => $Value){
					echo '<p>'.$Key.' = '.$Value.'</p>';
				}
				//*/////////////
				
				// Insert and grab the Unit_Type ID
				$Unit_Type = insertSingle($Database, 'Units', $Unit);
			}

			/*///-Debug-//////
			echo "<p>Retrieved Unit_Type ID: ".$Unit_Type." for Unit ".$Unit_Name.". Preparing it's data...</p>";
			//*///-Debug-//////
			
			$Keys[] = $Entry[1];
			
			$Data[] = array(
				'Unit_ID' => $Unit_ID,
				'Unit_Type' => $Unit_Type,
				'Unit_Owner' => $Player_IDs[$Owner]
			);
			
			/*//-Debug-/////
			echo '<p>Function: '.__Function__.' Raw Array:</p>';
			foreach ($Raw as $Key => $Value){
				echo '<p>'.$Key.' = '.$Value.'</p>';
			}
			//*/////////////

			
			/*///-Debug-//////
			echo "<p>Done preparing data for Unit ".$Unit_Name.".</p><br />";
			//*///-Debug-//////
			
		}
		
		$Database->commit();
		
		$this->Entry_ID[$Match] = insertMultiple($Database, get_class($this), $Data, $Keys);
		
		//*///-Debug-//////
		$time_end = microtime(true);
		$time = round(($time_end - $time_start), 4);
		echo '
				<p>Completed '.get_class($this).'->'.__Function__.' in '. $time .' seconds.</p>
			</div>
		';
		//*///-Debug-//////
	}
}

class AbilityData extends Data {
	
	protected $Fields = array(
		"Event ID",
		"Event Time",
		"Ability Name",
		"Ability Hotkey",
		"Ability Target Location X",
		"Ability Target Location Y",
		"Source Unit ID",
		"Source Unit Location X",
		"Source Unit Location Y",
		"Distance Between Unit and Target"
	);
	
}

class IdleData extends Data {

	protected $Fields = array(
		"Event ID",
		"Event Time",
		"Unit ID",
		"Is Idle",
		"Location X",
		"Location Y"
	);
	
}

class BuildData extends Data {

	protected $Fields = array(
		"Event ID",
		"Event Time",
		"Progress",
		"Unit ID",
		"Location X",
		"Location Y"
	);
	
	public function insertData($Database, $Match, $Unit_IDs){
		//*///-Debug-//////
		echo '
			<h3>Running '.get_class($this).' method: '.__Function__.'</h3>
			<div>
		';
		$time_start = microtime(true);
		//*///-Debug-//////
		
		$Keys = array();
		
		$Data = array();
		
		foreach($this->Data[$Match] as $Entry){
			
			$Keys[] = $Entry[0];
			
			$Data[] = array(
				'Event_ID' 			=> $Entry[0],
				'Event_Time' 		=> $Entry[1],
				'Progress' 			=> $Entry[2],
				'Source_Unit_ID' 	=> $Unit_IDs[$Entry[3]],
				'Location_X' 		=> $Entry[4],
				'Location_Y' 		=> $Entry[5]
			);
		}
		
		$this->Entry_ID[$Match] = insertMultiple($Database, get_class($this), $Data, $Keys);
		
		//*///-Debug-//////
		$time_end = microtime(true);
		$time = round(($time_end - $time_start), 4);
		echo '
				<p>Completed '.get_class($this).'->'.__Function__.' in '. $time .' seconds.</p>
			</div>
		';
		//*///-Debug-//////
	}
}

class BirthData extends Data {
	
	protected $Fields = array(
		"Event ID",
		"Event Time",
		"Unit ID",
		"Location X",
		"Location Y"
	);
	
	public function insertData($Database, $Match, $Unit_IDs){
		//*///-Debug-//////
		echo '
			<h3>Running '.get_class($this).' method: '.__Function__.'</h3>
			<div>
		';
		$time_start = microtime(true);
		//*///-Debug-//////
		
		$Keys = array();
		
		$Data = array();
		
		foreach($this->Data[$Match] as $Entry){
			
			$Keys[] = $Entry[0];
			
			$Data[] = array(
				'Event_ID' 		=> $Entry[0],
				'Event_Time' 	=> $Entry[1],
				'Unit_ID' 		=> $Unit_IDs[$Entry[2]],
				'Location_X' 	=> $Entry[3],
				'Location_Y' 	=> $Entry[4]
			);
		}
		
		$this->Entry_ID[$Match] = insertMultiple($Database, get_class($this), $Data, $Keys);
		
		//*///-Debug-//////
		$time_end = microtime(true);
		$time = round(($time_end - $time_start), 4);
		echo '
				<p>Completed '.get_class($this).'->'.__Function__.' in '. $time .' seconds.</p>
			</div>
		';
		//*///-Debug-//////
	}
}

class DeathData extends Data {
	
	protected $Fields = array(
		"Event ID",
		"Event Time",
		"Triggering Unit ID",
		"Triggering Unit Location X",
		"Triggering Unit Location Y",
		"Killing Unit ID",
		"Killing Unit Location X",
		"Killing Unit Location Y",
		"Distance Between Units"
	);
	
	public function insertData($Database, $Match, $Unit_IDs){
		//*///-Debug-//////
		echo '
			<h3>Running '.get_class($this).' method: '.__Function__.'</h3>
			<div>
		';
		$time_start = microtime(true);
		//*///-Debug-//////
		
		$Keys = array();
		
		$Data = array();
		
		foreach($this->Data[$Match] as $Entry){
			
			$Keys[] = $Entry[0];
			
			$Data[] = array(
				'Event_ID' 						=> $Entry[0],
				'Event_Time' 					=> $Entry[1],
				'Triggering_Unit_ID' 			=> $Unit_IDs[$Entry[2]],
				'Triggering_Unit_Location_X' 	=> $Entry[3],
				'Triggering_Unit_Location_Y' 	=> $Entry[4],
				'Killing_Unit_ID' 				=> $Unit_IDs[$Entry[5]],
				'Killing_Unit_Location_X' 		=> $Entry[6],
				'Killing_Unit_Location_Y' 		=> $Entry[7],
				'Distance_Between_Units' 		=> $Entry[8]
			);
			
		}
		
		$this->Entry_ID[$Match] = insertMultiple($Database, get_class($this), $Data, $Keys);
		
		$Database->beginTransaction();
		
		foreach($Unit_IDs as $Unit){
			$Kills = selectFields($Database, "DeathData", array("Killing_Unit_ID" => $Unit));
			/*///-Debug-//////
			echo '<pre>';
			print_r(var_dump($Kills), true);
			echo '</pre>';
			//*///-Debug-//////
			$MineralValue = 0;
			$VespeneValue = 0;
			if(is_array($Kills) && is_array(@$Kills[0])){
				foreach($Kills as $Kill){
					$UnitType = selectFields($Database, "UnitData", array("Entry_ID" => $Kill['Triggering_Unit_ID']), 'Unit_Type');
					$KillData = selectFields($Database, "Units", array("Unit_Type" => $UnitType));
					$MineralValue += $KillData['Mineral_Cost'];
					$VespeneValue += $KillData['Vespene_Cost'];
				}
			} elseif (is_array($Kills)) {
				$UnitType = selectFields($Database, "UnitData", array("Entry_ID" => $Kills['Triggering_Unit_ID']), 'Unit_Type');
				$KillData = selectFields($Database, "Units", array("Unit_Type" => $UnitType));
				$MineralValue += $KillData['Mineral_Cost'];
				$VespeneValue += $KillData['Vespene_Cost'];
			}
			updateField($Database, "UnitData", "Kills", count($Kills), "Entry_ID", $Unit);
			updateField($Database, "UnitData", "Kills_Mineral_Value", $MineralValue, "Entry_ID", $Unit);
			updateField($Database, "UnitData", "Kills_Vespene_Value", $VespeneValue, "Entry_ID", $Unit);	
		}
		
		$Database->commit();
		
		//*///-Debug-//////
		$time_end = microtime(true);
		$time = round(($time_end - $time_start), 4);
		echo '
				<p>Completed '.get_class($this).'->'.__Function__.' in '. $time .' seconds.</p>
			</div>
		';
		//*///-Debug-//////
	}
	
	public function heatmapTriggeringCoords($Match, $Size_Y) {
		
		$String = "";
		
		foreach ($this->Data[$Match] as $Event){
			$String .= "{x:".(($Event[3] * 10) / 4).", y:".((($Size_Y - $Event[4]) * 10) / 4) ."}, \n";
		}
		
		return substr($String, 0 ,-3);
	}
	
	public function heatmapKillingCoords($Match) {
		foreach ($this->Data[$Match] as $Event){
			print_r("{x:".$Event[6] .", y:".$Event[7]."},", true);	
		}
	}
	
}

class ResearchData extends Data {
	
	protected $Fields = array(
		"Event ID",
		"Event Time",
		"Progress",
		"Upgrade Name",
		"Unit ID",
		"Location X",
		"Location Y"
	);
	
	public function insertData($Database, $Match, $Unit_IDs){
		//*///-Debug-//////
		echo '
			<h3>Running '.get_class($this).' method: '.__Function__.'</h3>
			<div>
		';
		$time_start = microtime(true);
		//*///-Debug-//////
		
		$Keys = array();
		
		$Data = array();
		
		$Database->beginTransaction();
		
		foreach($this->Data[$Match] as $Entry){
			
			$Upgrade_Name = $Entry[3];
			
			if(entry_exists($Database,"Upgrades","Upgrade_Name",$Upgrade_Name) === true){
				$Upgrade_ID = selectFields($Database, "Upgrades", array("Upgrade_Name" => $Upgrade_Name), "Upgrade_ID");
			}else{
				echo "<p>Upgrade ".$Upgrade_Name." does not already exist in the Database. Adding it and grabbing it's ID.</p>";
				
				$Upgrade = array(
					'Upgrade_Name' => $Upgrade_Name
				);
				
				$Upgrade_ID = insertSingle($Database, 'Upgrades', $Upgrade);
			}
			
			$Keys[] = $Entry[0];
			
			$Data[] = array(
				'Event_ID' 		=> $Entry[0],
				'Event_Time' 	=> $Entry[1],
				'Progress' 		=> $Entry[2],
				'Upgrade_Type' 	=> $Upgrade_ID,
				'Unit_ID' 		=> $Unit_IDs[$Entry[4]],
				'Location_X' 	=> $Entry[5],
				'Location_Y' 	=> $Entry[6]
			);
		}
		
		$Database->commit();
		
		$this->Entry_ID[$Match] = insertMultiple($Database, get_class($this), $Data, $Keys);
		
		//*///-Debug-//////
		$time_end = microtime(true);
		$time = round(($time_end - $time_start), 4);
		echo '
				<p>Completed '.get_class($this).'->'.__Function__.' in '. $time .' seconds.</p>
			</div>
		';
		//*///-Debug-//////
	}
	
}

class PeriodicData extends Data {
	
	protected $Fields = array(
		"Event ID",
		"Event Time",
		"Player Num",
		"APM ",
		"Average Minerals Stockpiled",
		"Average Vespene Stockpiled",
		"Combat Efficiency",
		"Supply Efficiency",
		"Damage Dealt",
		"Energy Spent",
		"Economy Energy Available",
		"Economy Energy Total",
		"Life Spent",
		"Damage Taken",
		"Shields Damage Taken",
		"Life Healed",
		"Shields Regenerated",
		"Minerals Gathered",
		"Minerals Collection Rate",
		"Minerals Received",
		"Minerals Spent",
		"Minerals Traded",
		"Minerals Available",
		"Vespene Gathered",
		"Vespene Collection Rate",
		"Vespene Received",
		"Vespene Spent",
		"Vespene Traded",
		"Vespene Available",
		"Supply Used",
		"Supply Available",
		"Supply Killed",
		"Supply Lost",
		"Army Size",
		"Units Trained",
		"Units Trained Minerals Spent",
		"Units Trained Vespene Spent",
		"Units Lost",
		"Units Lost Mineral Value",
		"Units Lost Vespene Value",
		"Units Killed",
		"Units Killed Mineral Value",
		"Units Killed Vespene Value",
		"Worker Count",
		"Workers Lost",
		"Workers Trained",
		"Structures Built",
		"Structures Lost",
		"Structures Razed",
		"Upgrades Researched",
		"Upgrades Mineral Value",
		"Upgrades Minerals Lost",
		"Upgrades Vespene Value",
		"Upgrades Vespene Lost"
	);

	public function insertData($Database, $Match, $Player_IDs){
		//*///-Debug-//////
		echo '
			<h3>Running '.get_class($this).' method: '.__Function__.'</h3>
			<div>
		';
		$time_start = microtime(true);
		//*///-Debug-//////
		
		$Keys = array();
		
		$Data = array();
		
		foreach($this->Data[$Match] as $Entry){
			
			$Player_Num = $Entry[2];
			
			$Keys[] = $Entry[0];
			
			$i = 0;
			
			$Data[] = array(
				"Event_ID" 							=> $Entry[$i++],
				"Event_Time" 						=> $Entry[$i+=2],
				"Player_Num" 						=> $Player_IDs[$Player_Num],
				"APM" 								=> $Entry[$i++],
				"Average_Minerals_Stockpiled" 		=> $Entry[$i++],
				"Average_Vespene_Stockpiled" 		=> $Entry[$i++],
				"Combat_Efficiency" 				=> $Entry[$i++],
				"Supply_Efficiency" 				=> $Entry[$i++],
				"Damage_Dealt" 						=> $Entry[$i++],
				"Energy_Spent" 						=> $Entry[$i++],
				"Economy_Energy_Available" 			=> $Entry[$i++],
				"Economy_Energy_Total" 				=> $Entry[$i++],
				"Life_Spent" 						=> $Entry[$i++],
				"Damage_Taken" 						=> $Entry[$i++],
				"Shields_Damage_Taken" 				=> $Entry[$i++],
				"Life_Healed" 						=> $Entry[$i++],
				"Shields_Regenerated" 				=> $Entry[$i++],
				"Minerals_Gathered" 				=> $Entry[$i++],
				"Minerals_Collection_Rate" 			=> $Entry[$i++],
				"Minerals_Received" 				=> $Entry[$i++],
				"Minerals_Spent" 					=> $Entry[$i++],
				"Minerals_Traded" 					=> $Entry[$i++],
				"Minerals_Available" 				=> $Entry[$i++],
				"Vespene_Gathered" 					=> $Entry[$i++],
				"Vespene_Collection_Rate" 			=> $Entry[$i++],
				"Vespene_Received" 					=> $Entry[$i++],
				"Vespene_Spent" 					=> $Entry[$i++],
				"Vespene_Traded" 					=> $Entry[$i++],
				"Vespene_Available" 				=> $Entry[$i++],
				"Supply_Used" 						=> $Entry[$i++],
				"Supply_Available" 					=> $Entry[$i++],
				"Supply_Killed" 					=> $Entry[$i++],
				"Supply_Lost" 						=> $Entry[$i++],
				"Army_Size" 						=> $Entry[$i++],
				"Units_Trained" 					=> $Entry[$i++],
				"Units_Trained_Minerals_Spent" 		=> $Entry[$i++],
				"Units_Trained_Vespene_Spent" 		=> $Entry[$i++],
				"Units_Lost" 						=> $Entry[$i++],
				"Units_Lost_Mineral_Value" 			=> $Entry[$i++],
				"Units_Lost_Vespene_Value" 			=> $Entry[$i++],
				"Units_Killed" 						=> $Entry[$i++],
				"Units_Killed_Mineral_Value" 		=> $Entry[$i++],
				"Units_Killed_Vespene_Value" 		=> $Entry[$i++],
				"Worker_Count" 						=> $Entry[$i++],
				"Workers_Lost" 						=> $Entry[$i++],
				"Workers_Trained" 					=> $Entry[$i++],
				"Structures_Built" 					=> $Entry[$i++],
				"Structures_Lost" 					=> $Entry[$i++],
				"Structures_Razed" 					=> $Entry[$i++],
				"Upgrades_Researched" 				=> $Entry[$i++],
				"Upgrades_Mineral_Value" 			=> $Entry[$i++],
				"Upgrades_Minerals_Lost" 			=> $Entry[$i++],
				"Upgrades_Vespene_Value" 			=> $Entry[$i++],
				"Upgrades_Vespene_Lost" 			=> $Entry[$i++]
			);
		}
		
		$this->Entry_ID[$Match] = insertMultiple($Database, get_class($this), $Data, $Keys);
		
		//*///-Debug-//////
		$time_end = microtime(true);
		$time = round(($time_end - $time_start), 4);
		echo '
				<p>Completed '.get_class($this).'->'.__Function__.' in '. $time .' seconds.</p>
			</div>
		';
		//*///-Debug-//////
	}

}

class resizeImage {
	
	/*
	* File: SimpleImage.php
	* Author: Simon Jarvis
	* Copyright: 2006 Simon Jarvis
	* Date: 08/11/06
	* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
	*
	* This program is free software; you can redistribute it and/or
	* modify it under the terms of the GNU General Public License
	* as published by the Free Software Foundation; either version 2
	* of the License, or (at your option) any later version.
	*
	* This program is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	* GNU General Public License for more details:
	* http://www.gnu.org/licenses/gpl.html
	*
	*/
	
	protected $image;
	protected $image_type;
	
	function load($filename) {
		
		$image_info = getimagesize($filename);
		$this->image_type = $image_info[2];
		
		if( $this->image_type == IMAGETYPE_JPEG ) {
			
			$this->image = imagecreatefromjpeg($filename);
		} elseif( $this->image_type == IMAGETYPE_GIF ) {
			
			$this->image = imagecreatefromgif($filename);
		} elseif( $this->image_type == IMAGETYPE_PNG ) {
			
			$this->image = imagecreatefrompng($filename);
		}
	}
	
	function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
		
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg($this->image,$filename,$compression);
		} elseif( $image_type == IMAGETYPE_GIF ) {
		
			imagegif($this->image,$filename);
		} elseif( $image_type == IMAGETYPE_PNG ) {
		
			imagepng($this->image,$filename);
		}
		
		if( $permissions != null) {
		
			chmod($filename,$permissions);
		}
	}
	
	function output($image_type=IMAGETYPE_JPEG) {
	
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg($this->image);
		} elseif( $image_type == IMAGETYPE_GIF ) {
		
			imagegif($this->image);
		} elseif( $image_type == IMAGETYPE_PNG ) {
		
			imagepng($this->image);
		}
	}
	
	function getWidth() {
	
		return imagesx($this->image);
	}
	
	function getHeight() {
	
		return imagesy($this->image);
	}
	
	function resizeToHeight($height) {
	
		$ratio = $height / $this->getHeight();
		$width = $this->getWidth() * $ratio;
		$this->resize($width,$height);
	}
	
	function resizeToWidth($width) {
		$ratio = $width / $this->getWidth();
		$height = $this->getheight() * $ratio;
		$this->resize($width,$height);
	}
	
	function scale($scale) {
		$width = $this->getWidth() * $scale/100;
		$height = $this->getheight() * $scale/100;
		$this->resize($width,$height);
	}
	
	function scaleProportional($scale) {
		if ($this->getWidth() > $this->getHeight()) {
			$this->resizeToWidth($scale);
		} else {
			$this->resizeToHeight($scale);
		}
	}  
	
	function resize($width,$height) {
		$new_image = imagecreatetruecolor($width, $height);
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		$this->image = $new_image;
	}      
	
}

class HeatMapPoint{
	public $x,$y;
	function __construct($x,$y) {
		$this->x = $x;
		$this->y = $y;
	}
	function __toString() {
		return "({$this->x},{$this->y})";
	}
}//Point

class HeatMap{
	// Heatmap Class by Olivier G. <olbibigo_AT_gmail_DOT_com>

	//TRANSPARENCY
	public static $WITH_ALPHA = 0;
	public static $WITH_TRANSPARENCY = 1;
	//GRADIENT STYLE
	public static $GRADIENT_CLASSIC = 'classic';
	public static $GRADIENT_FIRE = 'fire';
	public static $GRADIENT_PGAITCH = 'pgaitch';
	//GRADIENT MODE (for heatImage)
	public static $GRADIENT_NO_NEGATE_NO_INTERPOLATE = 0;
	public static $GRADIENT_NO_NEGATE_INTERPOLATE = 1;
	public static $GRADIENT_NEGATE_NO_INTERPOLATE = 2;
	public static $GRADIENT_NEGATE_INTERPOLATE = 3;
	//NOT PROCESSED PIXEL (for heatImage)
	public static $KEEP_VALUE = 0;
	public static $NO_KEEP_VALUE = 1;
	//CONSTRAINTS
	private static $MIN_RADIUS = 2;//in px
	private static $MAX_RADIUS = 50;//in px
	private static $MAX_IMAGE_SIZE = 10000;//in px
	
	//generate an $image_width by $image_height pixels heatmap image of $points
	public static function createImage($data, $image_width, $image_height, $mode=0, $spot_radius = 30, $dimming = 75, $gradient_name = 'classic'){
		$_gradient_name = $gradient_name;
		if(($_gradient_name != self::$GRADIENT_CLASSIC) && ($_gradient_name != self::$GRADIENT_FIRE) && ($_gradient_name != self::$GRADIENT_PGAITCH)){
			$_gradient_name = self::$GRADIENT_CLASSIC;
		}
		$_image_width = min(self::$MAX_IMAGE_SIZE, max(0, intval($image_width)));
		$_image_height = min(self::$MAX_IMAGE_SIZE, max(0, intval($image_height)));
		$_spot_radius = min(self::$MAX_RADIUS, max(self::$MIN_RADIUS, intval($spot_radius)));
		$_dimming = min(255, max(0, intval($dimming)));
		if(!is_array($data)){
			return false;
		}
		$im = imagecreatetruecolor($_image_width, $_image_height);
		$white = imagecolorallocate($im, 255, 255, 255);
		imagefill($im, 0, 0, $white);
		if(self::$WITH_ALPHA == $mode){
			imagealphablending($im, false);
			imagesavealpha($im,true);
		}
		//Step 1: create grayscale image
		foreach($data as $datum){
			if( (is_array($datum) && (count($datum)==1)) || (!is_array($datum) && ('HeatMapPoint' == get_class($datum)))){//Plot points
				if('HeatMapPoint' != get_class($datum)){
					$datum = $datum[0];
				}
				self::_drawCircularGradient($im, $datum->x, $datum->y, $_spot_radius, $_dimming);
			}else if(is_array($datum)){//Draw lines
				$length = count($datum)-1;
				for($i=0; $i < $length; ++$i){//Loop through points
					//Bresenham's algorithm to plot from from $datum[$i] to $datum[$i+1];
					self::_drawBilinearGradient($im, $datum[$i], $datum[$i+1], $_spot_radius, $_dimming);
				}
			}
		}
		//Gaussian filter
		if($_spot_radius >= 30){
			imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
		}
		//Step 2: create colored image
		if(FALSE === ($grad_rgba = self::_createGradient($im, $mode, $_gradient_name))){
			return FALSE;
		}
		$grad_size = count($grad_rgba);
		for($x=0; $x <$_image_width; ++$x){
			for($y=0; $y <$_image_height; ++$y){
				$level = imagecolorat($im, $x, $y) & 0xFF;
				if( ($level >= 0) && ($level < $grad_size) ){
					imagesetpixel($im, $x, $y, $grad_rgba[imagecolorat($im, $x, $y) & 0xFF]);
				}
			}
		}
		if(self::$WITH_TRANSPARENCY == $mode){
			imagecolortransparent($im, $grad_rgba[count($grad_rgba)-1]);
		}
		return $im;
	}//createImage

	//Heat an image
	public static function heatImage($filepath, $gradient_name = 'classic', $mode= 0, $min_level=0, $max_level=255, $gradient_interpolate=0, $keep_value=0){
		$_gradient_name = $gradient_name;
		if(($_gradient_name != self::$GRADIENT_CLASSIC) && ($_gradient_name != self::$GRADIENT_FIRE) && ($_gradient_name != self::$GRADIENT_PGAITCH)){
			$_gradient_name = self::$GRADIENT_CLASSIC;
		}
		$_min_level = min(255, max(0, intval($min_level)));
		$_max_level = min(255, max(0, intval($max_level)));

		//try opening jpg first then png then gif format
		if(FALSE === ($im = @imagecreatefromjpeg($filepath))){
			if(FALSE === ($im = @imagecreatefrompng($filepath))){
				if(FALSE === ($im = @imagecreatefromgif($filepath))){
					return FALSE;
				}
			}
		}
		if(self::$WITH_ALPHA == $mode){
			imagealphablending($im, false);
			imagesavealpha($im,true);
		}
		$width = imagesx($im);
		$height = imagesy($im);	
		if(FALSE === ($grad_rgba = self::_createGradient($im, $mode, $_gradient_name))){
			return FALSE;
		}
		//Convert to grayscale
		$grad_size = count($grad_rgba);
		$level_range = $_max_level - $_min_level;
		for($x=0; $x <$width; ++$x){
			for($y=0; $y <$height; ++$y){
				$rgb = imagecolorat($im, $x, $y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
				$gray_level = Min(255, Max(0, floor(0.33 * $r + 0.5 * $g + 0.16 * $b)));//between 0 and 255				
				if( ($gray_level >= $_min_level) && ($gray_level <= $_max_level) ){
					switch($gradient_interpolate){
						case self::$GRADIENT_NO_NEGATE_NO_INTERPOLATE:
							//$_max_level takes related lowest gradient color
							//$_min_level takes related highest gradient color
							$value = 255 - $gray_level;
							break;
						case self::$GRADIENT_NEGATE_NO_INTERPOLATE:
							//$_max_level takes related highest gradient color
							//$_min_level takes related lowest gradient color
							$value = $gray_level;
							break;
						case self::$GRADIENT_NO_NEGATE_INTERPOLATE:
							//$_max_level takes lowest gradient color
							//$_min_level takes highest gradient color
							$value = 255- floor(($gray_level - $_min_level) * $grad_size / $level_range);
							break;
						case self::$GRADIENT_NEGATE_INTERPOLATE:
							//$_max_level takes highest gradient color
							//$_min_level takes lowest gradient color
							$value = floor(($gray_level - $_min_level) * $grad_size / $level_range);
							break;
						default:
					}
					imagesetpixel($im, $x, $y, $grad_rgba[$value]);
				}else{
					if(self::$KEEP_VALUE == $keep_value){
						//Do nothing
					}else{//self::$NO_KEEP_VALUE
						imagesetpixel($im, $x, $y, imagecolorallocatealpha($im,0,0,0,0));
					}
				}
			}
		}			
		if(self::$WITH_TRANSPARENCY == $mode){
			imagecolortransparent($im, $grad_rgba[count($grad_rgba)-1]);
		}
		return $im;
	}//heatImage
	
	private static function _drawCircularGradient(&$im, $center_x, $center_y, $spot_radius, $dimming){
		$dirty = array();
		$ratio = (255 - $dimming) / $spot_radius;
		for($r=$spot_radius; $r > 0; --$r){
			$channel = $dimming + $r * $ratio;
			$angle_step = 0.45/$r; //0.01;
			//Process pixel by pixel to draw a radial grayscale radient
			for($angle=0; $angle <= PI2; $angle += $angle_step){
				$x = floor($center_x + $r*cos($angle));
				$y = floor($center_y + $r*sin($angle));
				if(!isset($dirty[$x][$y])){
					$previous_channel = imagecolorat($im, $x, $y) & 0xFF;//grayscale so same value
					$new_channel = Max(0, Min(255,($previous_channel * $channel)/255));
					imagesetpixel($im, $x, $y, imagecolorallocate($im, $new_channel, $new_channel, $new_channel));
					$dirty[$x][$y] = 0;
				}
			}
		}
	}//_drawCircularGradient
	
	private static function _drawBilinearGradient(&$im, $point0, $point1, $spot_radius, $dimming){
		if($point0->x < $point1->x){
			$x0 = $point0->x;
			$y0 = $point0->y;
			$x1 = $point1->x;
			$y1 = $point1->y;
		}else{
			$x0 = $point1->x;
			$y0 = $point1->y;
			$x1 = $point0->x;
			$y1 = $point0->y;
		}

		if( ($x0==$x1) && ($y0==$y1)){//check if same coordinates
			return false;
		}
		$steep = (abs($y1 - $y0) > abs($x1 - $x0))? true: false;
		if($steep){
			list($x0, $y0) = array($y0, $x0);//swap
			list($x1, $y1) = array($y1, $x1);//swap
		}
		if($x0>$x1){
			list($x0, $x1) = array($x1, $x0);//swap
			list($y0, $y1) = array($y1, $y0);//swap
		}
		$deltax = $x1 - $x0;
		$deltay = abs($y1 - $y0);
		$error = $deltax / 2;
		$y = $y0;
		if( $y0 < $y1){
			$ystep = 1; 
		}else{
			$ystep = -1;
		}
		$step = max(1, floor($spot_radius/ 3));
		for($x=$x0; $x<=$x1; ++$x){//Loop through x value
			if(0==(($x-$x0) % $step)){
				if($steep){
					self::_drawCircularGradient($im, $y, $x, $spot_radius, $dimming);
				}else{ 
					self::_drawCircularGradient($im, $x, $y, $spot_radius, $dimming);
				}
			}
			$error -= $deltay;
			if($error<0){
					$y = $y + $ystep;
					$error = $error + $deltax;
			}
		}		
	}//_drawBilinearGradient
	
	private static function _createGradient($im, $mode, $gradient_name){
		//create the gradient from an image
		if(FALSE === ($grad_im = imagecreatefrompng('gradient/'.$gradient_name.'.png'))){
			return FALSE;
		}
		$width_g = imagesx($grad_im);
		$height_g = imagesy($grad_im);
		//Get colors along the longest dimension
		//Max density is for lower channel value
		for($y=$height_g-1; $y >= 0 ; --$y){
				$rgb = imagecolorat($grad_im, 1, $y);
				//Linear function
				$alpha = Min(127, Max(0, floor(127 - $y/2)));
				if(self::$WITH_ALPHA == $mode){
					$grad_rgba[] = imagecolorallocatealpha($im, ($rgb >> 16) & 0xFF, ($rgb >> 8) & 0xFF, $rgb & 0xFF, $alpha);
				}else{
					$grad_rgba[] = imagecolorallocate($im, ($rgb >> 16) & 0xFF, ($rgb >> 8) & 0xFF, $rgb & 0xFF);
				}
		}
		imagedestroy($grad_im);
		unset($grad_im);
		return($grad_rgba);
	}//_createGradient
}
?>