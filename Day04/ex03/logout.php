<?php
   session_start();
   while (count($_SESSION))
   array_pop($_SESSION);

?>
