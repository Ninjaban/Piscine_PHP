#!/usr/bin/php
<?php

date_default_timezone_set('Europe/Paris');

$day = array("lundi"=>"Monday",
			"mardi"=>"Tuesday",
			"mercredi"=>"Wednesday",
			"jeudi"=>"Thursday",
			"vendredi"=>"Friday",
			"samedi"=>"Saturday",
			"dimanche"=>"Sunday");

$month = array("janvier"=>"1",
			"fevrier"=>"2",
			"mars"=>"3",
			"avril"=>"4",
			"mai"=>"5",
			"juin"=>"6",
			"juillet"=>"7",
			"aout"=>"8",
			"septembre"=>"9",
			"octobre"=>"10",
			"novembre"=>"11",
			"decembre"=>"12");

if ($argc == 1)
   return ;
$tab = explode(" ", $argv[1]);
if (count($tab) != 5)
{
echo "Wrong Format\n";
return ;
}

$tab[0] = lcfirst($tab[0]);
if (!$day[$tab[0]])
{
echo "Wrong Format\n";
return ;
}

$tab[2] = lcfirst($tab[2]);
if (!$month[$tab[2]])
{
echo "Wrong Format\n";
return ;
}

$time = explode(":", $tab[4]);
if (count($time) != 3)
{
echo "Wrong Format\n";
return ;
}

if (strlen($tab[1]) > 2)
{
echo "Wrong Format\n";
return ;
}

if (strlen($tab[3]) != 4)
{
echo "Wrong Format\n";
return ;
}

if (strlen($time[0]) != 2)
{
echo "Wrong Format\n";
return ;
}

if (strlen($time[1]) != 2)
{
echo "Wrong Format\n";
return ;
}

if (strlen($time[2]) != 2)
{
echo "Wrong Format\n";
return ;
}

$result = mktime($time[0], $time[1], $time[2], $month[$tab[2]], $tab[1], $tab[3]);

echo $result."\n";
?>