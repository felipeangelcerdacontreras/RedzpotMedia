$('document').ready(function(){
cargargrid();
$('#btnLogin').click(function(e){

  if($('#usuario').val() == ""){
    alert("Introduce un usuario");
    return false;
  }
  else {
    var usuario = $('#usuario').val();
  }
  if ($('#clave').val() == "" ) {
    alert("Introduce una contraseña");
    return false;
  }
  else {
    var clave = $('#clave').val();
  }
      jQuery.get("php/login.php", {
        usuario:usuario,
        clave:clave

      },function (data, textStatus) {
        if (data == 2) {
          alert("usuario o claveseña incorrecta");
        }
        else if(data == 1){
            alert("Bienvenido "+ usuario );
        }
        else if(data == 3)
        {
          alert("ERROR CONEXION");
        }


    });
});
    $('#Insertar').click(function(e){

      if($('#nombre').val() == ""){
        alert("Introduce el nombre");
        return false;
      }
      else {
        var nombre = $('#nombre').val();
      }
      if ($('#apellido').val() == "" ) {
        alert("Introduce apellido");
        return false;
      }
      else {
        var apellido = $('#apellido').val();
      }
      if($('#alias').val() == "") {
          alert("Introduce un alias");
          return false;
      }
      else {
        var alias = $('#alias').val();
      }
      if($('#poder').val() == "") {
          alert("Introduce un poder");
          return false;
      }
      else {
        var poder = $('#poder').val();
      }
          jQuery.get("php/agrega.php", {
            nombre,
            apellido,
            alias,
            poder

          },function (data, textStatus) {
            if (data == 1) {
              $('#res').html("ERROR CONEXION");
              $('#res').css('color','red');
            }
            else if(data == 2){
                $('#res').html("DATOS AGREGADOS");
                $('#res').css('color','green');
                $('#grid').bootgrid('reload');
              }
              else if (data == 3) {
                  $('#res').html("ERROR QUERY");
                  $('#res').css('color','red');
                }
                else if(data == 4){
                    $('#res').html("ERROR DE METODO");
                    $('#res').css('color','red');
                  }
        });
    });
    //BOTON ACTUALIZAR
    $('#Actualizar').click(function(e){

      if($('#id').val() == ""){
        alert("Introduce el id a actualizar");
        return false;
      }
      else {
        var id = $('#id').val();
      }
      if($('#nombre').val() == ""){
        alert("Introduce el nombre");
        return false;
      }
      else {
        var nombre = $('#nombre').val();
      }
      if ($('#apellido').val() == "" ) {
        alert("Introduce apellido");
        return false;
      }
      else {
        var apellido = $('#apellido').val();
      }
      if($('#alias').val() == "") {
          alert("Introduce un alias");
          return false;
      }
      else {
        var alias = $('#alias').val();
      }
      if($('#poder').val() == "") {
          alert("Introduce un poder");
          return false;
      }
      else {
        var poder = $('#poder').val();
      }
          jQuery.get("php/actualiza.php", {
            id:id,
            nombre:nombre,
            apellido:apellido,
            alias:alias,
            poder:poder

          },function (data, textStatus) {
            if (data == 1) {
              $('#res').html("ERROR CONEXION");
              $('#res').css('color','red');
            }
            else if(data == 2){
                $('#res').html("DATOS ACTUALIZADOS");
                $('#res').css('color','green');
                $('#grid').bootgrid('reload');
              }
              else if (data == 3) {
                  $('#res').html("ERROR QUERY");
                  $('#res').css('color','red');
                }
                else if(data == 4){
                    $('#res').html("ERROR DE METODO");
                    $('#res').css('color','red');
                  }
        });
    });
});
       function cargargrid(){
       var grid = $("#grid").bootgrid({
           ajax: true,
           post: function ()
           {
               return {
                   id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
               };
           },
           url: "../../php/select13.php",
           formatters: {
               "commands": function(column, row)
               {
                   return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-pencil\"></span></button> " +
                       "<button type=\"button\" class=\"btn btn-xs btn btn-danger command-delete\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-trash-o\"></span></button>";
               }
           }
       }).on("loaded.rs.jquery.bootgrid", function()
       {
           grid.find(".command-edit").on("click", function(e)
           {
               var id = $(this).data("row-id")
               actualizar(id);
           }).end().find(".command-delete").on("click", function(e)
           {
             var id = $(this).data("row-id")
              borrar(id);
           });
       });
   }

  function borrar(id){

      if(confirm("Desea eliminar "+id)){
        jQuery.get("php/eliminar.php",{
          id:id
        },function(data, textStatus){
          $('#grid').bootgrid('reload');
      });
    }
  }
