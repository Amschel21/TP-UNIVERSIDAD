<?php
// Incluir la conexión a la base de datos
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibiendo los datos del formulario
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Consultar si el usuario existe
    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['usuario' => $usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($contraseña, $user['contraseña'])) {
        // Iniciar sesión si la contraseña es correcta
        session_start();
        $_SESSION['usuario'] = $usuario;
        header('Location: dashboard.php');  // Redirigir a una página de inicio después de iniciar sesión
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Incluir tu archivo CSS aquí -->
</head>
<body>

    <div class="card">
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <button type="submit">Iniciar sesión</button>
        </form>

        <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    </div>

</body>
</html>
