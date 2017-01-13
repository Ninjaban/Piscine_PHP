#!/usr/bin/php
<?php

function ft_epur($str)
{
$str = trim($str);
$str = preg_replace('` {2,}`', ' ', $str);
return ($str);
}

if ($argc == 2)
{
echo ft_epur($argv[1])."\n";
}

?>