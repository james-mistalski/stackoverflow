<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 10/27/2014
 * Time: 3:56 PM
 */

// setup some tests
$goodUserId = 42;
$badUserId = "not a user id";

// DEBUG FUNCTION OF THE MILLENNIA: VAR_DUMP()
var_dump(filter_var($badUserId, FILTER_VALIDATE_INT));
var_dump(filter_var($goodUserId, FILTER_VALIDATE_INT));
?>