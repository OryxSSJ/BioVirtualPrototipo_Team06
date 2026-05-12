<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3><?= count($roles); ?></h3>
                <p>Roles registrados</p>
            </div>
            <div class="icon"><i class="bi bi-bookmarks"></i></div>
            <a href="<?=APP_URL;?>/admin/roles" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= count($usuarios); ?></h3>
                <p>Usuarios registrados</p>
            </div>
            <div class="icon"><i class="bi bi-people-fill"></i></div>
            <a href="<?=APP_URL;?>/admin/usuarios" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= count($niveles); ?></h3>
                <p>Niveles registrados</p>
            </div>
            <div class="icon"><i class="bi bi-bookshelf"></i></div>
            <a href="<?=APP_URL;?>/admin/niveles" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= count($grados); ?></h3>
                <p>Grados registrados</p>
            </div>
            <div class="icon"><i class="bi bi-bar-chart-steps"></i></div>
            <a href="<?=APP_URL;?>/admin/grados" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= count($materias); ?></h3>
                <p>Materias registradas</p>
            </div>
            <div class="icon"><i class="bi bi-book-half"></i></div>
            <a href="<?=APP_URL;?>/admin/materias" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <p>Chat de IA</p>
                <p>Empieza a chatear con AMLO 5</p>
            </div>
            <div class="icon"><i class="bi bi-chat-dots"></i></div>
            <a href="<?=APP_URL;?>/admin/chat" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-light">
            <div class="inner">
                <h3><?= count($administrativos); ?></h3>
                <p>Administrativos</p>
            </div>
            <div class="icon"><i class="bi bi-person-badge"></i></div>
            <a href="<?=APP_URL;?>/admin/administrativos" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-dark">
            <div class="inner">
                <h3><?= count($docentes); ?></h3>
                <p>Docentes</p>
            </div>
            <div class="icon"><i class="bi bi-person-video3"></i></div>
            <a href="<?=APP_URL;?>/admin/docentes" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= count($estudiantes); ?></h3>
                <p>Estudiantes</p>
            </div>
            <div class="icon"><i class="bi bi-backpack2"></i></div>
            <a href="<?=APP_URL;?>/admin/estudiantes" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Estudiantes por Grado</h3>
            </div>
            <div class="card-body">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Estudiantes inscritos (Mensual)</h3>
            </div>
            <div class="card-body">
                <canvas id="myChart2"></canvas>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-3">
        <div class="card card-outline card-primary text-center">
            <div class="card-header"><h3 class="card-title">Estudiantes</h3></div>
            <div class="card-body">
                <input type="text" class="knob" value="<?=count($estudiantes)?>" data-min="0" data-max="1000" data-readonly="true" data-width="100" data-height="100" data-fgColor="#ba1db4">
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-outline card-primary text-center">
            <div class="card-header"><h3 class="card-title">Docentes</h3></div>
            <div class="card-body">
                <input type="text" class="knob" value="<?=count($docentes)?>" data-min="0" data-max="50" data-readonly="true" data-width="100" data-height="100" data-fgColor="#ba881d">
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-outline card-primary text-center">
            <div class="card-header"><h3 class="card-title">Usuarios</h3></div>
            <div class="card-body">
                <input type="text" class="knob" value="<?=count($usuarios)?>" data-min="0" data-max="<?=count($usuarios)+50?>" data-readonly="true" data-width="100" data-height="100" data-fgColor="#201dba">
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-outline card-primary text-center">
            <div class="card-header"><h3 class="card-title">Administrativos</h3></div>
            <div class="card-body">
                <input type="text" class="knob" value="<?=count($administrativos)?>" data-min="0" data-max="20" data-readonly="true" data-width="100" data-height="100" data-fgColor="#1dbaba">
            </div>
        </div>
    </div>
</div>

<?php
// Lógica PHP para preparar datos de las gráficas
$contadores = [
    'sec1' => 0, 'sec2' => 0, 'sec3' => 0,
    'bac1' => 0, 'bac2' => 0, 'bac3' => 0, 'bac4' => 0, 'bac5' => 0, 'bac6' => 0
];
foreach($reportes_estudiantes as $re){
    if($re['id_grado'] == "1") $contadores['sec1']++; 
    if($re['id_grado'] == "13") $contadores['sec2']++; 
    if($re['id_grado'] == "14") $contadores['sec3']++; 
    if($re['id_grado'] == "7") $contadores['bac1']++; 
    if($re['id_grado'] == "8") $contadores['bac2']++; 
    if($re['id_grado'] == "9") $contadores['bac3']++; 
    if($re['id_grado'] == "10") $contadores['bac4']++; 
    if($re['id_grado'] == "11") $contadores['bac5']++; 
    if($re['id_grado'] == "12") $contadores['bac6']++; 
}
$datos_grafica_barras = implode(',', $contadores);

// Logica meses
$meses_count = array_fill(1, 12, 0); // Array del 1 al 12 inicializado en 0
foreach($reportes_estudiantes as $re){
    $mes = date("n", strtotime($re['fyh_creacion'])); // "n" da el mes sin ceros iniciales (1-12)
    $meses_count[$mes]++;
}
$datos_grafica_lineal = implode(',', $meses_count);
?>

<script>
    // Gráfica Barras
    var grados = ['Sec 1','Sec 2','Sec 3','Bac 1','Bac 2','Bac 3','Bac 4','Bac 5','Bac 6'];
    var datosBar = [<?=$datos_grafica_barras?>];
    new Chart(document.getElementById('myChart'), {
        type: 'bar',
        data: { labels: grados, datasets: [{ label:'Estudiantes', data: datosBar, borderWidth: 1 }] },
        options: { scales: { y: { beginAtZero: true } } }
    });

    // Gráfica Lineal
    var meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    var datosLine = [<?=$datos_grafica_lineal?>];
    new Chart(document.getElementById('myChart2'), {
        type: 'line',
        data: { labels: meses, datasets: [{ label:'Inscritos Mensual', data: datosLine, borderWidth: 1 }] },
        options: { scales: { y: { beginAtZero: true } } }
    });

    // Knobs
    $(function () {
        $('.knob').knob({
            draw: function () {
                if (this.$.data('skin') == 'tron') {
                    // Logica Tron (simplificada para no llenar espacio)
                    var a = this.angle(this.cv), sa = this.startAngle, sat = this.startAngle, ea, eat = sat + a, r = true;
                    this.g.lineWidth = this.lineWidth;
                    this.o.cursor && (sat = eat - 0.3) && (eat = eat + 0.3);
                    if (this.o.displayPrevious) {
                        ea = this.startAngle + this.angle(this.value);
                        this.o.cursor && (sa = ea - 0.3) && (ea = ea + 0.3);
                        this.g.beginPath();
                        this.g.strokeStyle = this.previousColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                        this.g.stroke();
                    }
                    this.g.beginPath();
                    this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                    this.g.stroke();
                    this.g.lineWidth = 2;
                    this.g.beginPath();
                    this.g.strokeStyle = this.o.fgColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                    this.g.stroke();
                    return false;
                }
            }
        });
    });
</script>