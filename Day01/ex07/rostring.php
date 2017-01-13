#!/usr/bin/php
<?php

include("ft_split.php");

if ($argc > 1) {
$tab = ft_split($argv[1]);

foreach($tab as $str) {
if ($str != $tab[0])
echo $str." ";
}
echo $tab[0]."\n";
}

?>