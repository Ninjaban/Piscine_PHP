<?php

$key = array_keys($_GET);
$n = 0;
foreach($_GET as $str)
echo $key[$n++].": $str\n";

?>