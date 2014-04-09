<?
//////////// Header Information ////////////
// Include essential scripts.
require_once 'login.php';
require_once 'lists.php';
require_once 'functions.php';

// Include the page header and set script variables.
$PageName = ucwords(basename(__FILE__, '.php'));
$jqueryui = (bool) true;
$lightbox = (bool) true;
//$heatmap = (bool) true;
//$tablesorter = (bool) true;
require_once 'header.php';
//////////// End of Header ////////////

//////////// Page Contents ////////////

echo '<div class="thin">
	<div class="box">
		<div class="head">
			<center><strong>About</strong></center>
		</div>
		<div class="article">
		
			<h1>StarCraft II Melee Data Collection Library</h1>
			
			<p>How does one make a game like StarCraft better? This can be a very difficult task to accomplish, especially for a game that many still believe was perfect during the days of Brood War. However, perfection implies being free of the problems that players and developers both face on a daily basis. The Melee Data Collection Library aims to solve many of those problems by providing an unprecedented level of insight into how people play StarCraft. It accomplishes this using a combination of a Trigger Library to collect and output statistical gameplay data and a website powered by PHP + MySQL to store, search, and display this information in a format that\'s both easy to understand and simple to use. Here are a few examples of what this project can do:</p>

			<p>For Players, Spectators, and Casters:</p>
			<ul>
				<li>Provides players with a detailed view of their performance over time, shedding light on the areas in which they can improve the way they play.</li>
				<li>Gives pro players new tools with which they can formulate strategies to use against specific opponents or matchups on any given map.</li>
				<li>Presents a wealth of new information for casters to use in their commentary and the content they display live during their stream.</li>
			</ul>

			<p>For Developers:</p>
			<ul>
				<li>Provides unbiased and exceedingly detailed information about how players actually play the game, largely eliminating the reliance currently placed on players to voluntarily submit feedback.</li>
				<li>Grants an unparalleled ability to focus attention on information about specific regions, leagues, game modes, maps, races, units, or abilities and their relationships.</li>
				<li>Gives developers a quantitative and comprehensive way to measure the effects balance changes have on player behavior.</li>
			</ul>

			<h2>Problems the Player faces:</h2>
			<hr>
			
			<p>In terms of melee, there are a few primary groups to consider: the average player, the Pro players, spectators, and casters. Each is largely concerned with a different aspect of the game, and has their own set of problems that they are constantly dealing with. Let’s take a look at each and go over how this project helps each of them.</p>

			<h3>Climbing the Ladder: The Average Player</h3>
	
			<p>Certainly one thing everyone who’s ever played StarCaft has wondered is: “how do I get better at this game?” This can be a frustrating problem to figure out, especially when common response from more advanced players is to just keep practicing. But what do you practice? How do you know what it is you’re not doing very well? This is where the Melee Data Collection Library can help. Unlike the score screen displayed at the end of the game (which gives you a very simplified overview of your performance for that particular match) this project would collect detailed information about all of your actions (and inactions) and keep track of your overall performance over time.</p>
			
			<p>What this means to the player is they can look at specific aspects of their behavior and compare their performance to different player groups (or even specific players). Given the vast amount of information being recorded, the statistics players can view can be broad summaries such as overall Combat Efficiency over time, or as detailed as the average number of SCVs lost to Hellions on Daybreak. In this prototype build, you can look at some unit specific performance statistics on each Player’s page, such as Average Kills Per Unit, Overall Kill/Death Ratio, and Average Kill Distance to name a few. (<a target="_blank" href="http://50.150.79.168/apps/MDCL/players.php?player=5">Click here for an example</a>) Armed with this information, the players can make informed decisions on what they should practice in order to improve and continue climbing the ladder.</p>

			<h3>Besting the Competition: The Pro Player</h3>
			
			<p>If you’ve ever followed eSports, you know how much time and effort Pro Players put into practicing for their next big match. Nowhere is this more important than in Proleague, where formulating a strategy against your next opponent is everything. This can be as difficult a skill to master as simply playing the game, due to the wide variety of variables to consider. You have to be ready for any combination of strategies that can be executed on any given map and you need to be able to keep up with the meta-game (the constantly shifting rules and behaviors that exist outside the bounds of the game itself). Most of all, you need to know how your opponent thinks, so you can anticipate his every decision. The tools Pros have at their disposal for dealing with this are very limited. Where observation and practicing scenarios can help, it’s still difficult to see exactly what’s going on. Similar to how this project can help the average player, Pros can utilize the same features that allow them to find weaknesses in the way they play to find their opponents weaknesses.</p>
			
			<p>Let’s use a very specific example: Flash and Jaedong have an upcoming match in Proleague on Cloud Kingdom. Using traditional methods, each player can watch replays of previous matches their opponent played on that map or matches where their opponent had the same matchup, so they can get an idea of how their opponent will behave, and after reviewing the matches they will practice against their teammates who will attempt to play in a similar style as their opponent. An issue present here is that it’s very difficult to discern your opponent’s decision-making process. With the help of this project, one could quickly search for every match a player has ever played (on any specific map or in any matchup) and from there see statistics gathered about that player’s performance in those matches. What this means is Jaedong could quickly find out how Flash usually performs versus Zerg, discover his points of weakness, and then plan to exploit those weaknesses specifically.</p>
			
			<p>To use a broader example, let’s consider the meta-game. There are many aspects to the it, but one way to think about the meta-game is the trends in the strategies players employ in specific regions of the world, during specific points in time, such as after a balance patch. It can be hard to spot these trends from the inside due to one’s limited perspective. These trends usually begin outside of the game through community discussion, where players will then try practicing the new strategies on the ladder in order to perfect playing them (or defeating them). Due to the flexibility of this project’s design, it’s not difficult to build tools that can seek out and track these strategic shifts. Some examples include:</p>
			
			<ul> 
				<li>Graphing the average number of Infestors built by players over a given time period in a specific region of the world and in a specific league.</li>
				<li>Discovering the percentage of games played by Terran where Hellions are built within the first 8 minutes of the game on a specific map.</li>
				<li>The average distance a Void Ray makes a kill from after a balance patch which buffed their attack range.</li>
			</ul>

			<p>The ability to search for information such as the listed above can be really useful to pro players who are looking to get ahead of the competition, and getting answers to strategy questions using this tool can be much faster than through experimentation.</p>
			
			<h3>The Excitement and the Drama: Casters and Spectators</h3>
			
			<p>It’s game three of a nail-biting series in GSL Code S, 40 minutes have gone by and Gumiho has kept Losira on his toes while both players tech and vie for map control. Tasteless and Artosis are speculating wildly as to who will come out on top as they cast what will possibly be remembered as the greatest game in Wings of Liberty. Fifty minutes in, Gumiho’s insane micro has reduced Losira’s army down to a handful of Corruptors, two Queens, an Ultralisk, and a mass of Spine Crawlers. For the next 45 minutes these two players try to out-position and out-micro each other with the handful of units they have left. Without the casters’ excellent ability to keep viewers excited, this marathon of a match would have been quite dull to watch near the end. Unfortunately, not every match is cast by “Tastosis the Casting Archon” and not every match is as exciting as this recent example.</p>
			
			<p>Unless you’re already familiar with the game and the players, it can be really confusing trying to make sense of what’s going on, much less get excited by what it is you’re watching. Often its commentary provided by a caster that gets people interested in watching a stream at all. But how many times can you sling the same win/loss records and tournament results around before it starts sounding the same? How many times can you talk about a standard forge fast expand opening and still get the crowd excited? This is a problem, because over time every player will begin to sound the same and it will only become more difficult to get new viewers interested in the game and cheering for pros. Casters know this is a problem, and some (like the guys at the North American Star League) are already advocating for more promotion of the players and their stories as one way to help. Another approach can be taken from the pages of traditional sports such as Baseball and Football, one that this project easily makes possible: ranking and comparing players based on their individual strengths and weaknesses.</p>
			
			<p>If we look at what’s available to casters right now in terms of resources, there isn’t a place to get detailed statistics about a player besides perhaps Liquipedia, which at best keeps track of tournament results and not much else. Largely, it’s up to the caster’s own ability to research and memorize information about a player to fuel their commentary, so it stands to reason that this project would greatly benefit them. Rather than spending countless hours watching VoD’s and replays, all of this information could be available at their fingertips and pulled up in a matter of seconds, freeing them to put more effort into creating additional content for their fans.</p>
			
			<p>Spectators would eat this information up, especially considering the success of baseball cards and fantasy football leagues, which utilize similar data. Fans want reasons to care about their favorite players, and being able to compare two players and definitively say that one is better than another at a particular aspect of the game plays a part in that. Win rates aren’t everything, as the pros are constantly proving  with the evolution of the meta-game. Researchers would love to have this sort of information for their studies in gameplay demographics, which would in turn produce more content for the community to enjoy.</p>
			
			<h2>Problems the Developer faces:</h2>
			<hr>
			
			<p>Of course, the data collected by this project is just as valuable to the development team as it is to the public. Balancing a game as complex as StarCraft can be an overwhelming task, but thankfully the Melee Data Collection Library can help here too. Specifically, let’s consider a few common problems: collecting feedback that is both detailed and unbiased, making changes that will affect a large player base in different ways, and measuring the effects of a balance adjustment.</p>
			
			<h3>Lost in Translation: Gathering Useful Feedback</h3>
			
			<p>Traditional methods of detecting imbalances rely on close observation and gathering feedback submitted by players. There are a number of issues present here, chief among them being Observation Bias, followed by poor communication, as well as requiring a significant amount of time. First let’s take a closer look at each.</p>
			
			<p>Regardless of whether you are a developer closely examining replays or a player relating your personal experience, those observations will always be skewed. A simple example is if you are looking for something specific, more often than not you will see what you want to see rather than what is actually going on. This can be quite common in StarCraft, wherein players are often quick to pay attention to the most easily observed parts of the game (such as Fungal Growth usage or Hellbat Drops). Obviously these things can have a huge effect on the outcome of the game, so it makes sense to assume that those  are the most imbalanced, right? In reality, those examples can largely be a result of a combination of factors, such as a failure to recognize what’s happening, not reacting quickly enough (or at all), or simply bad timing. On top of that, whether you’re looking at specific issues under a microscope or trying to find new ones through firsthand experience (or observing the other people’s experiences), you’ll never see the whole picture this way due to the massive number of games played every hour.</p>
			
			<p>When it comes to gathering feedback from players, there is always going to be a communication issue. The main problem is players are not developers, and thus they do not communicate like developers. Second, any feedback given by a player will potentially reach the developer through one or more third parties. So, when a player tries to give feedback, not only could they not understand what it is they are trying to communicate (which is often the case), each person who interprets the feedback along the path of communication to the developer may misinterpret it and further obfuscate the information.</p>
			
			<p>Then you have to take into consideration how much time it takes for developers to gather useful feedback to work with. Playing the game will take at minimum the length of each match (plus any additional review time after the match is finished). Observing matches will take a varied amount of time, depending on what aspect of the game you’re trying to observe. Finally, gathering feedback from players necessarily involves waiting on the players to voluntarily submit their findings (as well as however long it will take to interpret those findings). It can all easily add up to hours, days, weeks, even months before you can gather enough information to begin making changes.</p>
			
			<p>So how does the Melee Data Collection Library help? First off, due to its design, data can be collected from potentially every melee match (with support from Blizzard, of course). Second, the process is almost completely automated, with all of the raw data-gathering carried out using the trigger scripting system present in the game. Third, the data gathered is both incredibly detailed and unbiased, recording choice pieces of information about many player behavior related events (such as creating and killing units). Fourth, the method of collecting data is both flexible and extensible, meaning more detailed data can be gathered if needed. And most importantly, since this is all being done programmatically, it can be done much faster and more accurately than could ever be done by hand.</p>
