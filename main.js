$j(document).ready(function () {
  /* Cargar Select al Inicio APP */
  $j("#select_rack option:selected").each(function () {
    var grupo = $j("#select_rack").val();
    $j.ajax({
      url: "administracion/registro_ip/cargar_select.php",
      type: "POST",
      data: {
        grupo: grupo
      },
      success: function (data) {
        $j("#select_ip").html(data);
      }
    });
  });

  /* Cargar Select al hacer click */
  $j("#select_rack").change(function () {
    $j("#select_rack option:selected").each(function () {
      var grupo = $js("#select_rack").val();
      $j.ajax({
        url: "administracion/registro_ip/cargar_select.php",
        type: "POST",
        data: {
          grupo: grupo
        },
        success: function (data) {
          $j("#select_ip").html(data);
        }
      });
    });
  });

  $j(document).on("click",".btn-prueba", function() {
   
    alert('select_rack');
});
});