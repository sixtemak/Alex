<?php
session_start();// para loguear
include 'config.php';

$usuario=$_POST['txtusuario'];
$clave=$_POST['txtclave'];
$usu1 = 'admin';

$xquery="select * from usuarios where usuario='$usuario' and clave='$clave'";

$resultado = mysqli_query($conexion, $xquery) or die(mysqli_error($conexion));

$row_cnt = mysqli_num_rows($resultado);



if ($row_cnt>=1){
    
    $_SESSION['k_username'] = $usu1;
	//$_SESSION['key']='PHP1.$#@'; // marcador
	header('location: ../mapa.php');	
	
}else{
	session_destroy();
    echo "<script>alert('Usuario no registrado!');
	document.location.href='../index.html';</script>";
        	
}
