let mysql = require("mysql")
let conexion = mysql.createConnection({
    host: "www.sixtemakgis.com",
    database: "sixtemak_elcholo_t2",
    user: "sixtemak_desarrollo",
    password:"topacio310571"
});

conexion.connect(function(err){
    if (err){
        throw err;
    }else{console.log("conexion exitosa")}
});


const categorias = "select * from documentos";
conexion.query(categorias,function(error,lista){
    if(error){
        throw(erroe);
    }else{
        console.log(lista);
        console.log(lista.length);
        console.log(lista[2].documento);
    }
});

conexion.end();
//www.sixtemakgis.com;DATABASE=sixtemak_elcholo_t2;User Id=sixtemak_desarrollo;password=topacio310571;"