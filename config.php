<? // Login Script

$dbConfig = array (
"host" 			=> "127.0.0.1", // Update with your machine's host address if necessary.
"db" 			=> "mdcl",
"username" 		=> "DBUSERNAME", // Replace with your MySQL Database Username
"password" 		=> "DBPASSWORD", // Replace with your MySQL Database Password
);

// Connect to Database.
try {
    $db = new PDO("mysql:host=".$dbConfig["host"].";dbname=".$dbConfig["db"], $dbConfig["username"], $dbConfig["password"]);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $exception) {
    echo 'ERROR: ' . $exception->getMessage();
}

?>