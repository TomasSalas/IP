<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>
    <!-- CSS -->
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">

    <!-- JS -->
    <script src="js/bootstrap.js"></script>
   

    <?php
    require_once("conexion.php");
    session_start();
    session_destroy();


    $query2 = "SELECT grupo_rack, nombre FROM rack";
    $resultado2 = $conn->prepare($query2);
    $resultado2->execute();
    $resultado2 = $resultado2->fetchAll(PDO::FETCH_OBJ);
    ?>
    <script>
        /* Cargar Tabla */
        function CargarTabla () {
                $j.ajax({
                    url: "administracion/registro_ip/cargar_tabla.php",
                    dataType: "json",
                        success: function(data) {
                            $j("#table_body").html(data);
                            selectedRow();
                        }
                });
        };
        function Limpiar(){
            var grupo = $js("#select_rack").val();
                $j.ajax({
                    url: "administracion/registro_ip/cargar_select.php",
                    type: "POST",
                    data: {
                        grupo: grupo
                    },
                    success: function(data) {
                        $j("#select_ip").html(data);
                    }
                });
            $j("#txt_descri").val("");
            $j("#txt_ubica").val("");
            $j("#txt_coment").val("");
        }
        $j(document).ready(function() {
            $jj('#table-reg').DataTable();
            /* Cargar Tabla */
            CargarTabla();
            /* Cargar Select al Inicio APP */
            $j("#select_rack option:selected").each(function() {
                var grupo = $js("#select_rack").val();
                $j.ajax({
                    url: "administracion/registro_ip/cargar_select.php",
                    type: "POST",
                    data: {
                        grupo: grupo
                    },
                    success: function(data) {
                        $j("#select_ip").html(data);
                    }
                });
            });
            /* Cargar Select al hacer click */
            $j("#select_rack").change(function() {
                $j("#select_rack option:selected").each(function() {
                    var grupo = $js("#select_rack").val();
                    $j.ajax({
                        url: "administracion/registro_ip/cargar_select.php",
                        type: "POST",
                        data: {
                            grupo: grupo
                        },
                        success: function(data) {
                            $j("#select_ip").html(data);
                        }
                    });
                });
            });
            /* Insert BD */
            $j(document).on("click", ".btn-guardar", function() {
                Validator();
                var select_rack = $j("#select_rack option:selected").text();
                var ip = $j("#select_ip option:selected").text();
                var descri = $j("#txt_descri").val();
                var ubicac = $j("#txt_ubica").val();
                var fecha = $j("#txt_date").val();
                var personal = $j("#txt_perso").val();
                var establecimiento = $j("#select_estable option:selected").text();
                var red = $j("#select_red option:selected").text();
                var coment = $j("#txt_coment").val();


                $j.ajax({
                    type: "POST",
                    url: "administracion/registro_ip/agregar.php",
                    data: {
                        select_rack: select_rack,
                        ip: ip,
                        descri: descri,
                        ubicac: ubicac,
                        fecha: fecha,
                        personal: personal,
                        
                        establecimiento: establecimiento,
                        red: red,
                        coment: coment,
                    },
                    success: function(data) {
                        if (data == 33) {
                            Swal.fire({
                                icon: 'warning',
                                title: "Ingreso",
                                text: "Ip ya utilizada",
                            });
                        } else if (data == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: "Ingreso",
                                text: "Registrado en la Base De Datos",
                                type: "success"
                            }).then(function() {
                                CargarTabla();
                                Limpiar();
                            });;
                        }
                    }
                });
            });
            /* Cargar Datos */
            $j(document).on("click", ".editar-btn", function() {
                document.getElementById("ip_original").style.display = "";
                document.getElementById("btn-guardar").disabled = true;
                var id_equipo = $j(this).data('id');
                $j.ajax({
                    type: "POST",
                    url: 'administracion/registro_ip/cargar.php',
                    dataType: "json",
                    data: {
                        id_equipo: id_equipo
                    },
                    success: function(data) {
                        Swal.fire(
                            'Atención!',
                            'Verificar información antes de editar!',
                            'warning',
                        )
                        var newData = JSON.parse(JSON.stringify(data));
                        $j("#select_ip option:selected").text(newData.ip_nom);
                        $j("#ip_original_txt").val(newData.ip_nom);
                        $j("#select_rack option:selected").text(newData.rack_nom);
                        $j("#txt_descri").val(newData.descripcion);
                        $j("#txt_ubica").val(newData.ubicacion);
                        $j("#txt_perso").val(newData.personal_acargo);
                        $j("#txt_coment").val(newData.comentario);
                    }
                });
            });
            /* Editar Información */
            $j(document).on("click", ".editar-btn-bd", function() {

                var select_rack = $j("#select_rack option:selected").text();
                var ip = $j("#select_ip option:selected").text();
                var descri = $j("#txt_descri").val();
                var ubicac = $j("#txt_ubica").val();
                var fecha = $j("#txt_date").val();
                var personal = $j("#txt_perso").val();
                
                var establecimiento = $j("#select_estable option:selected").text();
                var red = $j("#select_red option:selected").text();
                var coment = $j("#txt_coment").val();
                var ip_ori = $j("#ip_original_txt").val();
                var cambio = 0;

                if (ip === ip_ori) {
                    $j.ajax({
                        type: "POST",
                        url: 'administracion/registro_ip/editar.php',
                        dataType: "json",
                        data: {

                            ip_ori: ip_ori,
                            select_rack: select_rack,
                            ip: ip,
                            descri: descri,
                            ubicac: ubicac,
                            fecha: fecha,
                            personal: personal,
                            establecimiento: establecimiento,
                            red: red,
                            coment: coment,
                            cambio: cambio
                        },
                        success: function(data) {
                            if (data == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: "Editar",
                                    text: "Registrado Editado en la Base De Datos",
                                    type: "success"
                                }).then(function() {
                                    document.getElementById("btn-guardar").disabled = false;
                                    document.getElementById("ip_original").style.display = "none";
                                    CargarTabla();
                                    Limpiar();
                                });
                            } else {
                                alert("Error");
                            }
                        }
                    });



                } else {

                    Swal.fire({
                        title: 'Ip ha sido cambiada, ¿Desea Continuar?',
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        denyButtonText: `No Aceptar`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            var select_rack = $j("#select_rack option:selected").text();
                            var ip = $j("#select_ip option:selected").text();
                            var descri = $j("#txt_descri").val();
                            var ubicac = $j("#txt_ubica").val();
                            var fecha = $j("#txt_date").val();
                            var personal = $j("#txt_perso").val();
                            
                            var establecimiento = $j("#select_estable option:selected").text();
                            var red = $j("#select_red option:selected").text();
                            var coment = $j("#txt_coment").val();
                            var ip_ori = $j("#ip_original_txt").val();
                            var cambio = 1;
                            $j.ajax({
                                type: "POST",
                                url: 'administracion/registro_ip/editar.php',
                                dataType: "json",
                                data: {
                                    ip_ori: ip_ori,
                                    select_rack: select_rack,
                                    ip: ip,
                                    descri: descri,
                                    ubicac: ubicac,
                                    fecha: fecha,
                                    personal: personal,
                                    
                                    establecimiento: establecimiento,
                                    red: red,
                                    coment: coment,
                                    cambio: cambio,
                                },
                                success: function(data) {
                                    if (data == 1) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: "Editar",
                                            text: "Registrado Editado en la Base De Datos",
                                            type: "success"
                                        }).then(function() {
                                            CargarTabla();
                                            Limpiar();
                                        });
                                    } else {
                                        alert("Error");
                                    }
                                }
                            });
                        } else if (result.isDenied) {
                            Swal.fire('No se realizan cambios', '', 'info')
                        }
                    })

                }

            });
            /* Limpiar Campos */
            $j(document).on("click", ".btn-prueba", function() {
               Limpiar();
               document.getElementById("ip_original").style.display = "none";
               document.getElementById("btn-guardar").disabled = false;
            });
            
        });

        function selectedRow() {
            var index,
                table = document.getElementById("table-reg");
                
            for (var i = 0; i < table.rows.length; i++) {
                table.rows[i].onclick = function() {
                    if (typeof index !== "undefined") {
                        table.rows[index].classList.toggle("selected");
                    }
                    index = this.rowIndex;
                    this.classList.toggle("selected");
                    console.log(index);
                };

            };
        };

        function Validator() {
            var ip = $j("#select_ip").val();
            var descri = $j("#txt_descri").val();
            var ubicac = $j("#txt_ubica").val();
            var fecha = $j("#txt_date").val();
            var personal = $j("#txt_perso").val();
            var red = $j("#select_red option:selected").text();
            var coment = document.getElementsByName("txt_coment")[0].value
            if (descri == "") {
                Swal.fire(
                    'Campo Vacio!',
                    'Debe Ingresar Descripción!',
                    'warning'
                )
            } else if (ubicac == "") {
                Swal.fire(
                    'Campo Vacio!',
                    'Debe Ingresar Ubicación!',
                    'warning'
                )
            } else if (fecha == "") {
                Swal.fire(
                    'Campo Vacio!',
                    'Debe Ingresar Fecha!',
                    'warning'
                )
            } else if (personal == "") {
                Swal.fire(
                    'Campo Vacio!',
                    'Debe Ingresar Personal a Cargo!',
                    'warning'
                )
            } else if (coment == "") {
                Swal.fire(
                    'Campo Vacio!',
                    'Debe Ingresar Comentario!',
                    'warning'
                )
            };

        }
        
    </script>
    <style>
        .selected {
            background-color: #529DCB;
            color: white;
        }

        .div1 {
            float: left;
            height:800px;
            width: 80%;
        }

        .div2 {
            float: right;
            padding-right:30px;
        }
    </style>
