#!/usr/bin/php
<?php

include("ft_split.php");

$save = "";

foreach($argv as $str)
 if ($str != "ssap.php")
$save = $save." ".$str;

if ($save != "")
{
$tab = ft_split($save);
sort($tab);
foreach($tab as $tmp)
echo $tmp."\n";
}

?>