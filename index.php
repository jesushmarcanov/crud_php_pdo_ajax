<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    <link href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">

    
    <title>CRUD con PHP, PDO, Ajax y Datatables</title>
  </head>
  <body>
    <div class="container fondo">
        <h1 class="text-center">CRUD con PHP, PDO, Ajax y Datatables</h1>

        <div class="row">
            <div class="col-2 offset-10">
                <div class="text-center">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary w-100" 
                    data-bs-toggle="modal" data-bs-target="#modalUsuario" id="botonCrear">
                    <i class="bi bi-plus-circle-fill"> Crear</i>
                    </button>
                </div>
            </div>
        </div>
        <br />
        <br />

        <div class="table-responsive">
            <table id="datos_usuario" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Imagen</th>
                        <th>Fecha</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Ventana Modal -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ingreso de Usuarios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                    <form method="POST" id="formulario" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-body">
                                <label for="nombre">Ingrese el Nombre</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control">
                                <br />
                            
                                <label for="telefono">Ingrese los Apellidos</label>
                                    <input type="text" name="apellidos" id="apellidos" class="form-control">
                                <br />
                            
                                <label for="telefono">Ingrese el Teléfono</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control">
                                <br />
                        
                                <label for="email">Ingrese el Email</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                <br />
                                <label for="imagen">Seleccione una imagen</label>
                                    <input type="file" name="imagen_usuario" id="imagen_usuario" class="form-control">
                                    <span id="imagen-subida"></span>
                                <br />
                            </div><!-- /.modal-body -->
                        </div>
                    
                        <div class="modal-footer">
                            <input type="hidden" name="id_usuario" id="id_usuario">
                            <input type="hidden" name="operacion" id="operacion">
                            <input type="submit" name="action" id="action" class="btn btn-success" value="Crear">
                            
                        </div>
                    </form>
                    
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" ></script>
   

    <script>
        $(document).ready(function(){
            $('#botonCrear').click(function(){
                $('#formulario')[0].reset();
                $('#modal-title').text("Crear Usuario");
                $('#action').val("Crear");
                $('#operacion').val("Crear");
                $('#imagen_subida').html("");
            });

            var dataTable = $('#datos_usuario').DataTable({
                "processing":true,
                "serverSide":true,
                "order": [],
                "ajax":{
                    url: "obtener_registros.php",
                    type: "POST"
                },
                "columnsDefs":[
                    {
                        "targets":[0, 3, 4],
                        "orderable":false,
                    },
                ]
            });
        
            //Aqui va el codigo de insercion
            $(document).on('submit', '#formulario', function(event){
                event.preventDefault();
                var nombre = $("#nombre").val();
                var apellidos = $("#apellidos").val();
                var telefono = $("#telefono").val();
                var email = $("#email").val();
                var extension = $("#imagen_usuario").val().split('.').pop().toLowerCase();
                
                if(extension != ''){
                    if(jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1){
                        alert("Formato de Imagen inválido");
                        $('#imagen_usuario').val('');
                        return false;
                    }
                }

                if(nombre != '' && apellidos != '' && email != ''){
                    $.ajax({
                        url: "crear.php",
                        method: "POST",
                        data:new FormData(this),
                        contentType:false,
                        processData:false,
                        success:function(data){
                            alert(data);
                            $('#formulario')[0].reset();
                            $('#modalUsuario').modal('hide');
                            dataTable.ajax.reload();
                        }
                    });
                }else {
                    alert("Algunos campos son obligatorios");
                }  
            });

            //Aqui va el codigo de edicion
            $(document).on('click', '.editar', function(){		
                var id_usuario = $(this).attr("id");		
                $.ajax({
                    url:"obtener_registro.php",
                    method:"POST",
                    data:{id_usuario:id_usuario},
                    dataType:"json",
                    success:function(data)
                        {
                            //console.log(data);				
                            $('#modalUsuario').modal('show');
                            $('#nombre').val(data.nombre);
                            $('#apellidos').val(data.apellidos);
                            $('#telefono').val(data.telefono);
                            $('#email').val(data.email);
                            $('.modal-title').text("Editar Usuario");
                            $('#id_usuario').val(id_usuario);
                            $('#imagen_subida').html(data.imagen_usuario);
                            $('#action').val("Editar");
                            $('#operacion').val("Editar");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        }
                    })
	        });

        });

        
    </script>
    
  </body>
</html>