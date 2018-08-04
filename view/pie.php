<!-- javascripts -->
<script src="../theme/js/jquery.js"></script>
<script src="../theme/js/jquery-ui-1.10.4.min.js"></script>
<script src="../theme/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="../theme/js/jquery-ui-1.9.2.custom.min.js"></script>
<!-- bootstrap -->
<script src="../theme/js/bootstrap.min.js"></script>
<!-- nice scroll -->
<script src="../theme/js/jquery.scrollTo.min.js"></script>
<script src="../theme/js/jquery.nicescroll.js" type="text/javascript"></script>
<!-- charts scripts -->
<script src="../theme/assets/jquery-knob/js/jquery.knob.js"></script>
<script src="../theme/js/jquery.sparkline.js" type="text/javascript"></script>
<script src="../theme/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="../theme/js/owl.carousel.js"></script>
<!-- jQuery full calendar -->
<script src="../theme/js/fullcalendar.min.js"></script>
  <!-- Full Google Calendar - Calendar -->
  <script src="../theme/assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
  <!--script for this page only-->
  <script src="../theme/js/calendar-custom.js"></script>
  <script src="../theme/js/jquery.rateit.min.js"></script>
  <!-- custom select -->
  <script src="../theme/js/jquery.customSelect.min.js"></script>
  <script src="../theme/assets/chart-master/Chart.js"></script>

  <!--custome script for all page-->
  <script src="../theme/js/scripts.js"></script>
  <!-- custom script for this page-->
  <script src="../theme/js/sparkline-chart.js"></script>
  <script src="../theme/js/easy-pie-chart.js"></script>
  <script src="../theme/js/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="../theme/js/jquery-jvectormap-world-mill-en.js"></script>
  <script src="../theme/js/xcharts.min.js"></script>
  <script src="../theme/js/jquery.autosize.min.js"></script>
  <script src="../theme/js/jquery.placeholder.min.js"></script>
  <script src="../theme/js/gdp-data.js"></script>
  <script src="../theme/js/morris.min.js"></script>
  <script src="../theme/js/sparklines.js"></script>
  <script src="../theme/js/charts.js"></script>
  <script src="../theme/js/jquery.slimscroll.min.js"></script>
  <script src="../theme/js/jquery-ui-1.9.2.custom.min.js"></script>
  <script type="text/javascript" src="../theme/js/ga.js"></script>
  <script src="../theme/js/bootstrap-switch.js"></script>
  <script src="../theme/js/jquery.tagsinput.js"></script>
  <script src="../theme/js/jquery.hotkeys.js"></script>
  <script src="../theme/js/bootstrap-wysiwyg.js"></script>
  <script src="../theme/js/bootstrap-wysiwyg-custom.js"></script>
  <script src="../theme/js/moment.js"></script>
  <script src="../theme/js/bootstrap-colorpicker.js"></script>
  <script src="../theme/js/daterangepicker.js"></script>
  <script src="../theme/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="../theme/assets/ckeditor/ckeditor.js"></script>
  <!--<script src="../theme/js/form-component.js"></script>-->
  <script type="text/javascript" src="../js/funciones.js"></script>

  


  <script>
  $('#shipper').val("");
  $('#date').val("");
  $('#origin').val("");
  $('#destination').val("");
  $('#supplier').val("");
  $('#pieces').val("");
  $('#weight').val("");
  $('#selectpieces').val("");
  $('#selectweight').val("");
  $('#height').val("");
  $('#width').val("");
  $('#long').val("");
  $('#selectweight').val("");
  </script>
  <script>
  $('#shipper1').val("");
  $('#date1').val("");
  $('#origin1').val("");
  $('#destination1').val("");
  $('#supplier1').val("");
  $('#pieces1').val("");
  $('#weight1').val("");
  $('#selectpieces1').val("");
  $('#selectweight1').val("");
  $('#height1').val("");
  $('#width1').val("");
  $('#long1').val("");
  $('#selectweight1').val("");
  </script>

  <script>
  $(function () {
      $.datepicker.setDefaults($.datepicker.regional["es"]);
      $(".fecha").datepicker({
          dateFormat: 'dd-mm-yy',
          firstDay: 1
      });
   });
   </script>
  <script>
    //knob
    $(function() {
      $(".knob").knob({
        'draw': function() {
          $(this.i).val(this.cv + '%')
        }
      })
    });

    //carousel
    $(document).ready(function() {
      $("#owl-slider").owlCarousel({
        navigation: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true

      });
    });

    //custom select box

    $(function() {
      $('select.styled').customSelect();
    });

    /* ---------- Map ---------- */
    $(function() {
      $('#map').vectorMap({
        map: 'world_mill_en',
        series: {
          regions: [{
            values: gdpData,
            scale: ['#000', '#000'],
            normalizeFunction: 'polynomial'
          }]
        },
        backgroundColor: '#eef3f7',
        onLabelShow: function(e, el, code) {
          el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
        }
      });
    });
  </script>

  <script>
      /* global $, _ */

      $('body').ready(function () {

          /*
              Este .on nos va a server para cachar el evento submit, cuando haces click en un boton del tipo "submit" y quiere enviar el formulario, lo hago de esta forma por si tienes un required en un input o algun type="email" de HTML5 se haga la validacion antes de enviar los datos. De igual forma es buena practica hacer una validacion en el back antes de hacer cualquier cosa.
          */
          $('#myForm').on('submit', function () { // Nos suscribimos al evento "submit" de nuestro formulario el cual se lanzara al hacer click en un boton del tipo submit
              var dataToSend = $(this).serialize(); //Aqui ya tenemos el contexto del formulario por eso usamos $(this)

              // Despues hacemos el $.ajax
              $.ajax({
                  method: 'POST', // Metodo a utilizar POST, GET, etc...
                  url: 'myPage.php', // URL de la pagina que recibira la petición
                  data: dataToSend, // Aqui van los datos a enviar, en este caso serializamos los campos del formulario y los asinamos a esta variable por eso solo ponemos esta variable
                  success: function (data) {
                      console.log(data); // Este callback que se lanzara si la url 'myPage.php' responde como un status 200: OK, y lo que imprimas en php lo cachara en la variable data.
                  },
                  error: function (data) {
                      console.log(data); // Este callback que se lanzara si la url 'myPage.php' responde con status de error, e.g. 400, 404, 500, etc...
                  }
              });

              return false; // Este return es para que no se lanze el evento submit al navegador y no brinque de pagina, si no que se queda esperando la respuesta de nuestra llamada ajax.
          });

      });
  </script>
