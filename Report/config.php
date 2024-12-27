<?php
  $servidor = "www.sixtemakgis.com";
  //$servidor = "localhost";
  $usuario = "sixtemak_desarrollo";
  $pass = "topacio310571";
  $db = "sixtemak_vivemas";

$conexion;

  $conexion=mysqli_connect($servidor,$usuario,$pass,$db);
  //mysqli_set_charset($conexion, "utf8mb3");
  mysqli_set_charset($conexion, "utf8");

