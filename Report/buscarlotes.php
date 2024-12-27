<?php
include "config.php";

//$conexion=mysqli_connect("localhost","root","topacio","basegis");
//mysqli_set_charset($conexion, "utf8");

$xquery=$_POST['xquery'];
//var xempresa = "select id, empresa , abreviatura from empresa where activo=1";


$resultado = mysqli_query($conexion, $xquery) or die(mysqli_error($conexion));

$row_cnt = mysqli_num_rows($resultado);

$data["rows_cnt"]=$row_cnt;
if($row_cnt>=1){
    while ($f = mysqli_fetch_array($resultado))
    {
        $data["latitud"] =$f["latitud"];
        $data["longitud"]=$f["longitud"];
       /*  $data["etapa"]=$f["etapa"];
        $data["manzana"]=$f["manzana"];
        $data["lote"]=$f["lote"];
        $data["area"]=$f["area"];
        $data["perimetro"]=$f["perimetro"];
        $data["usos"]=$f["usos"];
        $data["partida"]=$f["partida"];
        $data["frente_col"]=$f["frente_col"];
        $data["frente_m"]=$f["frente_m"];
        $data["derecha_col"]=$f["derecha_col"];
        $data["derecha_m"]=$f["derecha_m"];
        $data["izquierda_col"]=$f["izquierda_col"];
        $data["izquierda_m"]=$f["izquierda_m"];
        $data["fondo_col"]=$f["fondo_col"];
        $data["fondo_m"]=$f["fondo_m"];
        $data["cuadrante"]=$f["cuadrante"];
        $data["propieta1"]=$f["propieta1"];
        $data["propieta2"]=$f["propieta2"];
        $data["depa"]=$f["depa"];
        $data["prov"]=$f["prov"];
        $data["dist"]=$f["dist"]; */
    }
    echo json_encode($data);

}else{
    echo '<script language="javascript">alert("No existe Informacion...!");</script>';

}