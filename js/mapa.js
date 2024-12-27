var xzoom = 17;
var ML_OK;
// se define la variable map y se llama a la libreria leaflet "L", se llama al mapa 'map' con setView para q muestre las coordenadas y el zoom de 6
let map = L.map("map", { zoomControl: false }).setView(
  [-4.078004, -81.022532],
  xzoom
);

function estiloLayer(feature) {
  return {
    // fillColor:getColorPcm(feature.properties.PCM),
    color: "red",
    fill: false,
    
  };
}

//Control de visualización de capas

//se llama a la libreria leaflet "L" para q muestre un mapa base y se agregar a la variable map
L.tileLayer("http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}", {
  maxZoom: 21,
}).addTo(map);

var barraZoom = new L.Control.ZoomBar({ position: "topleft" }).addTo(map);

/* Basemap Layers */
otm = L.tileLayer("http://{s}.tile.opentopomap.org/{z}/{x}/{y}.png", {
  maxZoom: 21,
});
osm = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 21,
});
esriTopo = L.tileLayer(
  "https://services.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}",
  { maxZoom: 21 }
);
esriWorldImagery = L.tileLayer(
  "https://services.arcgisonline.com/arcgis/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
  { maxZoom: 21 }
);
esriStreet = L.tileLayer(
  "https://services.arcgisonline.com/arcgis/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}",
  { maxZoom: 21 }
);
google = L.tileLayer(
  "http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}",
  { maxZoom: 21 }
);

function VerPartida(feature, layer) {
  layer.bindTooltip(feature.properties.Partida, {
    permanent: true,
    direction: "center",
    className: "colorPartida",
  });
}

var xcanoasPartidas = L.geoJson(GeoPartidas_Canoas, {
  style: estiloLayer,
  onEachFeature: VerPartida,

});

var xpiuraPartidas = L.geoJson(GeoPartidas_La_Gran_Piura, {
  style: estiloLayer,
  onEachFeature: VerPartida,

});

var baseLayers = {
  "Street Map": osm,
  "Google Earth": google,
};

var overlays = {
  "Matrices Punta Canoas": xcanoasPartidas,
  "Matrices La Gran Piura": xpiuraPartidas,
  //"Matrices Punta de Bombon": xbombon,
};

L.control.layers(baseLayers, overlays).addTo(map);
////

//visualiza la escala
new L.control.scale({ imperial: false }).addTo(map);

//Ubicacion del Proyecto segun coordenadas del option group select
document
  .getElementById("select-proyectos")
  .addEventListener("change", function (e) {
    let coords = e.target.value.split(",");
    map.flyTo(coords, xzoom);
  });

//Agregar Popup

function highlightFeature(e) {
  var layer = e.target;
  layer.setStyle({
    weight: 5,
    color: "#666",
    dashArray: "",
    fillOpacity: 0.7,
  });
}

function resetHighlight(e) {
  CanoasLotes.resetStyle(e.target);
}

function zoomToFeature(e) {
  map.fitBounds(e.target.getBounds());
}

function popup(feature, layer) {
  layer.on({
    mouseover: highlightFeature,
    mouseout: resetHighlight,
    click: zoomToFeature,
  });

  if (feature.properties && feature.properties.uso) {
    //ML_OK = "MZ "+ feature.properties.manzana + " LT " + feature.properties.lote + ".pdf";
    layer.bindPopup(
      "<style> table, td{border:1px solid black;} td{padding:5px;}</style>" +
        "<table>" +
        "<tr style='background: #2271B3; color: white;'>" +
        "<th colspan='2'>Informacion Lote</td>" +
        "</tr>" +
        "<tr>" +
        "<td><b>Manzana:</b></td><td>" +
        feature.properties.manzana +
        "</td>" +
        "</tr>" +
        "<tr>" +
        "<td><b>Lote:</b></td><td>" +
        feature.properties.lote +
        "</td>" +
        "</tr>" +
        "<tr>" +
        "<td><b>Area:</b></td><td>" +
        feature.properties.area_m2.toFixed(2) +
        " m2" +
        "</td>" +
        "</tr>" +
        "<tr>" +
        "<td><b>Perimetro:<b></td><td>" +
        feature.properties.perimetro.toFixed(2) +
        " ml." +
        "</td>" +
        "</tr>" +
        "<tr>" +
        "<td><b>Uso:<b></td><td>" +
        feature.properties.uso +
        "</td>" +
        "</tr>" +
        "<td><b>Anexo:<b></td><td>" +
        "<a href=" +
        "pdf/" +
        feature.properties.manzana +
        "-" +
        feature.properties.lote +
        ".pdf " +
        "target='_blank'>Ver Anexo</a>" +
        "</td>" +
        "</tr>" +
        "</table>"
    ),
      layer.bindTooltip(feature.properties.lote, {
        direction: "center",
        className: "no-background",
      });
  }
}
//-------------

