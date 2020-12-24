<?php
    /*
        *
        * @author Francisco José Gordo Salguero
        * Fecha Inicio: 22/11/2020
        * Fecha Fin: 22/11/2020
        * Curso: 2do FPS DAW Presencial
        * Modulo: Programación PHP
        * Practica CRUD for Beginners
        * Practica de codigo Faninja
        * https://codeofaninja.com/2011/12/php-and-mysql-crud-tutorial.html
        * @versión: 1.0
    */
        
    // used to connect to the database

    $host = "localhost";
    $db_name = "php_beginner_crud_level_1";
    $username = "root";
    $password = "";

    try {
        $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    } catch (Exception $exception) {
        echo "Connection error: " . $exception->getMessage();
    }
?>