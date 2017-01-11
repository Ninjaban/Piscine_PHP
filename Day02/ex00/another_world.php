#!/usr/bin/php
<?php

function ft_epur($str)
{
$str = trim($str);
$str = ereg_replace('`\t{1,}`', ' ', $str);
$str = ereg_replace(' {2,}', ' ', $str);
return ($str);
}

if ($argc >= 2)
{
echo ft_epur($argv[1])."\n";
}

?>