function getColor(d) {
  return d == "UNIFAMILIAR"
    ? "#dbc816"
    : d == "BERMA"
    ? "#616A6B"
    : d == "Berma"
    ? "#616A6B"
    : d == "RECREACION PUBLICA"
    ? "#0c6508"
    : d == "PARQUE RECREATIVO"
    ? "#0c6508"
    : d == "PARQUE"
    ? "#0c6508"
    : d == "CLUB HOUSE"
    ? "#78EDFC"
    : d == "STRIP MALL"
    ? "#FFFFFF"
    : d == "POZO AGUA"
    ? "#A3E4D7"
    : d == "CISTERNA AGUA"
    ? "#53BFAA"
    : d == "PLANTA OSMOSIS AGUA"
    ? "#5381BF"
    : d == "OTROS FINES"
    ? "#9e9898"
    : d == "AREA VERDE"
    ? "#0c6508"
    : d == "Area Verde"
    ? "#A3E4D7"
    : d == "VIVIENDA MULTIFAMILIAR"
    ? "#9c0961"
    : d == "COMERCIO METROPOLITANO"
    ? "#FEB24C"
    : d == "LOTE VENDIBLE"
    ? "#ed7f11"
    : d == "EDUCACION"
    ? "#2271B3"
    : d == "SPC"
    ? "#730532"
    : d == "COMERCIO VECINAL"
    ? "#fa3c3c"
    : d == "CONJUNTO RESIDENCIAL"
    ? "#a57c00"
    : d == "OTROS USOS"
    ? "#9e9898"
    : d == "Limite Registral"
    ? "#E74C3C"
    : d == "Pasaje"
    ? "#9e9898"
    : d == "PASAJE"
    ? "#9e9898"
    : d == "Estacionamiento"
    ? "#9e9898"
    : d == "Vereda"
    ? "#B3B6B7"
    : d == "VEREDA"
    ? "#B3B6B7"
    : d == "Via"
    ? "#4B4B4B"
    : d == "ZONA RESERVADA"
    ? "#B04805"
    : d == "Palmeras"
    ? "#38a800"
    : "#dbc816";
}

function estilo(feature) {
  return {
    fillColor: getColor(feature.properties.uso),
    weight: 2,
    opacity: 1,
    color: "black",
    dashArray: "1",
    fillOpacity: 0.8,
  };
}

//Proyectos GeoJson
//Tumbes

var CanoasLotes = L.geoJson(GeoLotes_Canoas, {
  style: estilo,
  onEachFeature: popup,
});
CanoasLotes.addTo(map);

var CanoasPasajes = L.geoJson(GeoPasaje_Canoas, {
  style: estilo,
});
CanoasPasajes.addTo(map);

var CanoasParques = L.geoJson(GeoRecreacion_Canoas, {
  style: estilo,
  onEachFeature: popup,
});
CanoasParques.addTo(map);

var CanoasVeredas = L.geoJson(GeoVereda_Canoas, {
  style: estilo,
});
CanoasVeredas.addTo(map);

var CanoasVerde = L.geoJson(GeoAreaVerde_Canoas, {
  style: estilo,
});
CanoasVerde.addTo(map);

var CanoasPortico = L.geoJson(GeoPortico_Canoas, {
  style: estilo,
});
CanoasPortico.addTo(map);

/* var CanoasPalmeras = L.geoJson(GeoPalmeras_Canoas, {
  style: estilo,
});
CanoasPalmeras.addTo(map); */

// Ver Manzanas//

function VerMZ(feature, layer) {
  layer.bindTooltip(feature.properties.Text, {
    permanent: true,
    direction: "center",
    className: "color-mz",
  });
}

const geojsonMarkerOptions = {
  radius: 8,
  fillColor: "#ff7800",
  color: "#000",
  weight: 1,
  opacity: 1,
  fillOpacity: 0.8,
};

