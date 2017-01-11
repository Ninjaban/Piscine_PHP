#!/usr/bin/php
<?php

if ($argc != 2)
return ;

$new = file_get_contents($argv[1]);

$new = preg_replace_callback('/<a href.*title="(.+?)".*>/',
function ($matches2) {
$tab = explode("\"".$matches2[1]."\"", $matches2[0]);
$matches2[1] = strtoupper($matches2[1]);
return $tab[0]."\"".$matches2[1]."\"".$tab[1];
},
$new
);

$new = preg_replace_callback('/<a href.*>(.+?)</',
function ($matches2) {
$tab = explode($matches2[1], $matches2[0]);
$matches2[1] = strtoupper($matches2[1]);
return $tab[0].$matches2[1].$tab[1];
},
$new
);

echo $new;
?>