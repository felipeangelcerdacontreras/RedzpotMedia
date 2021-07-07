<script type="text/javascript">
    $(document).ready(function (e) {
        $("#btnBuscar").button().click(function (e) {
            Listado();
        });      

        $("#txtNombre").keyup(function (event) {
            if (event.which == 13) {
                Listado();
            }
        });
        
        Listado();
    });

    function Listado() {        
        $.ajax({
            data: "usr_nombre=" + $("#txtNombre").val(),
            type: "POST",
            url: "app/views/default/modules/usuarios/m.usuarios.listado.php",
            beforeSend: function () {
                $("#divListado").html('<center><img src="app/views/default/images/loading.gif" border="0"/><br />Leyendo información de la Base de Datos, espere un momento por favor...</center>');
            },
            success: function (datos) {
                $("#divListado").html(datos)
            }
        });
    }

</script>
<table class="MiTabla" style="width: 500px;">
	<tr>
		<th style="width: 100px;">Nombre:</th>
		<td><input type="text" id="txtNombre" name="txtNombre" style="width: 200px;" /> <input type="button" id="btnBuscar" name="btnBuscar" value="Buscar" /></td>
	</tr>
</table>
<div id="divListado"></div>