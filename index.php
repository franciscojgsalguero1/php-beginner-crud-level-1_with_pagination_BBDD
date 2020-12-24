<!--
    /*
        *
        * @author Francisco José Gordo Salguero
        * Fecha Inicio: 22/11/2020
        * Fecha Fin: ??/11/2020 inacabado
        * Curso: 2do FPS DAW Presencial
        * Modulo: Programación PHP
        * Practica CRUD for Beginners with pagination and save image in BBDD
        * Practica de codigo Faninja
        * https://codeofaninja.com/2011/12/php-and-mysql-crud-tutorial.html
        * @versión: 1.0
    */
-->

<!DOCTYPE HTML>
<html>
    <head>
        <title> PDO - Read Records - PHP CRUD Tutorial</title>
        
        <!-- Latest compiled and minified Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- custom CSS -->
        <style>
            .m-r-1em{ margin-right: 1em; }
            .m-b-1em{ margin-bottom: 1em; }
            .m-1-1em{ margin-left: 1em; }
            .mt0{ margin-top: 0;}
            .uploads {
                padding: 4px;
                width: 320px;
            }
        </style>
    </head>
    <body>
        <!-- container -->
        <div class="container">
            <div class="page-header">
                <h1>Read Products</h1>
            </div>
            
            <!-- PHP code to read records will be here -->
            <?php 

                // include database connection
                include 'config/database.php';
                
                // PAGINATION VARIABLES
                // page is the current page, if there's nothing set, default is page 1
                $page = isset($_GET['page']) ? $_GET['page'] : 1;

                // set records or rows of data per page
                $records_per_page = 5;

                // calculate for the query LIMIT clause
                $from_record_num = ($records_per_page * $page) - $records_per_page;
                
                // delete message prompt will be here
                
                $action = isset($_GET['action']) ? $_GET['action'] : "";
                
                // if it was redirected from delete.php
                
                if($action=='deleted') {
                    echo "<div class='alert alert-success'> Record was deleted. </div>";
                }
                
                // select data for current page
                $query = "SELECT id, name, description, price, uploads FROM products ORDER BY id ASC LIMIT :from_record_num, :records_per_page";
                
                $stmt = $con->prepare($query);
                $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
                $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
                $stmt->execute();                
                
                // this is how to get number of rows returned
                $num = $stmt->rowCount();
                
                // link to create record form
                echo "<a href='/TodoCursoPHP/CodeFaninja/CRUD%20for%20Beginners/php-beginner-crud-level-1_with_pagination/create.php' class='btn btn-primary m-b-1em'> Create New Product </a>";
                
                // check if more than 0 record found
                if($num>0) {
                    
                    // data from database will be here
                    echo "<table class='table table-hover table-responsive table-bordered'>"; // start table
                    
                        // creating our table heading
                        echo "<tr>";
                            echo "<th>ID</th>";
                            echo "<th>Name</th>";
                            echo "<th>Description</th>";
                            echo "<th>Price</th>";
                            echo "<th>Image</th>";
                            echo "<th>Action</th>";
                        echo "</tr>";
                        
                        // table body will be here
                        // retrieve our table contents
                        // fetch() is faster than fetchAll()
                        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // extract row
                            // this will make $row['firstname'] to
                            // just $firstname only
                            extract($row);
                            
                            
                            // creating new table row per record
                            
                            echo "<tr>";
                                echo "<td>{$id}</td>";
                                echo "<td>{$name}</td>";
                                echo "<td>{$description}</td>";
                                echo "<td> \$ {$price}</td>";                                
                                echo "<td class='uploads'> <img src=data:image/jpeg;base64," .stripslashes($uploads) ." Alt='Image not found'/> </td>";
                                echo "<td>";
                                    // read one record
                                    echo "<a href='/TodoCursoPHP/CodeFaninja/CRUD%20for%20Beginners/php-beginner-crud-level-1_with_pagination_BBDD/read_one.php?id={$id}' class='btn btn-info m-r-1em'>Read</a>";
                                    
                                    // we will use this links on next part of this post
                                    echo "<a href='/TodoCursoPHP/CodeFaninja/CRUD%20for%20Beginners/php-beginner-crud-level-1_with_pagination_BBDD/update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";
                                    
                                    // we will use this links on next part of this post
                                    echo "<a href='/TodoCursoPHP/CodeFaninja/CRUD%20for%20Beginners/php-beginner-crud-level-1_with_pagination_BBDD/delete.php?id={$id}' onclick=delete_user({$id})' class='btn btn-danger'>Delete </a>";
                                echo "</td>";
                            echo "</tr>";
                        }
                        
                    // end table
                        
                    echo "</table>";
                    
                    // PAGINATION
                    // count total number of rows
                    $query = "SELECT COUNT(*) as total_rows FROM products";
                    $stmt = $con->prepare($query);
                    
                    // execute query
                    $stmt->execute();
                    
                    // get total rows
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $total_rows = $row['total_rows'];
                    
                    // paginate records
                    $page_url="index.php?";
                    include_once "paging.php";
                    
                } else {
                    echo "<div class='alert alert-danger'> No records found. </div>";
                }
            ?>
                        
        </div> <!-- end .container -->
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

        <!-- Latest compiled and minified Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- confirm delete record will be here -->
        
        <script type="text/javascript">
            // confirm record deletion
            function delete_user(id) {
                
                var answer = confirm('Are you sure?');
                if(answer) {
                    // if user clicked ok,
                    // pass the id to delete.php and execute the delete query
                    window.location = 'delete.php?id=' + id;
                }
            }
        </script>
        
    </body>
</html>