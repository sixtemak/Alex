<?php
session_start();

if (!isset($_SESSION['k_username'])) {
    session_destroy();
    echo "<script> location.href='../index.html';</script>";

} else {
    //echo 'Bienvenido';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--- css leaflet-->

    <link rel="stylesheet" href="leaflet\leaflet\leaflet.css" />
    <link rel="stylesheet" type="text/css" href="leaflet/css/L.Control.ZoomBar.css"/>		
	
    <!-- leaflet version 1.8.0 para q funcione la busqueda-->

    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" /> -->

    <link rel="stylesheet" href="leaflet\leaflet-search-master\dist\leaflet-search.src.css" />
    <!-- para busqueda de lotes -->
    <!--------->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />

    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/mapa.css">
    <!--  -->

    <title>SixtemakGis</title>
    <link rel="Shortcut Icon" type="image/x-icon" href="img/sixtemak.ico" />
</head>

<body class="bg-secondary">
    <!-- Inicio del menu -->

    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- icono o nombre -->
            <a href="">
                <img src="img/sixtemak.png" class="imh-fuid" widht="35px" height="35px" alt="">
            </a>



            <!-- <a class="navbar-brand" href="#">
          <i class="bi bi-flower1"></i>
          <span class="text-warning">SixtemakGis</span>
        </a> -->

            <!-- boton del menu -->

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- elementos del menu colapsable -->

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">SixtemakGis</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#">Proyectos</a>
                    </li>
                    <li class="nav-item">
                        <select class="form-select" id="select-proyectos" style="width :auto;" onchange="buscarLotes()">
                        

                            <?php
                            include "Report/config.php";

                            $xquery = "SELECT concat(latitud,',',longitud) as idurba, proyecto, ubicacion FROM proyectos WHERE activo=1";
                            $resultado = mysqli_query($conexion, $xquery) or mysqli_error($conexion);
                            $row_cnt = mysqli_num_rows($resultado);

                            if ($row_cnt >= 1) {
                                $ubi = "-";
                                while ($row = mysqli_fetch_array($resultado)) {
                                    $ubicacion = $row['ubicacion'];
                                    if ($ubi != $ubicacion) {
                                        $ubi = $ubicacion;
                                        ?>
                                        <optgroup label="<?php echo $ubi;?>"></optgroup>
                                    <?php
                                    }

                                    $idurba = $row['idurba'];
                                    $proyecto = $row['proyecto'];
                                    ?>
                                    <option value="<?php echo $idurba; ?>"><?php echo $proyecto; ?></option>
                                    <?php
                                }
                            }
                            ?>

                            <!--  <optgroup label="Tumbes">
                                <option value="-4.078004,-81.022532">Punta Canoas</option>
                            </optgroup>
                            <optgroup label="Piura">
                                <option value="-5.158728,-80.777360">La Gran Piura</option>
                                <option value="-4.886362,-80.653103">Villa del Chira</option>
                                <option value="-4.889305,-80.659520">Vive Agro</option>
                            </optgroup>
                            <optgroup label="Arequipa">
                                <option value="-17.193727,-71.768263">Country Club II</option>
                            </optgroup> -->
                        </select>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#">Busqueda</a>
                    </li>
                    <li class="nav-item">
                        <form class="d-flex" onsubmit="return false;">
                            <input id="txtml" class="form-control me-2" type="search" placeholder="Mz-Lt" aria-label="Search" name="txtml" style="width:85px; text-transform:uppercase;">
                            <button class="btn btn-outline-warning" type="submit" onclick="buscarlote();">Buscar</button>
                        </form>
                    </li>
                    
                    <!-- <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="navbarDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        Servicios
                    </a>

                    <ul
                        class="dropdown-menu bg-secondary"
                        aria-labelledby="navbarDropdown"
                    >
                        <li><a class="dropdown-item" href="#">Renta</a></li>
                        <li><a class="dropdown-item" href="#">Equipos</a></li>
                        <li></li>
                        <li><a class="dropdown-item" href="#">Networking</a></li>
                    </ul>
                    </li> -->
                </ul>

                <!-- <hr class="d-md-none text-white-50" /> -->

                <!-- enlaces redes sociales -->

                <!-- <ul class="navbar-nav flex-row flex-wrap text-light">
                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-twitter"></i>
                        <small class="d-md-none ms-2">Twitter</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-github"></i>
                        <small class="d-md-none ms-2">GitHub</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-whatsapp"></i>
                        <small class="d-md-none ms-2">WhatsApp</small>
                    </li>

                    <li class="nav-item col-6 col-md-auto p-3">
                        <i class="bi bi-facebook"></i>
                        <small class="d-md-none ms-2">Facebook</small>
                    </li>
                </ul> -->

                <!--boton Informacion -->

                <form class="d-flex">
                    <button class="btn btn-outline-warning d-none d-md-inline-block" type="button"
                        onclick="verplanos();">
                        Ver Planos
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="informacion" id="verinfo">
        <h5 style="text-align:center; background:steelblue; color:black;">Planos Vivemas</h5>
        <form method="POST" action="report/actaEntrega2.php">
            <table>
                <tr>
                    <td><b>Tumbes</b></td>
                    <td id="tabprop" name="tabprop" colspan="3"></td>
                </tr>
                <tr>
                    <td><a href="https://drive.google.com/file/d/1gb0zrmmedOo5j9S2Q9NLAca4cKMW-zWq/view?usp=drive_link"
                            target="_blank">Plano General Punta Canoas</a></td>
                </tr>
                <tr>
                    <td><a href="https://drive.google.com/file/d/1Efo6yLXdLWu-lQ_-lTNOz7gwn60VtXg-/view?usp=drive_link"
                            target="_blank">1era Etapa Punta Canoas</a></td>
                </tr>
                <tr>
                    <td><a href="https://drive.google.com/file/d/133h6xF5UObrMu_VilVmE5rmjPbdZi-rE/view?usp=drive_link"
                            target="_blank">2da Etapa Punta Canoas</a></td>
                </tr>
                <tr>
                    <td><a href="https://drive.google.com/file/d/124-rIj-s8VUtJhbCHYQEAtiao7xuoxyD/view?usp=drive_link"
                            target="_blank">3era Etapa Punta Canoas</a></td>
                </tr>
                <tr>
                    <td><a href="https://drive.google.com/file/d/1E_X93Tw1nSHz58C2bNclhdTwmYJvLvj4/view?usp=drive_link"
                            target="_blank">4ta Etapa Punta Canoas</a></td>
                </tr>
                <tr>
                    <td><a href="https://drive.google.com/file/d/117pp0KxSsR_Bb_xUwuRqsY-w3c3oLjBf/view?usp=drive_link"
                            target="_blank">5ta Etapa Punta Canoas</a></td>
                </tr>
                <!-- <br> -->
                <tr>
                    <td><b>Piura</b></td>
                    <td id="tabprop" name="tabprop" colspan="3"></td>
                </tr>
                <tr>
                    <td><a href="https://drive.google.com/file/d/1BqstgQIFntWIaU8wmU2dtItoyGJLn4iV/view?usp=drive_link"
                            target="_blank">1era Etapa Praga</a></td>
                </tr>
                <tr>
                    <td><a href="https://drive.google.com/file/d/1QQaMrZHBV3U99d2H5Rg-QFwrz2mwZFHG/view?usp=drive_link"
                            target="_blank">2da Etapa Praga</a></td>
                </tr>
                <tr>
                    <td><a href="https://drive.google.com/file/d/1CH59qEaieDOgk3hVAThlSS6sUzrh1dCb/view?usp=drive_link"
                            target="_blank">3era Etapa Praga</a></td>
                </tr>
                <!-- <br> -->
                <tr>
                    <td><b>Arequipa</b></td>
                    <td id="tabprop" name="tabprop" colspan="3"></td>
                </tr>
                <tr>
                    <td><a href="#">Planos en proceso</a></td>
                </tr>
            </table>
            <br>

            <button type="button" class="btn btn-secondary" onclick="verplanos();">Cerrar</button>
        </form>
    </div>

    <div id="map" class="mapa"></div>

    <!-- Java Script Leaflet -->

    <script src="leaflet\leaflet\leaflet.js"></script> <!-- leaflet version 1.8.0 para que funcione la busqueda-->

    <script type="text/javascript" src="leaflet/js/L.Control.ZoomBar.js"></script>

    <!-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script> -->

    <script src="leaflet\leaflet-search-master\dist\leaflet-search.src.js"></script>

    <!-- Archivos GeoJson -->

    <script src="jSon/PuntaCanoas/GeoLotes_Canoas.js"></script>
    <script src="jSon/PuntaCanoas/GeoRecreacion_Canoas.js"></script>
    <script src="jSon/PuntaCanoas/GeoPasaje_Canoas.js"></script>
    <script src="jSon/PuntaCanoas/GeoVereda_Canoas.js"></script>
    <script src="jSon/PuntaCanoas/GeoAreaVerde_Canoas.js"></script>
    <script src="jSon/PuntaCanoas/GeoPortico_Canoas.js"></script>
    <!-- <script src="jSon/PuntaCanoas/GeoPalmeras_Canoas.js"></script> -->
    
    <script src="jSon/PuntaCanoas/GeoPartidas_Canoas.js"></script>
    <script src="jSon/PuntaCanoas/GeoManzanas_Canoas.js"></script>

    <script src="jSon/La Gran Piura/GeoLotes_Praga.js"></script>
    <script src="jSon/La Gran Piura/GeoPartidas_La_Gran_Piura.js"></script>

    <script src="jSon/CC_II/geomcc_II.js"></script>
    <script src="jSon/CC_II/geoestacionamiento_CCII.js"></script>
    <script src="jSon/CC_II/geoareaverde.js"></script>
    <script src="jSon/CC_II/geovias_CCII.js"></script>
    <script src="jSon/CC_II/geoparques_CCII.js"></script>
    <script src="jSon/CC_II/geoMz_CCII.js"></script>
    
   

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <!-- <script src="js/mapa.js"></script> -->
</body>

<script>
  function logout(){
    <?php
      session_destroy();
     // echo "<script> location.href='../index.html';</script>";
    ?>
  }
  //location.href='../index.html';
</script>

<script src="js/mapa.js"></script>

</html>