<?php
// Iniciar la sesión y la conexión a la BBDD
require_once 'includes/conexion.php';

// Recoger los datos del formulario
if(isset($_POST)){
    
    //Borrar error antiguo
    if(isset($_SESSION['error_login'])){
        session_unset($_SESSION['error_login']); 
    }
    //Recojo datos en el formulario
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Consulta para comprobar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $login = mysqli_query($db, $sql);
    
if($login && mysqli_num_rows($login) == 1){
        //Comprobar la contraseña
        $usuario = mysqli_fetch_assoc($login);
//        Líneas para depuracióin en caso de fallo 
//        var_dump($usuario);
//        die();
        $verify = password_verify($password, $usuario['password']);
        
        if($verify){
         // Utilizar una sesión para guardar los datos del usuario logueado
           $_SESSION['usuario'] = $usuario;
           $_SESSION['error_login'] = null; // línea puesta para eliminar el error cuando el login yo hago la correción 
            
        }else{
            //Sí algo falla enviar una sesión con el fallo
            $_SESSION['error_login'] = 'Login incorrecto!!';
        }
         
    }else {
        //Mensaje de error
         $_SESSION['error_login'] = 'Login incorrecto!!';
    }

}
//Redirigir al index.php
header('Location: index.php');
