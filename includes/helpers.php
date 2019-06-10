<?php

//Función para mostrar errores
function mostrarError($errores, $campo){
    $alerta = '';// se crea variable  para mostrar los errores en la vista index.php
    if (isset($errores[$campo]) && !empty($campo)){
        $alerta = '<div class="alerta alerta-error">'.$errores[$campo].'</div>';
    }
    return $alerta;
}
//Función para borrar errores de la vista
function borrarErrores(){
    $borrado = false;
    
    if(isset($_SESSION['errores'])){
    $_SESSION['errores'] = null;// se eliminan los errores de la sesión
    //$borrado = session_unset($_SESSION['errores']);
    $borrado = true; // se eliminan los errores de la sesión
    }
    
    if(isset($_SESSION['errores_entrada'])){
    $_SESSION['errores_entrada'] = null;// se eliminan los errores de la sesión
    $borrado = true;
    
    }
    
    if(isset($_SESSION['completado'])){
    $_SESSION['completado'] = null;// se eliminan los errores de la sesión
    //$borrado = session_unset($_SESSION['errores']);
    $borrado = true; // se eliminan los errores de la sesión
    }
    
    return $borrado;
}
//Función para listar categorias en el menú
function conseguirCategorias($conexion){
    $sql = "SELECT * FROM categorias ORDER BY id ASC";
    $categorias = mysqli_query($conexion, $sql);
    
    $resultado = array();
    if ($categorias && mysqli_num_rows($categorias) >= 1) {
       $resultado = $categorias; 
    }
    return $resultado;
}

//Función para listar categorias en el menú
function conseguirCategoria($conexion, $id){
    $sql = "SELECT * FROM categorias WHERE id = $id;";
    $categorias = mysqli_query($conexion, $sql);
    
    $resultado = array();
    if ($categorias && mysqli_num_rows($categorias) >= 1) {
       $resultado = mysqli_fetch_assoc($categorias); 
    }
    return $resultado;
}

//Función para conseguir una sola entrada
function conseguirEntrada($conexion, $id){
    $sql = "SELECT e.*, c.nombre AS 'categoria', CONCAT(u.nombre, ' ', u.apellidos) AS 'usuario'".
         " FROM entradas e ".
         "INNER JOIN categorias c ON e.categoria_id = c.id ".
          "INNER JOIN usuarios u ON e.usuario_id = u.id ".
         "WHERE e.id = $id;";
    $entrada = mysqli_query($conexion, $sql);
    
    $resultado = array();
    if($entrada && mysqli_num_rows($entrada) >= 1){
       $resultado = mysqli_fetch_assoc($entrada); 
    }
    return $resultado;
}

// función para listar las últimas entradas
function conseguirEntradas($conexion, $limit = null, $categoria = null, $busqueda = null){
    $sql = "SELECT e.*, c.nombre AS 'categoria' FROM entradas e ".
         "INNER JOIN categorias c ON e.categoria_id = c.id ";
    
    if(!empty($categoria)){
        $sql .= " WHERE e.categoria_id = $categoria";
    }
    
    if(!empty($busqueda)){
        $sql .= " WHERE e.titulo LIKE '%$busqueda%' ";
    }
 
//    die();
    $sql .= " ORDER BY e.id DESC ";
    if($limit){
        //$sql = $sql. "LIMIT 4";
        $sql .= 'LIMIT 4';
    }
        
//    Código para depuración
//    echo $sql;
//    var_dump($sql);
//    die();
    $entradas = mysqli_query($conexion, $sql);
    
    $resultado = array();
    if ($entradas && mysqli_num_rows($entradas) >= 1) {
       $resultado = $entradas; 
    }
    return $entradas;
}

