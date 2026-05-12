<?php

$id_grado = $_GET['id'];
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');

include ('../../app/controllers/grados/datos_grados.php');
include ('../../app/controllers/niveles/listado_de_niveles.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Modificación del grado: <?=$curso;?></h1>
            </div>
            <br>
            <div class="row">

                <div class="col-md-6">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?=APP_URL;?>/app/controllers/grados/update.php" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Nivel</label>
                                            <input type="text" name="id_grado" value="<?=$id_grado;?>" hidden>
                                            <select name="nivel_id" id="" class="form-control">
                                                <?php
                                                foreach ($niveles as $nivele){
                                                    ?>
                                                    <option value="<?=$nivele['id_nivel'];?>"<?=$nivel_id==$nivele['id_nivel'] ? 'selected' : ''?>><?=$nivele['nivel']." - ".$nivele['turno'];?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Curso</label>
                                            <select name="curso" id="" class="form-control">
                                                <option value="SECUNDARIA - 1"<?=$curso=='SECUNDARIA - 1' ? 'selected' : ''?>>SECUNDARIA - 1</option>
                                                <option value="SECUNDARIA - 2"<?=$curso=='SECUNDARIA - 2' ? 'selected' : ''?>>SECUNDARIA - 2</option>
                                                <option value="SECUNDARIA - 3"<?=$curso=='SECUNDARIA - 3' ? 'selected' : ''?>>SECUNDARIA - 3</option>
                                                <option value="BACHILLERATO - 1"<?=$curso=='BACHILLERATO - 1' ? 'selected' : ''?>>BACHILLERATO - 1</option>
                                                <option value="BACHILLERATO - 2"<?=$curso=='BACHILLERATO - 2' ? 'selected' : ''?>>BACHILLERATO - 2</option>
                                                <option value="BACHILLERATO - 3"<?=$curso=='BACHILLERATO - 3' ? 'selected' : ''?>>BACHILLERATO - 3</option>
                                                <option value="BACHILLERATO - 4"<?=$curso=='BACHILLERATO - 4' ? 'selected' : ''?>>BACHILLERATO - 4</option>
                                                <option value="BACHILLERATO - 5"<?=$curso=='BACHILLERATO - 5' ? 'selected' : ''?>>BACHILLERATO - 5</option>
                                                <option value="BACHILLERATO - 6"<?=$curso=='BACHILLERATO - 6' ? 'selected' : ''?>>BACHILLERATO - 6</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Grupo</label>
                                            <select name="paralelo" id="" class="form-control">
                                                <option value="A"<?=$paralelo=='A' ? 'selected' : ''?>>A</option>
                                                <option value="B"<?=$paralelo=='B' ? 'selected' : ''?>>B</option>
                                                <option value="C"<?=$paralelo=='C' ? 'selected' : ''?>>C</option>
                                                <option value="D"<?=$paralelo=='D' ? 'selected' : ''?>>D</option>
                                                <option value="E"<?=$paralelo=='E' ? 'selected' : ''?>>E</option>
                                                <option value="F"<?=$paralelo=='F' ? 'selected' : ''?>>F</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Actualizar</button>
                                            <a href="<?=APP_URL;?>/admin/grados" class="btn btn-secondary">Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php

include ('../../admin/layout/parte2.php');
include ('../../layout/mensajes.php');

?>
