<?php
include('../../app/config.php');
include('../../admin/layout/parte1.php');



?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">

            <div class="row">
                <h1>Asistente IA (OpenBot)</h1>
            </div>

            <br>

            <div class="row">
                <div class="col-md-10">

                    <div class="card card-outline card-primary shadow">
                        <div class="card-header">
                            <h3 class="card-title">Bot inteligente</h3>
                        </div>

                        <div class="card-body" style="background:#f7f9fc">

                            <!-- Contenedor del chat -->
                            <div id="bot-box" 
                                 style="height:420px; overflow-y:auto; padding:15px; background:white; border-radius:8px; border:1px solid #dcdcdc;">
                            </div>

                            <br>

                            <!-- Input del mensaje -->
                            <div class="input-group">
                                <input id="input-msg" type="text" class="form-control" placeholder="Escribe tu mensaje…">
                                <button id="btn-send" class="btn btn-primary">
                                    Enviar
                                </button>
                            </div>

                            <!-- Barra de carga -->
                            <div id="loading" style="display:none; margin-top:10px;">
                                <img src="../../public/images/barra.gif" width="220">
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div><!-- /.container -->
    </div>
</div>

<?php include('../../admin/layout/parte2.php'); ?>
<?php include('../../layout/mensajes.php'); ?>

<script>
$(document).ready(function() {

    function addMessage(content, sender) {
        let color = sender === 'user' ? '#0056b3' : '#198754';
        let name  = sender === 'user' ? "Tú" : "Asistente";

        $("#bot-box").append(`
            <p style="margin-bottom:8px;">
                <strong style="color:${color};">${name}:</strong> ${content}
            </p>
        `);

        // Scroll automático
        $("#bot-box").scrollTop($("#bot-box")[0].scrollHeight);
    }

    function sendMessage() {
        let msg = $("#input-msg").val().trim();

        if (msg === "") return;

        addMessage(msg, "user");
        $("#input-msg").val("");

        $("#loading").show();

        $.ajax({
            url: "bot_api.php",
            type: "POST",
            data: { mensaje: msg },
            success: function(response) {
                $("#loading").hide();
                addMessage(response, "assistant");
            },
            error: function() {
                $("#loading").hide();
                addMessage("❌ Error en el servidor", "assistant");
            }
        });
    }

    $("#btn-send").click(sendMessage);

    $("#input-msg").keypress(function(e) {
        if (e.which === 13) {
            sendMessage();
        }
    });

});
</script>
