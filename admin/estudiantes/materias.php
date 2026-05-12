<?php
include('../../app/config.php');
include('../../admin/layout/parte1.php');

// CORRECCIÓN AQUÍ: Faltaba un "../" para llegar a la raíz correcta
include('../../app/controllers/estudiantes/mis_materias.php');

// Array de colores para decorar las tarjetas aleatoriamente
$colores = ['bg-primary', 'bg-success', 'bg-warning', 'bg-info', 'bg-danger', 'bg-secondary', 'bg-dark'];
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">
                <i class="bi bi-backpack"></i> Mis Materias
            </h1>
            <!-- Usamos el operador ?? por si la variable no llega definida -->
            <small class="text-muted">Estás inscrito en: <b><?= $nombre_grado ?? 'Grado no definido' ?></b></small>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- Validamos que $materias exista y no esté vacío -->
            <?php if (!isset($materias) || empty($materias)) { ?>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> No tienes materias asignadas todavía. Contacta a administración.
                </div>
            <?php } else { ?>

                <div class="row mt-4">
                    <?php 
                    $contador = 0;
                    foreach ($materias as $materia) { 
                        // Seleccionar un color cíclico del array
                        $color_actual = $colores[$contador % count($colores)];
                        $contador++;
                    ?>
                        
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <!-- Tarjeta de Materia -->
                            <div class="card h-100 shadow-sm hover-card">
                                <!-- Encabezado de color -->
                                <div class="card-header <?= $color_actual ?> text-white text-center py-4">
                                    <h1 class="font-weight-bold"><i class="bi bi-book"></i></h1>
                                </div>
                                
                                <div class="card-body text-center">
                                    <h5 class="card-title font-weight-bold text-dark">
                                        <?= htmlspecialchars($materia['nombre_materia']) ?>
                                    </h5>
                                    <p class="card-text text-muted small">
                                        Accede a las tareas y recursos de esta materia.
                                    </p>
                                </div>

                                <div class="card-footer bg-white border-top-0 text-center pb-4">
                                    <!-- ENLACE AL CLASSROOM DE LA MATERIA -->
                                    <a href="<?=APP_URL?>/admin/estudiantes/classroom/index.php?id_materia=<?=$materia['id_materia']?>" 
                                       class="btn btn-outline-dark btn-block rounded-pill">
                                        Entrar a clase <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </div>

            <?php } // Fin del else ?>

        </div>
    </section>
</div>

<!-- Un poco de CSS extra para efecto hover -->
<style>
    .hover-card {
        transition: transform 0.2s ease-in-out;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>

<?php include('../../admin/layout/parte2.php'); ?>