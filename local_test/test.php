<?php
date_default_timezone_set('UTC');



echo "hello";

for ($x=1; $x<=60; $x=($x+1)%60) {
	$sec = date('s');
	echo "X is equal to $x. ";
	echo "<br>";
	echo "S is equal to $sec. "; 
	echo "<br>";
	sleep(1);

}

