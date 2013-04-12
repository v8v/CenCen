<?php
  @session_start();
  require_once('classes/websmarty.class.php');
  $smarty = new WebSmarty('web');
  $smarty -> caching = true;
  
?>