';

echo '
		<h3>Tunnel Vision: Fair for the Top Tier (At the expense of the rest)</h3>
			
			<p>StarCraft II is widely known for being a highly competitive eSport and so it comes as no surprise that the game is balanced from the top down. Unfortunately, this approach focuses primarily on a tiny subset of the player base, and what may be balanced for the highest levels of play may be broken at lower skill levels. This sort of tunnel vision in the balance design of the game is partially due to the amount of time required to maintain a level playing field for the players that arguably need it most.</p>
			 
			<p>By design, this project aims to help solve this problem by providing developers the ability to examine very specific data sets. The data collected is structured in such a way that it can easily be searched and filtered to show information fitting both broad and narrow criteria. The major categories are time, patches, regions, leagues, races, game modes, maps, matches, players, and units. These can be combined in various ways to return specific sets of data.</p>
			 
			<p>Here’s an example: players are complaining that since the latest balance patch, Hellbats are being abused to harass and kill workers in the early game and are providing Terran players an unfair advantage. Here\'s how you might approach this problem using the Melee Data Collection Library:</p>
			
			<ul>
				<li>Search all the matches since the patch to see the percentage of Terran units that are Hellbats which were produced during the first 10 minutes of gameplay.</li>
				<li>If Hellbat usage has risen compared to the previous patch’s average, check the average number of kills made per Hellbat, and check how many of those kills were workers.</li>
				<li>To be certain that the unit is potentially being abused, check to see the percentage of Terran matches in which Hellbats are made within the first 7 minutes of the game (so as to discern whether this is now a common rush tactic), whether or not one of the first ten kills made by a player is with a Hellbat (and if the unit killed was a worker), and run a few searches for units it may be used in conjunction with (such as Medivacs).</li>
				<li>Lastly, if you suspect this is an issue that affects lower skill levels worse than it does those in the top tier, run searches on and compare the same data as before by individual leagues, and determine if the tactic appears to be less successful at the Grandmaster level than it is at the Bronze to Gold level.</li>
			</ul>

			<p>Armed with this knowledge, you can now proceed to either give the issue some further observation or begin to formulate a solution to the problem. The best part about this approach is that within a matter of minutes you can validate claims made by players, see exactly how widespread an issue truly is, and how effective it actually is at multiple skill levels. Compared to current methods, using this library is far more accurate, less time consuming, and involves less guesswork. And again, current approaches place more emphasis on balancing the highest levels of play, meaning that any changes will likely be made primarily for the benefit of players in the top tiers.</p>

			<h3>Measuring the Effects of Balance Changes</h3>
			
			<p>So you’ve made a change to affect the game balance, but how do you know if this solved the problem? What about side effects? You can test your theories about how this change will solve the problem and make a decision based on your experiences, wait for others to provide you with their feedback, come up with and test any exploits you can think of, or just wait to see how the game evolves in the hands of the players in response to the change. Sometimes a nerf or a buff can have direct effects in regards to the original problem. Other times they may just have a placebo effect, serving only to discourage more users from exploiting the original imbalance. The problem here is that for the most part the way changes are implemented now, their results can only be measured at face value or through theory and basic math. These are perceived results rather than measured results, which unfortunately say little about how successful a change was in solving the problem. In addition, perceived results give next to no insight on the side effects the change had on the rest of the game. </p>
			
			<p>Fortunately, this Melee Data Collection Library shines at displaying the way player behavior and balance statistics change over time. With all the data collected, it’s fairly simple to build numerous graphs to compare the changes in related statistics as players adjust their strategies and new meta-game trends begin to form and take root. Taking the Hellbat example from before, you could create a line graph showing a moving average of the number of workers killed by Hellbats within the first 10 minutes of the game per match and observe how this line fluctuates over time. If our sample data set includes all matches since the start of the previous patch until the present after publishing a balance patch to address the issue, we would see that over the lifetime of the previous patch the numbers would steadily rise as players learned how effective the strategy was. Hopefully if the balance patch was effective, that number will have dropped back down and remained relatively level since publishing the change. If the number didn’t go down, or rose again after an initial lull, then we know that the change was ineffective and players have discovered a new variation of the strategy that exploits the power of Hellbats again. Comparing two or more statistics in the same graph would also be possible, allowing us to see how much of an influence a particular stat on a unit affects that unit’s gameplay.</p>
			
			<p>There are thousands of possible graphs that can be made from the data being collected. Combine that with the ability to make very broad or narrow selections of the data and you have very easy to understand visualizations of the effects patches have on the game, as well as the ability to spot potential problems as they evolve out of the meta-game.</p>
			
			<p>Of course given the nature of big data, it will be nearly impossible to find all of the best uses of that data, and as such developing new tools will be an ongoing task. However, it should be noted that this is a perfect example for why making this data available to the public both through an in-house developed web application and through an API is also beneficial for the development team. There are a number of academics and professionals in eSports that would be just as interested in finding useful information from this data as Blizzard itself. Crowdsourcing like this should be considered when evaluating the tradeoffs of developing this project further.</p>
			
			<h2>How it all Works</h2>
			<hr>
			
			<p>So reasons for developing this project aside, you may be wondering “how does the Melee Data Collection Library work?” There are two main parts:</p>
			
			<ul>
				<li>A Trigger Library contained within a Custom Mod that records gameplay data to SC2 Bank files, which in this implementation are stored on each player’s computer.</li>
				<li>A Website powered by PHP + MySQL which handles data parsing, data storage, processes the data and displays the data in an easy to understand format.</li>
			</ul>
			
			<center>
			<div class="articleImage">
				<div class="articleImageSmall">
					<a title="SC2MDCL Database Design" href="img/Process-Overview.jpg">
						<img src="img/Process-Overview_Small.jpg"/>
					</a>
				</div>
				<div class="artileImageDesc">
					Overview of the process by which the Melee Data Collection Library works in it\'s current form.
				</div>
			</div>
			</center>
			
			<h3>The Trigger Library</h3>
			
			<p>To collect the data, a Trigger Library is used because it provides a simple way to use the functionality already present in the game engine and doesn’t require an extensive amount of new code. Triggers already provide a way to listen for all the gameplay events necessary, such as whenever a unit is created or dies, when construction or research progress changes, when abilities get used or, when units become idle, and timed intervals. Banks serve as a decent way to get data out of the game, since they are just XML data with a specific extension.</p>
			
			<p>Currently the Library is contained within a custom mod which can be added as a dependency to any melee map, in which a single new line added to the Melee Initialization trigger enables the functionality of the library. From there, at the start of each game the library will then check game privacy settings (found in the Custom Games lobby) which can be used to disable data collection by the player.</p>
			
			<p>Once enabled, new bank files are created for each player in the match. Bank files are named with a unique 32 character hex string to ensure that no two matches share a bank file. After that, some initial statistics about the map and each player are recorded. All data recorded is saved to each player’s local bank file so that each player has a copy.</p>
			 
			<p>As events occur in the game, such as when a unit dies, data about that event is recorded, such as the time and ID of the event, the location of both the unit that died and the unit that killed it, what the unique ID’s of each unit were, and the distance between the units. This data gets recorded in a unique key as one long string value under a categorized section, wherein the string is essentially a comma-separated array of the values recorded. Data is written to the local bank files in intervals of 30 seconds of game time, as well as whenever a player leaves the game.</p>
			
			<p>This prototype version of the Library provides most of the essential functionality needed to collect useful data from a match. However, there are a few important data points that currently cannot be collected without new functionality being added to triggers, such as the ability to query the server for the current time and date, getting the current patch version number of the game, the version number and arcade info of the map (such as the map’s arcade link) to name a few. In the current implementation, much of this data is inferred based on the creation date of the Bank file (which can all too easily be changed).</p>
			
			<p>Another major drawback of the current implementation stems from the fact that the data is stored locally rather than on a centralized server. This means that in order be added to the database, a player must manually upload their files to the server. Additionally, given that Banks are plain-text XML data files this makes them very exploitable by hackers who can use the raw data as its being recorded in order to cheat. Both of these issues would be solved through the use of server-side banks.</p>
			
			<p>Lastly and most importantly, without official support from Blizzard only matches played on maps where the Library mod is included will have data recorded. It is essential that Blizzard adopt this project so that data can be gathered from every game played through the matchmaking system, which is where the vast majority of useful data can be gathered. Without official support, this project can only at best be used by eSports organizations to collect data from their tournament matches.</p>

			<h3>The Website</h3>
			
			<p>With a solid method for collecting gameplay data in place, there needs to be a way to turn the data into something both players and developers can use and understand. A website was chosen to carry out this task due to its rapid development and flexibility. In addition, all of the technologies used are freely available, well documented, and compatible with multiple browsers across multiple devices and operating systems. Overall, the greatest strength of this setup is that all of the gathered data gets placed into a structure specifically designed to handle answering complex questions, allowing you to use numerous combinations of filters without needing to write dedicated code.</p>
			
			<p>So first off, the raw data needs to be parsed into a usable format. Given that the Bank files are simply XML data, the website uses PHP and its <a target="_blank" href="http://php.net/manual/en/book.simplexml.php">SimpleXML</a> functions to read the contents of the file, convert the strings to arrays, which then get procedurally inserted into a MySQL database using the <a target="_blank" href="http://www.php.net/manual/en/book.pdo.php">PDO extension</a>’s class methods. A number of custom functions were created to automate the construction of prepared SQL statements with which to interact with the database, making it simple to perform complex selections using just a few lines of code. These functions are used throughout the site to prepare most of the data presented to the user.</p>
			
			<center>
			<div class="articleImage">
				<div class="articleImageSmall">
					<a title="SC2MDCL Database Design" href="img/MDCL_DB_Design.jpg">
						<img src="img/MDCL_DB_Design_Small.jpg"/>
					</a>
				</div>
				<div class="artileImageDesc">
					A design draft used while creating the Database Structure. Most of the raw statistics gathered by the Library and added to the MySQL database (along with how they are related to one another) are shown here.
				</div>
			</div>
			</center>
			
			<p>For charts and graphs, the <a target="_blank" href="https://developers.google.com/chart/">Google Chart Tools API</a> is used because it offers a free and customizable method to create interactive visualizations that are compatible across a number of browsers and devices. Most of the chart data is generated on the fly via PHP and is loaded using AJAX requests to ensure speedy load times as well as cutting back on processing time and bandwidth usage. This same API is used in many other websites, notably <a target="_blank" href="http://wow.realmpop.com/">Realm Pop</a>) and <a target="_blank" href="https://theunderminejournal.com/">The Undermine Journal</a> which display detailed data about World of Warcraft demographics and auction house statistics respectively.</p>
			
			<p>Similarly, an open source library, <a target="_blank" href="http://www.patrick-wied.at/static/heatmapjs/index.html">Heatmap.js</a>, is used to create heat maps from death data recorded in the game. This library utilizes the power of the HTML5 canvas element to draw heat maps dynamically and is seeing similar use by Rockstar Games to display multiplayer combat data from <a target="_blank" href="http://www.rockstargames.com/newswire/article/46291/new-at-social-club-multiplayer-match-reports.html">Max Payne 3</a>. Unfortunately, due to the massive number of data points that StarCraft matches produce, transferring and processing all this data on the client side causes a bottleneck, which will most likely require using a server side script (<a target="_blank" href="http://blog.gmapify.fr/create-beautiful-tiled-heat-maps-with-php-and-gd">such as this one</a>) to generate heat map images instead, sacrificing much of the interactive features this library provides.</p>
			
			<p>jQuery, and a few plugins developed for it, are also utilized to provide much of the interactive and dynamic features in the site such as the AJAX methods mentioned earlier. <a target="_blank" href="http://onehackoranother.com/projects/jquery/tipsy/">Tipsy</a> is used to provide all of the tooltips and <a target="_blank" href="http://www.jacklmoore.com/colorbox">Colorbox</a> handles lightbox functionality.</p>
			
			<p>Currently, <a target="_blank" href="http://www.uploadify.com/">Uploadify</a> is used to handle file uploads. However, this feature is slated to be removed in favor of a more automated method of collecting data from matches that requires no effort on the part of the user.</p>	

