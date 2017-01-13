<?php

function ft_is_sort($tab)
{
$cpy = $tab;
sort($cpy);

$n = 0;
foreach ($cpy as $str) {
if ($str != $tab[$n])
return (0);
$n = $n + 1;
}
return (1);
}

?>