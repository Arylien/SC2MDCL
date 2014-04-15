SC2MDCL
=======

StarCraft 2 Melee Data Collection Library

The SC2 MDCL project is a prototype website for the collection and data-mining gameplay statistics for StarCraft 2: Heart of the Swarm. 

Raw gameplay data is collected via a custom Trigger library developed in the StarCraft 2 Editor itself, which has been uploaded as an Extension Mod. This mod can be applied to any melee map and will automatically record gameplay statistics to a .SC2Bank file stored locally on each player's computer. Despite the file extension, this data is simply raw XML recorded as event strings in a CSV format for easy parsing in PHP and to minimize file size. Some example Bank files are included in order to better understand the format.

The MDCL Mod itself can be found using the following links for each region:

NA: starcraft://map/1/204576
EU: starcraft://map/2/160296
KR: starcraft://map/3/80753
SEA: starcraft://map/6/21192

To use the mod, simply create a new game from the Custom Games menu, select a map to play on, and choose Create With Mod. Then search for Melee Data Collection Library and click Create Game, continuing your normal match setup from there. The mod will record data from AI players as well, enabling solo testing of the mod.

Data collected will be saved in your StarCraft II folder under My Documents on Windows. The directory structure varies per account/region, so a little digging will be required. Follow these steps to locate the Bank files:

1. In general, from the StarCraft II root folder, go to Accounts, in which will be one or more folders named with a string of digits. This represents your Battle.net account ID. 
2. Under each of thse folders will be a separate folder for each region and StarCraft II account associated with your Battle.net account. 
3. Once you have determined which folder represents the account you played with, you will find a folder named Banks, in which will be separate folders for each map you have played. Due to the nature of how extension mods work, bank files created by this mod will appear in the folder for the map it was applied to. Unfortunately there is no easier way to determine which of these folders to look under. 
4. The Bank files themselves will always be named in the following format: MDCL11223344556677889900AABBCCDDEEFF.SC2Bank (MDCL + a random 32 digit Hex string). The easiest way to determine the most recently saved bank file is to look at the Date Modified timestamp for each file.

Once located, these files can be uploaded to the website component of the project, which will then parse the data into the database.

All of the files necessary to create a working copy of the website are included here. Please note that in order to complete the setup, you will need to edit the config.php file with your machine's database information. 

From there, simply open the admin.php page in your browser and click on 'Reset Database' to recreate the database table structure from the included .sql file in the backup folder. 

To quickly populate the database with the included example bank files, click the 'Rebuild Database' button to execute parsing of these files. WARNING: This operation will take quite a bit of time! Do not interrupt the process or else you will have to reset the database and start over!

Please note that map images were created manually from the SC2 editor itself. In order to add new maps other than the ones included in this project, you will have to create these map images yourself!!!

This project is provided AS-IS and comes without any support and I will accept no responsibility for any issues you may run into while using it. The project is released under an MIT license, so feel free to tinker with it as you please, so long as you provide credit!