';

echo '
			<p>Some additional scripts were borrowed directly from Blizzard’s own StarCraft 2 community website. Most of the images used are pulled from the game’s texture files using the game’s map editor program. Image resizing is handled by a PHP class written and made available by <a target="_blank" href="http://www.white-hat-web-design.co.uk/blog/resizing-images-with-php/">White Hat Web Design</a>, which has been modified to provide additional functionality.</p> 

			<h2>What still needs to be done</h2>
			<hr>
			
			<p>Everything that’s been done here so far is just a proof-of-concept; the Melee Data Collection Library is not yet far enough along to be used as outlined here by players or by developers. Fortunately the functionality described herein is all within the realm of possibility and it’s only a matter of time until it can be used. As mentioned before, sites like Realm Pop, The Undermine Journal, and even Blizzard’s own past endeavors (such as the WoW Armory and the Diablo 3 Character Profiles) are perfect examples of working with such large amounts of data. Below are some examples of what still needs to be done, ordered by what’s necessary to become usable internally to what should be considered before launching for public use:</p>
			
			<ul>
				<li>Additional functionality needs to be added to Triggers in order to collect more information for categorization, such as Region ID, Match Date/Time, Patch Version, and Map Version. Some other data points are currently bugged, such as retrieving Game Mode, Team Size, Team Number, and returning the  Count and Positions of all (not just active) Start Locations. Ability and Idle Unit tracking are currently disabled due to lag and Bank size limitations, though both technically work.</li>
				<li>Without official support from Blizzard, data cannot be gathered from games created through the Match Making system, limiting the amount of data that can be collected.</li>
				<li>Server-side Banks are needed to prevent cheating and falsification of data (a result of using local banks) and to automate the collection of data so that users are not required to voluntarily submit match data.</li>
				<li>Optionally, in order to provide real-time match data for broadcast purposes support needs to be added to allow saving Bank files locally to Observer/Referee player’s computers. Applications developed by third parties can be made to display graph data for use by Casters for their reference as well as to be displayed live on-screen during streams.</li>
				<li>To gather match data from Replays, support needs to be added so that the Library can run as a replay is being watched. This can potentially allow for the collection of data from matches played prior to the creation of this project.</li>
				<li>Currently, match result information is not included in the data collection process, but can be added using existing sources with proper support. Player win/loss and League information can be mined using existing third-party developed APIs, however, official support would be far better.</li>
				<li>Further development is needed on the back end to perform the necessary SQL queries to get complex data sets out of the database. This benefits Search functionality on the front end, which has yet to be developed.</li>
				<li>Graphs require additional development and optimization to support dynamic graph creation and interaction, as well as to eliminate bottlenecks caused by the large data sets being processed client side.</li> 
				<li>An API should be developed to make the data collected available to other programs, services, and community developed websites. This is important not only because it adds value to the product for users, but it also allows for the crowdsourcing of research into player behavior, game balance which helps development, and for third parties to create tools for eSports organizations.</li>
				<li>Server infrastructure is needed not only to store the data collected but also to support public access, which requires greater processing power and bandwidth than needed by the development team.</li>
			</ul>

			<p>Though this to-do list is only a rough overview, it brings a number of costs to attention, the biggest of which is the development time needed. This prototype took me roughly three months of full-time work, researching and learning many of the technologies utilized along the way. I consider myself to be an intermediate level web developer, having spent about twelve years practicing web development as a hobby and professionally during my college education. I’m confident that with an experienced team this project can be ready for internal use by year’s end and for a public release by the time Legacy of the Void goes into beta.</p>
			
			<p>With that said, it should also be taken into consideration that this project can also be adapted for use with Blizzard All-Stars, which could benefit tremendously in terms of balance design, further speeding its development and potential for success.</p>
			
			<p>As for storage considerations, let’s compose a rough estimate based on the current numbers displayed in the game client. Supposing that an average of 10,000 matches are being played at any given time, and that any given match lasts for an average of 30 minutes, we can estimate that there will be 20,000 matches worth of data generated per hour of the day, world-wide. The data collected from each match is between 300kb (for short 1v1 matches) to 2000kb (for long matches or typical 4v4 matches). This means every hour between 6 GB and 40 GB of data is generated per hour, or between 144 GB to 960 GB of data per day, 1.08 TB to 6.72 TB of data per week, etc. Now, this may at first glance appear to be a lot of data to store, but for comparison consider that in League of Legends ”Gamer activity generates more than 500 GB of structured data and over four TB of operational logs every day” according to Barry Livingston of Riot Games in an <a target="_blank" href="http://slashdot.org/topic/bi/for-riot-games-big-data-is-serious-business/">article</a> written for Slashdot. Riot uses this information to analyze their business model as well as to assist in League of Legend’s development. Further information about the amount of data being collected by the Melee Data Collection library can be found on the home page under Database Statistics, which lists the number of rows for the majority of the tables in the database.</p>
			
			<h2>Project Conception and Final thoughts</h2>
			<hr>
			
			<p>Though this project has been developed primarily over the course of the last three months, its history begins much earlier than that. I was inspired by a presentation given by Epic Game’s Jim Brown given at GDC 2012 called <a target="_blank" href="http://www.g4tv.com/thefeed/blog/post/725057/the-legacy-of-fail-gears-of-war-3-level-design-with-epics-jim-brown/">‘The Legacy of Fail’</a>. Jim’s team was facing similar game balance issues during the development of Gears of War 3 in the design of their multiplayer maps. Using heat maps of death locations, they were able to uncover some very subtle issues with their game’s camera and control scheme that was causing perfectly symmetrical maps to have very asymmetrical win/loss results. As it turned out, given that this third-person shooter had a camera view over the right shoulder of the player character, this gave a specific advantage to players on one side of the map, due to cover on their side of the map providing better cover than for players on the opposite side of the map. Though this situation was fairly specific to that particular type of game, the idea of using heat maps to discover imbalances made me think about how similar issues could come as a result of StarCraft 2’s fixed overhead camera.</p>
			
			<p>At the time I had just applied for that summer’s Level Design internship and my interests were primarily learning to craft stories through campaign experiences. However, as the start of the internship drew closer my interest in StarCraft as an eSport was starting to grow, having participated in melee map creation contests before (which forced me to learn the basics of melee map design) and having just started to watch NASL the previous year. Upon hearing that NASL would be holding live matches at the UC Irvine Anthill Pub (and that some Blizzard employees might be there to network with), my interests would start to shift towards wanting to find new ways to improve this very exciting new community I was becoming a part of. This led me to take the next step and go to MLG Anaheim, which was a blast and continued to have an influence on me throughout the summer.</p>
			
			<p>All of these experiences would stick with me and over the next few months after the end of the internship, I focused on trying to make sense of everything I had been exposed to and paying very close attention to the pro scene, watching tournaments, and observing the public response to beta once it went live. The numerous bouts of public outcry over imbalances at the time revived discussion on how to improve the process of balancing the game. By the end of November the idea of using Bank files to collect data for heat mapping hit me, and so work on what would become the Melee Data Collection Library began. Once it was discovered that yes, in fact you could collect data using this method and that it could be made into something useful thanks to technologies I was already quite familiar with, I knew that I had come across something much bigger than just creating some simple visualizations. This was something that if done properly, has the potential to change eSports as we know it forever. So began weeks of research and design, which turned into two months of web development, bringing us to the present.</p>
			
			<p>Over the course of developing this prototype, I’ve come to the decision that this is something I would really enjoy working with Blizzard to develop. I would like to help the team that’s been so influential for me, not only in the past few months but for most of the past decade, continue to make the best games at an even higher quality at an even faster rate. I also want to make sure this product sees the light of day so the community that gave me so much direction in the development of my career can enjoy the benefits it can provide for them and hopefully help it continue to thrive as a result.</p>
			
			<p>I hope that after reading all of this (congrats for making it this far, by the way!) you’ve seen the potential this project holds and for the value that it has for not only for Blizzard as a company, but also for the community and global phenomena that it has created. Thanks!</p>

			<p>Special thanks goes to Caitlin Howell, Cameron Gilbert, Daniel Robbins, and Zak Rubin for all their help in the development of this prototype!</p>
			
			<h2>Additional Reading, References and Examples:</h2>
			<hr>
			
			<p>If you’re still hungry for more, here are a few of the articles I’ve read over the course of developing this project. These range from examples of other companies using similar data to improve their products, discussions on the application of similar concepts in design, and some examples of the interest present in the community for a product like this.</p>
			
			<ul>
				<li><a target="_blank" href="http://www.altdevblogaday.com/2011/06/01/balance-and-flow-maps-2/">Balance and Flow Maps in Transformers: War for Cybertron</a></li>
				<li><a target="_blank" href="http://gamebalanceconcepts.wordpress.com/2010/08/25/level-8-metrics-and-statistics/">Using Metrics and Statistics in Game Design</a></li>
				<li><a target="_blank" href="http://gamecareerguide.com/features/1168/how_the_collegiate_starleague_is_.php?page=1">The Collegiate Star League, the Business of eSports, and Interest in Gameplay Statistics</a></li>
				<li><a target="_blank" href="http://steampowered.com/status/ep2/ep2_stats.php">Metrics gathered about Half-Life 2 Episode Two’s single player campaign</a></li>
				<li><a target="_blank" href="http://www.sloansportsconference.com/?page_id=460">Upcoming MIT Sloan Sports Analytics Conference featuring a presentation on eSports Metrics</a></li>
				<li><a target="_blank" href="http://jimblackhurst.com/wp/2011/05/17/heatmaps-point-clouds-and-big-data-in-processing/">Using Processing to heat map player deaths in Just Cause</a></li>
			</ul>
';
	
echo '
		</div>
	</div>
</div>';

//////////// End of Page////////////

// Include the page footer and perform any nescessary cleanup.
require_once 'footer.php';
?>