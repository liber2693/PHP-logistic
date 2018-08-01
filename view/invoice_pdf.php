<?php
include '../extenciones/mpdf60/mpdf.php';
//include '../models/documentoModels.php';
include '../models/invoiceModels.php';
include '../models/invoicesServicesModels.php';
include '../models/supplierInvoiceModels.php';
include '../models/shippingInvoiceModels.php';
$codigo_factura=base64_decode($_GET['invoice']);
//print_r($codigo_factura);die();
$buscarInvoice = Invoice::soloCodigo($codigo_factura);
$array = $buscarInvoice->SelectInvoiceDocket();
if ($array->num_rows==0) {
  echo "NO EXIST";
}else{
  $datos = $array->fetch_array();

  $html = '<style>

      h2{
        text-align:center;
      }
      p{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
        line-height: 18px;
        text-align:center

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

      td {
        width:20px;
        height: 20px;
        }

      #codigo{
        float: right;
      }

      #header{
        font-size: 15px;
        line-height: normal;
      }
      </style>';

  $html.='<h2>INVOICE
            <p>
              DOCKET: &nbsp;'.$datos['codigo_docket'].'<br>
              INVOICE: &nbsp;'.$datos['codigo_invoice'].'
              DATE: &nbsp;'.$datos['fecha_creacion'].'<br>
              ORIGIN: &nbsp;'.$datos['pais_origen'].', '.ucfirst($datos['lugar_origen']).'<br>
              DESTINATION: &nbsp;'.$datos['pais_destino'].', '.ucfirst($datos['lugar_destino']).'<br>
              BILL TO: &nbsp;'.ucwords($datos['cliente']).'<br>
              PIECES: &nbsp;'.$datos['pieza'].' '.ucfirst($datos['tipo_pieza']).'<br>
              WEIGHT: &nbsp;'.$datos['peso'].' '.ucfirst($datos['tipo_peso']).'<br>
              DIMENSIONS: &nbsp;'.$datos['alto'].' X '.$datos['ancho'].' X '.$datos['largo'].'  '.ucfirst($datos['tipo_dimension']).'<br>
              NOTE: &nbsp;'.ucfirst($datos['descripcion']).'<br>
            </p>
          </h2>';

  $buscarServInvoice = invoicesServices::soloCodigo($codigo_factura);
  $array1 = $buscarServInvoice->SelectServicosInvoice();

  $html.='
  <h2>Services</h2>
  <table border="1" width="100%">
    <thead>
      <tr>
        <td colspan="2px"><center><b>#</b></center></td>
        <td colspan="3px"><b><center>Description</b></center></td>
        <td colspan="2px"><b><center>US$</b></center></td>
        <td colspan="2px"><b><center>CAD$</b></center></td>
        <td colspan="8px"><b><center>Notes</b></center></td>
      </tr>
    </thead>';
  if($array1->num_rows==0){
     $html.='
    <tbody>
      <tr>
        <td colspan="5" class="text-center">No services</td>
      </tr>
    </tbody>';
  }else{
    $i=0;
    while($datos_servi=$array1->fetch_assoc()){
    $i++;
    $html.='
      <tbody>
        <tr>
          <td colspan="2px">
            <p>'.$i.'</p>
          </td>
          <td colspan="3px">
            <p>'.$datos_servi['descripcion'].'</p>
          </td>
          <td colspan="2px">
            <p>'.$datos_servi['precio_us'].'</p>
          </td>
          <td colspan="2px">
            <p>'.$datos_servi['precio_ca'].'</p>
          </td>
          <td colspan="8px">
          <p>'.$datos_servi['nota'].'</p>
          </td>
        </tr>
      </tbody>';
    }
  }
  $html.='</table> ';

  $buscarSupplierInvoice = SupplierInvoice::soloCodigo($codigo_factura);
  $array3 = $buscarSupplierInvoice->SelectProvedorInvoice();
  $html.='
  <h2>Suplier</h2>
  <table border="1" width="100%">
    <thead>
      <tr>
        <td>#</td>
        <td>Supplier</td>
        <td>US$ AMT</td>
      </tr>
    </thead>';
    if($array3->num_rows==0){
      $html.='
    <tbody>
      <tr>
        <td colspan="5" class="text-center">NO SERVICES</td>
      </tr>
    </tbody>';
    }else{
      $i=0;
      while($datos_supli=$array3->fetch_assoc()){
      $i++;
      $html.='
      <tbody>
        <tr>
          <td>
            <p>'.$i.'</p>
          </td>
          <td>
            <p>'.ucwords($datos_supli['supplier']).'</p>
          </td>
          <td>
            <p>'.$datos_servi['dinero'].'</p>
          </td>
        </tr>
      </tbody>';
      }
    }
  $html.='
  </table>';

  $buscarViaEnvio = ShippingInvoice::soloCodigo($codigo_factura);
  $array2 = $buscarViaEnvio->SelectViaEnvio();

  $html.='
  <h2>Ship via</h2>';

  if($array2->num_rows==0){
    $html.='
      <div>
        No ship via
      <div>';
  }else{
    $html.='
    <table border="1">
      <tbody>
        <tr>';
    $i=0;
    while($datos2=$array2->fetch_assoc()){
    $i++;
    $nota = ($datos2['id_envio']==6) ? ucfirst($datos2['nota']) : "" ;
      $html.='
          <td>
            <p>'.$datos2['descripcion'].'</p><b>'.$nota.'</b>
          </td>';
    }
  }
    $html.='
        </tr>
      </tbody>
    </table>';


}


//==============================================================
//==============================================================
//==============================================================

$mpdf=new mPDF('c','A4','','l',10,10,10,10,16,13);
$mpdf->SetTitle('Invoice - '.$datos['codigo_invoice']);

//$mpdf->SetDisplayMode('fullpage');

//$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
//$stylesheet = file_get_contents('mpdfstyletables.css');
//$mpdf->WriteHTML($stylesheet,1);  // The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->AddPage('L','','','','',10,10,10,10,16,13);
$mpdf->WriteHTML($html);

$mpdf->Output('Invoice - '.$datos['codigo_invoice'].'.pdf','I');
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
