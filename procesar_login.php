<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['username'];
    $contrasena = $_POST['password'];

    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "root", "", "sistema");

    if ($conexion->connect_error) {
        die("Error de conexión a la base de datos: " . $conexion->connect_error);
    }

    // Consulta SQL para verificar las credenciales y obtener el rol del usuario
    $query = "SELECT * FROM usuarios WHERE username = '$usuario' AND password = '$contrasena'";
    $resultado = $conexion->query($query);

    if ($resultado->num_rows == 1) {
        $usuario_info = $resultado->fetch_assoc();

        $_SESSION['id'] = $usuario_info['id'];
        $_SESSION['username'] = $usuario_info['username'];
        $_SESSION['role'] = $usuario_info['role'];

        if ($_SESSION['role'] == 'administrador') {
            // Redireccionar a la página de administrador
            header("location: index.html");
        } elseif ($_SESSION['role'] == 'tecnico') {
            // Redireccionar a la página de técnico
            header("location: tecnico_home.php");
        }
        
        
    } else {
        header("location: index.php?error=1");
    }

    $conexion->close();
}
?>
