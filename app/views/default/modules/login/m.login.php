<!DOCTYPE html>
<html lang="en">
<?php require_once('app/views/default/link.html'); ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrador de publicida</title>
    <link href="app/views/default/img/img.png" rel="icon" type="image/x-icon">
    <?php require_once('app/views/default/head.html'); ?>
    <?php require_once('app/views/default/script.html'); ?>
    <script src="app/views/default/js/jquery-1.11.1.min.js"></script>
    <script src="app/views/default/js/jquery-3.2.1.js"></script>
    <script src="app/views/default/js/jquery-3.2.1.min.js"></script>

  <style type="text/css">
          body{
            background-color: #f1f1f1;
          }
          .form{
            margin: 50px auto;
            padding: 25px 20px;
            background: #333;
            box-shadow: 2px 2px 4px #a5a5a5;
            border-radius: 5px;
            color: #fff;
          }
          .form h2{
            margin-top: 0px;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-radius: 10px;
          }
          .footer{
            padding: 10px;
          }
          .may {
            -webkit-border-radius: 5px 10px;  /* Safari  */
            -moz-border-radius: 5px 10px;     /* Firefox */
          }
          #may{
            padding: 25px 20px;
            background:	#FF0;
            box-shadow: 2px 2px 4px #a5a5a5;
            border-radius: 5px;
            color: #fff;
          }
        </style>

<script type="text/javascript">

    $(document).ready(function (e) {

        $("#usr, #pass").keyup(function (event) {
            var tecla = event.keyCode;
            if (tecla == 13) {
                Login();
            }
        });

        $("#btnLogin").click(function (e) {
            //Alert("boton login");
            Login();
        });

        $('#pass').keypress(function(e) {
          var s = String.fromCharCode( e.which );
          if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) {
              $("#may").show();
          }else{
            $("#may").hide();
          }
      });

    });

    function Login() {
        var jsonDatos = {
            "usr": $("#usr").val(),
            "pass": $("#pass").val(),
            "accion": "LOGIN"
        };

        $.ajax({
            data: jsonDatos,
            type: "post",
            dataType: "json",
            url: "app/views/default/modules/login/m.login_procesa.php",
            beforeSend: function () {
            },
            success: function (datos) {
                if (datos.valido === true) {
                  Alert("Bienvenido","","success");
                    document.location = datos.msg;
                }
                else
                    Alert("Error acceso",datos.msg,"error");
            }

        });
    }
    function Alert(tit,msg,iconn){
      swal({
      title:tit,
      text: msg,
      icon: iconn,
      })
    }
</script>
<body>
  <nav class="navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="collapsed navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <img src="app/views/default/img/img.png" style="float:rigth; margin-left:-2px;" width="35" height="40">
            <spam href="#" class="navbar-brand" style="color:blue">Redzpot</spam>
          </div>
        </div>
      </nav>
<div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-6 col-xs-12 col-md-offset-4 col-sm-offset-3">
            <div class="bslf form">
              <form id="frmLogin" name="frmLogin" method="post">
                <h2 class="text-center">ADMIN</h2>
                <div class="form-group">
                   <input type="text" class="form-control" name="usr" id="usr" placeholder="Usuario" required="required">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" placeholder="Contraseña" id="pass"value="1" name="pass" required="required">
                </div>
                <div class="form-group clearfix">
                  <input type="button" id="btnLogin" class="btn btn-success" name="btnLogin" value="Login"/>
                </div>
                <div class="clearfix" id="may" hidden>
                  <h4  class="pull-right" style="color:#FF0000;font-size:20px;">Bloq Mayús activado..</h4>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="navbar-default navbar-fixed-bottom">
            <div class="text-center footer">Copyright © 2019 Code Redzpot. All Right Reserved.</div>
          </div>
     </div>
</body>
