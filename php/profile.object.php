<?php
// in order to create the object, we need to first require the class file
require_once("profile.php");

// how to store a password! first, generate the salt & authentication tokens
$authToken 	= bin2hex(openssl_random_pseudo_bytes(16));
$salt			= bin2hex(openssl_random_pseudo_bytes(32));

// second, hash the cleartext password using PBKDF2
$clearTextPassword 	= "ChedGeek5";
$pbkdf2Hash				= hash_pbkdf2("sha512", $clearTextPassword, $salt, 2048, 128);

// now that PHP knows what to build, we use the new keyword to create an object
// the new keyword automatically runs the __construct method
$profile = new Profile(null, 24, "first name", "middle name", "last name", "1");

//var_dump to have a look at the resulting object
var_dump($profile);

?>