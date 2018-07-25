<?php
include '../extenciones/mpdf60/mpdf.php';
include '../models/invoiceModels.php';
$codigo_factura=base64_decode($_GET['invoice']);
//print_r($codigo_factura);die();
$buscarInvoice = Invoice::soloCodigo($codigo_factura);
$array = $buscarInvoice->SelectInvoiceDocket();
if ($array->num_rows==0) {
  echo "NO EXIST";
}else{
  $datos = $array->fetch_array();
  
  $html = '<style>

      p{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        line-height: 18px;
      }

      table th{color: #ffffff; background-color: #3692cd;}
      .table-striped > tbody > tr > td{border:2px solid #ffffff; background-color: #d1f1fc;}

      .di{
        text-align:center
      }

      #menu p {
        margin: 1px 0;
        font-family: Arial, Helvetica, sans-serif;
      }

      #codigo{
        float: right;
      }

      #header{
        font-size: 15px;
        line-height: normal;
      }
      </style>';
  
  $html.='<h3>
            <p>
              Docket: &nbsp;'.$datos['codigo_docket'].'<br>
              Invoice: &nbsp;'.$datos['codigo_invoice'].'<br>
              Date: &nbsp;'.$datos['fecha_creacion'].'<br>
              Origin: &nbsp;'.$datos['pais_origen'].', '.$datos['lugar_origen'].'<br>
              Destino: &nbsp;'.$datos['pais_destino'].', '.$datos['lugar_destino'].'<br>
              SUB BILL: &nbsp;'.$datos['cliente'].'<br>
            </p>
          </h3>';

}
/*$html='<style>

      p{
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        line-height: 18px;
      }

      table th{color: #ffffff; background-color: #3692cd;}
      .table-striped > tbody > tr > td{border:2px solid #ffffff; background-color: #d1f1fc;}

      .di{
        text-align:center
      }

      #menu p {
        margin: 1px 0;
        font-family: Arial, Helvetica, sans-serif;
      }

      #codigo{
        float: right;
      }

      #header{
        font-size: 15px;
        line-height: normal;
      }
      </style>

                  <div id="menu">
                        <h4 id="header"><p id="rep" >REPÚBLICA BOLIVARIANA DE VENEZUELA <br>
                        SUPERINTENDENCIA NACIONAL PARA LA DEFENSA DE LOS DERECHOS SOCIO ECONÓMICOS (SUNDDE)<br><br>
                       FECHA: <strong></strong></p></h4>
                        ';
           $html.= '
                <h3><p>ACTA DE INSTRUCCIÓN DEL INICIO DEL PROCEDIMIENTO DE DETERMINACION DE CUMPLIMIENTO</p></h3></div>
                
                <div>
                    <p style="text-align: justify;">Tal mandato recaerá en la Intendencia de Protección de los Derechos Socioeconómicos adscrita a la Superintendencia Nacional Para La Defensa De Los Derechos
                    Socioeconómicos, quien queda expresamente facultada para la realización de todas las actuaciones materiales que se correspondan con tal procedimiento así como, para levantar la verificación de la
                    conformidad de las actuaciones del sujeto de aplicación de conformidad con el artículo 68, o, la imposición de las sanciones por el incumplimiento del Decreto, con Rango, Valor y Fuerza de Ley
                    Orgánica de Precios Justos. Así como adoptar y ejecutar las medidas preventivas a que hubiese lugar si los extremos del artículo 70 del texto legal se presentasen. Este documento se levanta en dos
                    originales, uno de los cuales reposará en el expediente y el otro será entregado al representante o responsable del sujeto de aplicación a los fines consiguientes.</p>
                    <p style="text-align: justify;">Se ordena NOTIFICAR al sujeto de aplicación por vía electrónica de conformidad con la Ley sobre Mensajes de Datos y Firmas Electrónicas Es todo.</p>
                </div>';*/
      
//==============================================================
//==============================================================
//==============================================================

$mpdf=new mPDF('c','A4','','',10,10,10,10,16,13); 
$mpdf->SetTitle('Invoice - '.$datos['codigo_docket']);

//$mpdf->SetDisplayMode('fullpage');

//$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
//$stylesheet = file_get_contents('mpdfstyletables.css');
//$mpdf->WriteHTML($stylesheet,1);  // The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html);

$mpdf->Output('mpdf.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================
     /* //echo"<pre>"; print_r($html);die();

      //$mpdf=new mPDF('win-1252','LEGAL','','',15,15,35,25,5,7);*/
      //$mpdf=new mPDF('c', 'LETTER','','',30,30,30,30);
      //

      /*$mpdf->SetHTMLHeader('<div><img src="images/ultimo_cintillo.png" width="100%", height="55px"></div>');
      $mpdf->SetWatermarkImage("images/fondo.png");
      $mpdf->showWatermarkImage = true;
      //$mpdf->SetWatermarkText('No válido');
      //$mpdf->showWatermarkText = true;
      //$mpdf->SetHTMLFooter(' <div  id="footer" ><img src="images/footer.png" width="100%"></div>');
      $mpdf->SetHTMLFooter(
       '<div id="footer">
<br><br><br>
            <div>
            <img src="images/FirmaSuper.png" style="margin-left:40%;margin-bottom:-45px;width:35%;height:20%;">
                <p><b>WILLIAN ANTONIO CONTRERAS <br>
                Superintendente Nacional para la Defensa de los Derechos Socioeconómicos</b></p>
                <p>Decreto N° 2.186, publicado en Gaceta Oficial de la República Bolivariana de Venezuela N° 40.830, de fecha 18 de enero de 2016.</p>
            </div>
            <div>
                <blockquote> <p style="text-align: justify; margin: 0px 0;font-size:8px;">Los sujetos de aplicación a través del número telefónico (0212) 808.94.36 podrán:<br>
                1. Corroborar la identidad del fiscal autorizado para la práctica de la inspección y/o fiscalización;<br>
                2. Comunicarse y obtener información adicional en relación al presente procedimiento.</p>
                </blockquote>
            </div>
            <img src="images/footer.png" width="100%">
        </div>'
      );


  //$mpdf = new mPDF('win-1252', 'A4-L', 13, 15, 25, 12, 5, 7);
  $mpdf->WriteHTML($html);
  $mpdf->Output($file,'D');

  


*/
?>
