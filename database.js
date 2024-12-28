const mysql = require('mysql2');
const conexion = mysql.createConnection({
    host: 'www.sixtemakgis.com',
    database: 'sixtemak_elcholo_t2',
    user: 'sixtemak_desarrollo',
    password:'topacio310571'
});

conexion.connect((err) =>{
    if (err){
        console.error('Error database', err);
        return;
    }
    console.log('conexion exitosa a Mysql');
});

module.exports = conexion;