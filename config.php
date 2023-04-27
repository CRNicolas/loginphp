<?php
    define('DBServer', 'localhost:3305');//servidor de base de datos
    define('DBUsuario', 'root');//usuario
    define('DBContraseña', '');//contraseña
    define('DBNombre', 'topicos');//bombre de la base de datos

    // conexcion a la base de datos
    try {
        $pdo = new PDO("mysql:host=".DBServer.";dbname=".DBNombre, DBUsuario, DBContraseña);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Error de conexión a la base de datos: " . $e->getMessage();
        exit();
    }
    //echo "Connected successfully";
?>