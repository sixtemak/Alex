const express = require('express');
const cors = require('cors');
const conexion = require('./database');

const app = express();
const port = 3000;

app.use(cors());
app.use(express.json());

app.get('./usuarios', (req, res) => {
    conexion.query('select * from usuarios',(err, results) => {
        if(err){
            res.status(500).send('Error database');
            return;
        }
        res.json(results);
    });
});

app.listen(port, () => {
    console.log(`Servidor escuchando en ${port}`);
});