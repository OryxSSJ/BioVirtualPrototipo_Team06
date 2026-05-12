<?php
include ('../app/config.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=APP_NAME;?> | Login</title>

    <!-- Google Font: Poppins (Fuente más moderna) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=APP_URL;?>/public/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=APP_URL;?>/public/dist/css/adminlte.min.css">
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            height: 100vh;
            overflow: hidden;
        }
        
        /* Layout de Pantalla Dividida */
        .login-container {
            height: 100vh;
            display: flex;
            flex-wrap: wrap;
        }

        /* Columna Izquierda (Imagen) */
        .login-image {
            background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80'); /* Imagen de alta calidad */
            background-size: cover;
            background-position: center;
            position: relative;
            flex: 1; /* Ocupa el espacio restante */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Overlay oscuro sobre la imagen */
        .login-image::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(0,50,120,0.8), rgba(0,0,0,0.6));
            z-index: 1;
        }

        .login-caption {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
            padding: 20px;
        }

        /* Columna Derecha (Formulario) */
        .login-form-section {
            width: 500px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 40px;
            box-shadow: -5px 0 15px rgba(0,0,0,0.05);
            position: relative;
            z-index: 10;
        }

        /* Estilos del Formulario */
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .login-header img {
            width: 100px;
            margin-bottom: 15px;
        }
        .login-header h3 {
            font-weight: 600;
            color: #333;
        }
        .login-header p {
            color: #777;
        }

        /* Inputs personalizados */
        .input-group {
            background: #f4f6f9;
            border-radius: 50px;
            padding: 5px 20px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            transition: all 0.3s;
        }
        .input-group:focus-within {
            border-color: #007bff;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0,123,255,0.1);
        }
        .form-control {
            border: none;
            background: transparent !important;
            height: 45px;
            font-size: 15px;
        }
        .form-control:focus {
            box-shadow: none;
        }
        .input-group-text {
            background: transparent;
            border: none;
            color: #007bff;
        }

        /* Botón */
        .btn-primary {
            border-radius: 50px;
            height: 50px;
            font-weight: 600;
            font-size: 16px;
            background: linear-gradient(90deg, #007bff, #0056b3);
            border: none;
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
            transition: transform 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,123,255,0.4);
        }

        /* Responsive: En móviles oculta la imagen */
        @media (max-width: 768px) {
            .login-image {
                display: none;
            }
            .login-form-section {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    
    <!-- COLUMNA IZQUIERDA: IMAGEN Y TEXTO -->
    <div class="login-image">
        <div class="login-caption">
            <h1 style="font-size: 3rem; font-weight: 700;">Bienvenido</h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">Inicia sesion para continuar</p>
        </div>
    </div>

    <!-- COLUMNA DERECHA: FORMULARIO -->
    <div class="login-form-section">
        
        <div class="login-header">
            <!-- Logo (Puedes cambiar la URL por tu logo real si tienes uno en public/images) -->
            <img src="https://cdn-icons-png.flaticon.com/512/2995/2995620.png" alt="Logo">
            <h3><?=APP_NAME;?></h3>
            <p>Ingresa tus credenciales para acceder</p>
        </div>

        <form action="controller_login.php" method="post" style="width: 100%;">
            
            <div class="input-group">
                <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>

            <div class="input-group">
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">
                        INICIAR SESIÓN
                    </button>
                </div>
            </div>

            <div class="mt-4 text-center">
                <small class="text-muted">Biovirtual v1.6</small>
            </div>
        </form>
    </div>

</div>

<!-- LOGICA DE ALERTAS (MANTENIDA EXACTAMENTE IGUAL) -->
<?php
session_start();
if(isset($_SESSION['mensaje'])){
    $mensaje = $_SESSION['mensaje'];
    ?>
    <script>
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Oops...",
            text: "<?=$mensaje;?>",
            showConfirmButton: true,
            confirmButtonColor: '#007bff'
        });
    </script>
<?php
    session_destroy();
}
?>

<!-- jQuery -->
<script src="<?=APP_URL;?>/public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=APP_URL;?>/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=APP_URL;?>/public/dist/js/adminlte.min.js"></script>

</body>
</html>