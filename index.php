
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Elegant Modal Login Modal Form with Icons</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    </head>
    <body>
        <?php
        try {
            $base = new PDO("mysql:host=localhost; dbname=colegio", "root", "");
            $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $base->exec("SET CHARACTER SET utf8");
            $tam_pages = 3; /* Números a mostrar por página */
            if (isset($_GET["pagina"])) {/* Cuando haga click en la página */
                if ($_GET["pagina"] == 1) {
                    header("Location:index.php");
                } else {
                    $page = $_GET["pagina"];
                }
            } else { //carga por primera vez sin hacer click entra,
                $page = 1; /* cargarse en uno la paginación */
            }

            $page_empezar = ($page - 1) * $tam_pages;
            $sql_total = "SELECT FirstName, Apellido, idioma from alumno where idioma= 3";
            $resultado = $base->prepare($sql_total);
            $resultado->execute(array());
            $num_filas = $resultado->rowCount(); /* Cuantas filas nos devuelve el array */
            $total_pages = ceil($num_filas / $tam_pages); //ceil() redondea el resultado.

            echo "Alumnos del Centro <br/>";
            echo "Número de registro de las consultas:" . $num_filas . "<br>";
            echo $tam_pages . " Registros por página";
            echo "Mostrando la página " . $page . " de " . $total_pages . "<br>";

            $resultado->closeCursor();

            $sql_limit = "SELECT FirstName, Apellido, idioma from alumno  where idioma= 3 Limit $page_empezar,$tam_pages "; /* Limit 0 primer registro y cuantos debe mostrar */
            $resultado = $base->prepare($sql_limit);
            $resultado->execute(array());

            echo' <div class="modal-dialog modal-login">
            <div class="modal-content">
                <div class="modal-header">				
                    <h4 class="modal-title">Listado de Alumnos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>';
            while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                echo "Nombre: " . $registro["FirstName"] . " Apellido: " . $registro["Apellido"] . " Idioma: ". $registro["idioma"]. "<br/>";
                echo ' <div class="modal-content"> ' . '<form>';
                echo '<div class="form-group"> <label for="">Nombre</label>';?>
              
                         <input type="text" class="form-control" id="" aria-describedby="" value="<?php echo $registro["FirstName"]; ?>">

                        </div>
                        <div class="form-group">
                             <label for="">Apellido</label>
                            <input type="nsme" class="form-control" id="" aria-describedby="emailHelp" value="<?php echo $registro["Apellido"]; ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Idiomas</label>
                <select multiple class='form-control' id='exampleFormControlSelect2' name='idioma[]' > 
                    <option value="<?php $registro["idioma"] ?>"><?php echo$registro["idioma"]; ?> </option> 
                </select>
            </div>          
        
            </form> </div>
    <?php //*echo "Nombre: " . $registro["FirstName"] . " Apellido: " . $registro["Apellido"] . " Idioma: ". $registro["idioma"]. "<br/>";*//
     } ?>
      
    <?php

} catch (Exception $e) {
    echo "Línea de error:" . $e->getLine();
}


/* * ***********************Paginación*********************************** */
 echo '<nav aria-label="Page navigation example">  <ul class="pagination">';
for ($i = 1; $i <= $total_pages; $i++) {
   
    echo "<a class='page-link' href='?pagina=" . $i . "'>" . $i . "</a>";
}
echo "</ul> </nav>
  </div>
     </div>";
?>
</body>
</html>   