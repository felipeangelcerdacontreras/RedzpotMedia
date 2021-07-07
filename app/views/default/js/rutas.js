/***************** PTO DE VENTA *****************/


function productos() {
  //alert("llegas a fu");
    $.ajax({
        type: "GET",
        url: "modulos/productos/productos.php",
        success: function(data) {
            // window.location = "modulos/productos/productos.php";
            $('#divContent').html(data);
            return;
            //alert(data);
            //alert("muestra datos0");

        }
    });
}
function inmoviliario() {
    $.ajax({
        type: "GET",
        url: "modulos/inmoviliario/inmoviliario.php",
        success: function(data) {
            $('#divContent').html(data);
        }
    });
}
function herramientas() {
    $.ajax({
        type: "GET",
        url: "modulos/herramientas/herramientas.php",
        success: function(data) {
            $('#divContent').html(data);
        }
    });
}