</head>

<body>  
    <br>
    <div class="padre">
    <div class="div1 ">
        <table class="table" id="table-reg" name="table-reg">
            <thead>
                <tr>
                    <th scope="col">Ip</th>
                    <th scope="col">Nombre Rack</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Ubicación</th>
                    <th scope="col">Fecha Ingreso</th>
                    <th scope="col">Personal A Cargo</th>
                    <th scope="col">Establecimiento</th>
                    <th scope="col">Red</th>
                    <th scope="col">Comentarios</th>
                    <th scope="col">Fecha Instalación</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="table_body">
             
                
            </tbody >
        </table>
    </div>



    <div class="col-md-2 div2">
        <form id="form" method="post">
            <div class="form-group">
                <label for="exampleFormControlInput1">Rack</label>
                <select class="form-control" aria-label="Default select example" id="select_rack" name="select_rack">
                    <?php
                    foreach ($resultado2 as $row) {
                        printf("<option value='$row->grupo_rack'>$row->nombre</option>");
                    };
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Ip</label>
                <select class="form-control" aria-label="Default select example" id="select_ip" name="select_ip">
                </select>
            </div>
            <div class="form-group" style="display: none" id="ip_original">
                <label for="exampleFormControlInput1">Ip Original</label>
                <input type="text" class="form-control" id="ip_original_txt" name="ip_original_txt" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Descripcion</label>
                <input type="text" class="form-control" id="txt_descri" name="txt_descri" placeholder="Descripción">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Ubicación</label>
                <input type="text" class="form-control" id="txt_ubica" name="txt_ubica" placeholder="Ubicación">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Fecha Instalación</label>
                <input type="date" class="form-control" id="txt_date" name="txt_date" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Personal A Cargo</label>
                <input type="text" class="form-control" id="txt_perso" name="txt_perso" disabled placeholder="Personal a Cargo" value="<?php echo $_SESSION['sgh_usuario'] ?>">
            </div>
           
            <div class="form-group">
                <label for="exampleFormControlInput1">Establecimiento</label>
                <select class="form-control" aria-label="Default select example" id="select_estable">
                    <option value="1">HSMQ</option>
                    <option value="2">HBPQ</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Red</label>
                <select class="form-control" aria-label="Default select example" name="select_red" id="select_red">
                    <option value="1">Administrativa</option>
                    <option value="2">Complementaria</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Comentarios</label>
                <textarea class="form-control" id="txt_coment" name="txt_coment" rows="3"></textarea>
            </div>
            <br>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-guardar " id="btn-guardar">Guardar Información</button>
            </div>
            <br>
            <div class="form-group">
                <button type="button" class="btn btn-success editar-btn-bd " id="editar-btn-bd">Editar Información</button>
            </div>
            <br>
            <div class="form-group">
                <button type="button" class="btn btn-warning btn-prueba " id="btn-prueba">Limpiar Campos</button>
            </div>
        </form>
    </div>
    </div>
</body>

</html>