<?php
include ('../app/config.php');
include ('../admin/layout/parte1.php');

// Incluimos todos los controladores de datos
// (Nota: Idealmente solo deberías cargar lo necesario por rol, pero para no romper tu lógica actual, los dejamos todos)
include ('../app/controllers/roles/listado_de_roles.php');
include ('../app/controllers/usuarios/listado_de_usuarios.php');
include ('../app/controllers/niveles/listado_de_niveles.php');
include ('../app/controllers/grados/listado_de_grados.php');
include ('../app/controllers/materias/listado_de_materias.php');
include ('../app/controllers/administrativos/listado_de_administrativos.php');
include ('../app/controllers/docentes/listado_de_docentes.php');
include ('../app/controllers/estudiantes/listado_de_estudiantes.php');
include ('../app/controllers/estudiantes/reportes_estudiantes_grados.php');
include ('../app/controllers/estudiantes/reporte_estudiantes.php');
?>

<div class="content-wrapper">
    <br>
    <div class="container">
        <div class="row">
            <h1><?=APP_NAME;?></h1>
        </div>
        <br>

        <?php
        // LOGICA DE ENRUTAMIENTO DE VISTAS
        switch ($rol_sesion_usuario) {
            case "ADMINISTRADOR":
                include ('vistas/admin.php');
                break;

            case "DOCENTE":
                include ('vistas/docente.php');
                break;

            case "ESTUDIANTE":
                include ('vistas/estudiante.php');
                break;

            case "DIRECTOR ACADÉMICO":
                include ('vistas/academico.php');
                break;
            case "DIRECTOR ADMINISTRATIVO":
                include ('vistas/adminis.php');
                break;
            case "CONTADOR":
                include ('vistas/contador.php');
                break;
            case "SECRETARIA":
                
                include ('vistas/secretaria.php');
                break;
            
            default:
                echo "<div class='alert alert-danger'>Error: Rol no identificado o sin vista asignada.</div>";
                break;
        }
        ?>

    </div>
</div>

<?php
include ('../admin/layout/parte2.php');
include ('../layout/mensajes.php');
?>