#!/usr/bin/php
<?php

include("ft_split.php");

$save = "";

foreach($argv as $str)
if ($str != $argv[0])
$save = $save." ".$str;

if ($save != "")
{
$tab = ft_split($save);

$num = array();
foreach($tab as $str)
{
if (is_numeric($str))
array_push($num, $str);
}
sort($num);

$string = array();
foreach($tab as $str)
{
if (ctype_alpha($str))
array_push($string, $str);
}
natcasesort($string);

$other = array();
foreach($tab as $str)
{
if (!is_numeric($str) && !ctype_alpha($str))
array_push($other, $str);
}
sort($other);

foreach($string as $str)
echo $str."\n";

foreach($num as $str)
echo $str."\n";

foreach($other as $str)
echo $str."\n";
}

?>