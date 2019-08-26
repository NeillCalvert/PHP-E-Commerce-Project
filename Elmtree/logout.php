<?php
  session_start();
  if(!isset($_SESSION['40150199_user']) || (empty($_SESSION['40150199_user']))){
    header('location: index.php');
  } else{
    $_SESSION = array();
    session_destroy();
    header('location: index.php');
  }


 ?>
