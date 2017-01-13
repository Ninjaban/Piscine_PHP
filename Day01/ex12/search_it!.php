#!/usr/bin/php
<?php

if ($argc == 1)
return ;

$key = $argv[1];

foreach($argv as $str) {
	if ($str != $argv[0] && $str != $argv[1]) {
	   $tab = explode(":", $str);
	   if ($key == $tab[0]) {
   	   	  echo $tab[1]."\n";
		  return ;
		  }
	}
}

?>