function estiloPunto(feature, latlng) {
  return L.circleMarker(latlng, geojsonMarkerOptions);
}

var CanoasManzanas = L.geoJson(GeoManzanas_Canoas, {
  pointToLayer: estiloPunto,
  onEachFeature: VerMZ,
});
CanoasManzanas.addTo(map);
///

//-----------------------

//Praga

//------------------

var PragaLotes = L.geoJson(GeoLotes_Praga, {
  style: estilo,
  onEachFeature: popup,
});
PragaLotes.addTo(map);


//Arequipa
//------------------

var CcIIVia = L.geoJson(geovias_CCII, {
  style: estilo,
  //onEachFeature: popup,
});
CcIIVia.addTo(map);

var MccIILotes = L.geoJson(geomcc_II, {
  style: estilo,
  onEachFeature: popup,
});
MccIILotes.addTo(map);

var CcIIEstacionamiento = L.geoJson(geoestacionamiento_CCII, {
  style: estilo,
  onEachFeature: popup,
});
CcIIEstacionamiento.addTo(map);

var CcIIAreaVerde = L.geoJson(geoareaverde, {
  style: estilo,
  //onEachFeature: popup,
});
CcIIAreaVerde.addTo(map);

var CcIIParques = L.geoJson(geoparques_CCII, {
  style: estilo,
  //onEachFeature: popup,
});
CcIIParques.addTo(map);

var CCII_Manzanas = L.geoJson(geoMz_CCII, {
  pointToLayer: estiloPunto,
  onEachFeature: VerMZ,
});
CCII_Manzanas.addTo(map);


function buscarLotes() {}


//boton search = buscar
/* function xsearch() {
  searchControl = new L.Control.Search({
    layer: xbuscar,
    zoom: 20,
    propertyName: "ML",
    circleLocation: false,
  });

  searchControl
    .on("search_locationfound", function (e) {
      e.layer.setStyle({ fillColor: "#3f0", color: "#0f0" });
    })
    .on("search_collapsed", function (e) {
      xbuscar.eachLayer(function (layer) {
        //restauramos el color del elemento
        xbuscar.resetStyle(layer);
      });
    });
  map.addControl(searchControl);
}

//obtener texto de un select
var xbuscar = CanoasLotes;
var searchControl;

function buscarLotes() {
  var xcombo = document.getElementById("select-proyectos");
  var xhabilita = xcombo.options[xcombo.selectedIndex].text;

  //-------------------

  if (xhabilita == "Punta Canoas") {
    xbuscar = CanoasLotes;
  } else {
    xbuscar = MccIILotes;
  }
  //document.getElementById('mensaje').innerText= xhabilita;

  map.removeControl(searchControl);
  xsearch();
}

xsearch(); */

function verplanos() {
  var xverlote = document.getElementById("verinfo");
  if (xverlote.style.display == "block") {
    xverlote.style.display = "none";
  } else {
    xverlote.style.display = "block";
  }
}

function buscarlote() {
    
  var xcmbproyectos = document.getElementById("select-proyectos"); //id del cmbhabilitacion
  var xproyecto = xcmbproyectos.options[xcmbproyectos.selectedIndex].text;
  var xml = document.getElementById("txtml").value;
  var xquery = "select * from lotes where ml='" +
    xml.toUpperCase() +
    "' and proyecto = (select id from proyectos where proyecto='" +
    xproyecto +
    "')"; 
  
  if (xml == "") {
    alert("Ingrese Manzana-Lote");
    document.getElementById("txtml").focus();
  } else {
    
    $.ajax({
      type: "POST",
      url: "Report/buscarlotes.php",
      data: { xquery: xquery },
      dataType: "JSON",
      success: function (data) {
        // var xlat = data.latitud;
        var xlat = data.latitud;
        var xlong = data.longitud;
        marcarlote(xlat, xlong);
      },
    });
    
  }
}

var Lmarcar = []; // Array para la function marcarlote
function marcarlote(_lat, _long) {
 
  //------Borrar y Marcar Marker    -----//
  var marcar = L.marker([_lat, _long]);

  for (i = 0; i < Lmarcar.length; i++) {
    map.removeLayer(Lmarcar[i]);
  }

  Lmarcar.push(marcar);
  map.addLayer(marcar);
  map.setView([_lat, _long], 20);

  //  savecoord(_lat, _long);
  //---------------------//
}
