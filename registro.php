<?php

if(isset($_POST)){
        //incluir la conexión a la base de datos
    require_once 'includes/conexion.php';
    
    //iniciar la sesión 
    if(!isset($_SESSION)){
         session_start();
    }

    
    //Recoger los valores del formulario de registro
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;
 
//Array de errores
$errores = array();
    
// Validar la información antes de guardarla en la base de datos
//Validar campo nombre
if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)){
    $nombre_validado = true;
}else {
    $nombre_validado = false;
    $errores['nombre'] = 'El nombre no es válido';
}
//Validar apellidos 
if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)){
    $apellidos_validado = true;
}else {
    $apellidos_validado = false;
    $errores['apellidos'] = 'Los apellidos no son válidos';
}
//validar Email
if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
    $email_validado = true;
}else {
    $email_validado = false;
    $errores['email'] = 'El email no es válido';
}
//Validar contraseña
if(!empty($password)){
    $password_validado = true;
}else {
    $password_validado = false;
    $errores['password'] = 'La contraseña está vacía';
}
$guardar_usuario = false;// declara variable para guardar el usuario
if(count($errores) == 0){
    $guardar_usuario = true;
    
    //Cifrar la contraseña 
    $password_segura = password_hash($password,PASSWORD_BCRYPT, ['cost'=>4]);
    
    //var_dump($password);
    //var_dump($password_segura);
   
    //INSERTAR USUARIO EN LA TABLA DE USUARIO DE LA BBDD
    $sql = "INSERT INTO usuarios VALUES(null, '$nombre', '$apellidos', '$email', '$password_segura', CURDATE())";
    $guardar = mysqli_query($db, $sql);
    
    /* estas líneas son para depurar el programa cuando presenta errores en la consulta.
    var_dump(mysqli_error($db));
    die();
    */
    //Comprobando la consulta
    if($guardar){
        $_SESSION['completado'] = "El registro se ha completado con éxito";
    }else{
        $_SESSION['errores']['general'] = "Fallo al guardar el usuario!!";
    }
    
}else{
    $_SESSION['errores'] = $errores;
 
}
}
 header('Location: index.php');