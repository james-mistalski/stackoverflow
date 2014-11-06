<?php

// simple case: getting a correctly formatted date
$goodDate = DateTime::createFromFormat("Y-m-d H:i:s", "07-13 15:18:42");

// tougher case: getting from predictable user input
$toughDate = DateTime::createFromFormat("n/j/y", "7/3/92");
echo $toughDate-format("Y-m-d H:i:s");

// DESIGN PROBLEM IN PHP ...SERIOUSLY!! WTF!?
// Java would throw a DateFormate Exception here; PHP carries the excess over
$thisIsValid = DateTime::createFromFormat("Y-m_d H:is", "2014-39-47 57:94:82");




//  toughest case: getting date from unpredictable user input
// panic();



?>