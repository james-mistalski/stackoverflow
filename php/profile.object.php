<?php
// in order to create the object, we need to first require the class file
require_once("profile.php");

// now that PHP knows what to build, we use the new keyword to create an object
// the new keyword automatically runs the __construct method
$profile = new Profile(null, 1, "first name", "middle name", "last name", 1);

// pesky mysqli doesn't throw exceptions by default - this will override this and throw exceptions!
mysqli_report(MYSQLI_REPORT_STRICT) ;

// OK, now we can "try" connecting to mySQL - get it - it's a pun
try {
	// parameters: hostname, username, password, database
	$mysqli = new mysqli("localhost", "store_james", "deepdive", "store_james");
} catch(mysqli_sql_exception $sqlException) {
	echo "Unable to connect to mySQL: " . $sqlException->getMessage();
}

// if we got here, we did connect! so, we'll go ahead and insert this object
$profile->insert($mysqli);

// var_dump to have a look at the resulting object
var_dump($profile);

?>