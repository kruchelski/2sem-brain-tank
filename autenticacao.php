<?php
  session_start();
  if (isset($_SESSION["idUser"]) && isset($_SESSION["nameUser"])) {
    $login = true;
    $idUser = $_SESSION["idUser"];
    $nameUser = $_SESSION["nameUser"];
    $passUser = $_SESSION["passUser"];
  }
  else{
    $login = false;
  }

?>