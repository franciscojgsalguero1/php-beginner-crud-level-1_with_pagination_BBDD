<!-- 
    /*
        *
        * @author Francisco José Gordo Salguero
        * Fecha Inicio: 22/11/2020
        * Fecha Fin: 22/11/2020
        * Curso: 2do FPS DAW Presencial
        * Modulo: Programación PHP
        * Practica CRUD for Beginners with pagination
        * Practica de codigo Faninja
        * https://codeofaninja.com/2011/12/php-and-mysql-crud-tutorial.html
        * @versión: 1.0
    */
-->
<?php

    // include database connection
    include 'config/database.php';
    
    try {
        // get record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        
        // delete query
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id);
        
        if($stmt->execute()) {
            // redirect to read records page and tell the user record was deleted
            header('Location: index.php?action=deleted');
        } else {
            die ('Unable to delete record.');
        }
        
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
?>