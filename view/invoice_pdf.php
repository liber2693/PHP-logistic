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
  //echo "<pre>";print_r($datos);die;

  $html = '<style>

      h3{
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

      td {
        height: 30px;
        }

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
      if (!empty($datos['fecha'])) {
        $fecha = explode('-', $datos['fecha']);
        $fecha_formateada = $fecha[1] .'-' .$fecha[2] .'-' .$fecha[0];
        
      }
      else{
        $fecha_formateada = "Not registered";
      }
      $varCode = ($datos['codigo_usuario']) ? $datos['codigo_usuario'] : "Not registered" ;
      $html.='<br>
      <h3>INVOICE</h3>
      <table border="1" width="100%">
        <thead>
          <tr>
            <td colspan="2px" width="20%"><center><b>DOCKET #: &nbsp;'.$datos['codigo_docket'].'</b></center></td>
            <td colspan="2px" width="20%"><b><center>INVOICE #: &nbsp;'.$varCode.'</b></center></td>
            <td colspan="2px" width="25%"><b><center>DATE: &nbsp;'.$fecha_formateada.'</b></center></td>
            <td colspan="2px" width="35%"><b><center>BILL TO: &nbsp;'.ucwords($datos['cliente']).'</b></center></td>
          </tr>
        </thead>
      </table>

      <table border="1" width="100%">
        <thead>
          <tr>
            <td colspan="2px" width="30%"><center><b>ORIGIN: &nbsp;'.$datos['pais_origen'].', '.ucfirst($datos['lugar_origen']).'</b></center></td>
            <td colspan="2px" width="30%"><b><center>DESTINATION: &nbsp;'.$datos['pais_destino'].', '.ucfirst($datos['lugar_destino']).'</b></center></td>
            <td colspan="2px" width="20%"><b><center>PIECES: &nbsp;'.$datos['pieza'].' '.ucfirst($datos['tipo_pieza']).'</b></center></td>
            <td colspan="2px" width="20%"><b><center>WEIGHT: &nbsp;'.$datos['peso'].' '.ucfirst($datos['tipo_peso']).'</b></center></td>
          </tr>
        </thead>
      </table>

      <table border="1" width="100%">
        <thead>
          <tr>
            <td colspan="1px" width="40%"><center><b>DIMENSIONS: &nbsp;'.$datos['alto'].' X '.$datos['ancho'].' X '.$datos['largo'].'  '.ucfirst($datos['tipo_dimension']).'</b></center></td>
            <td colspan="7px" width="60%"><b><center>NOTE: &nbsp;'.ucfirst($datos['descripcion']).'</b></center></td>
          </tr>
        </thead>
      </table>';
        //print_r($html);die;
//        width:60px;

  /*$html.='<h2>INVOICE
            <p>
              DOCKET: &nbsp;'.$datos['codigo_docket'].'<br>
              INVOICE: &nbsp;'.$datos['codigo_invoice'].'<br>
              DATE: &nbsp;'.$datos['fecha_creacion'].'<br>
              ORIGIN: &nbsp;'.$datos['pais_origen'].', '.ucfirst($datos['lugar_origen']).'<br>
              DESTINATION: &nbsp;'.$datos['pais_destino'].', '.ucfirst($datos['lugar_destino']).'<br>
              BILL TO: &nbsp;'.ucwords($datos['cliente']).'<br>
              PIECES: &nbsp;'.$datos['pieza'].' '.ucfirst($datos['tipo_pieza']).'<br>
              WEIGHT: &nbsp;'.$datos['peso'].' '.ucfirst($datos['tipo_peso']).'<br>
              DIMENSIONS: &nbsp;'.$datos['alto'].' X '.$datos['ancho'].' X '.$datos['largo'].'  '.ucfirst($datos['tipo_dimension']).'<br>
              NOTES: &nbsp;'.ucfirst($datos['descripcion']).'<br>
            </p>
          </h2>';
*/
  $buscarServInvoice = invoicesServices::soloCodigo($codigo_factura);
  $array1 = $buscarServInvoice->SelectServicosInvoice();

  //echo "<pre>";print_r($array1);die;

  $html.='
  <h3>Services</h3>
  <table border="1" width="100%">
    <thead>
      <tr>
        <td width="10%"><center><b>#</b></center></td>
        <td width="20%"><b><center>Description</b></center></td>
        <td width="20%"><b><center>US$</b></center></td>
        <td width="20%"><b><center>CAD$</b></center></td>
        <td width="30%"><b><center>Notes</b></center></td>
      </tr>
    </thead>';
  if($array1->num_rows==0){
     $html.='
    <tbody>
      <tr>
        <td colspan="5" width="100%"><center>No services</center></td>
      </tr>
    </tbody>';
  }else{
    $i=0;
    while($datos_servi=$array1->fetch_assoc()){
    $i++;
    $html.='
      <tbody>
        <tr>
          <td width="10%"><center>'.$i.'</center>
          </td>
          <td width="25%"><center>'.$datos_servi['descripcion'].'</center>
          </td>
          <td width="20%"><center>'.$datos_servi['precio_us'].'</center>
          </td>
          <td width="20%"><center>'.$datos_servi['precio_ca'].'</center>
          </td>
          <td width="25%"><center>'.$datos_servi['nota'].'</center>
          </td>
        </tr>
      </tbody>';
    }
  }
  $html.='</table> ';

  $buscarSupplierInvoice = SupplierInvoice::soloCodigo($codigo_factura);
  $array3 = $buscarSupplierInvoice->SelectProvedorInvoice();
  $html.='
  <h3>Supplier</h3>
  <table border="1" width="100%">
    <thead>
      <tr>
        <td width="10%"><center><b>#</b></center></td>
        <td width="30%"><center><b>Supplier</b></center></td>
        <td width="20%"><center><b>Cost US$</b></center></td>
      </tr>
    </thead>';
    if($array3->num_rows==0){
      $html.='
    <tbody>
      <tr>
        <td colspan="3" width="100%"><center>NO SERVICES</center></td>
      </tr>
    </tbody>';
    }else{
      $i=0;
      while($datos_supli=$array3->fetch_assoc()){
      $i++;
      $html.='
      <tbody>
        <tr>
          <td><center>'.$i.'</center></td>
          <td><center>'.ucwords($datos_supli['supplier']).'</center></td>
          <td><center>'.$datos_supli['dinero'].'</center></td>
        </tr>
      </tbody>';
      }
    }
  $html.='
  </table>';

  $buscarViaEnvio = ShippingInvoice::soloCodigo($codigo_factura);
  $array2 = $buscarViaEnvio->SelectViaEnvio();

  $html.='
  <h3>Ship Via</h3>';

  if($array2->num_rows==0){
    $html.='
      <div>
        <center>No ship via</center>
      <div>';
  }else{
    $html.='
    <table border="1" width="40%" style="margin-left:auto; margin-right: auto">
      <tbody>
        <tr>';
    $i=0;
    while($datos2=$array2->fetch_assoc()){
    $i++;
    $nota = ($datos2['id_envio']==6) ? ": ".ucfirst($datos2['nota']) : "" ;
      $html.='
          <td style="text-align:center">
            <b><center>'.$datos2['descripcion'] .$nota.'</b>
          </td>';
    }
  }
    $html.='
        </tr>
      </tbody>
    </table>';


}

/* MOSTRAR LA FECHA VOLTEADA*/
/*$fecha = explode('-', $datos['fecha_creacion']);
$reversa = array_reverse($fecha);
$fecha_bien = implode($reversa, '-');
echo "<pre>";print_r($fecha_bien);die;
*/

$code = explode('-', $datos['codigo_invoice']);
$mpdf=new mPDF('c','A4','','l',10,10,10,10,16,13);
$mpdf->SetTitle('Invoice-'.$code[1] .'-' .$datos['codigo_usuario']);

//$mpdf->SetDisplayMode('fullpage');

//$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
//$stylesheet = file_get_contents('mpdfstyletables.css');
//$mpdf->WriteHTML($stylesheet,1);  // The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->SetHTMLHeader('<div><img src="../theme/img/logonetex.png" style="margin-left:1%;margin-top:-45px;width:160px;height:90px;"></div>');
$mpdf->SetWatermarkImage("../theme/img/logonetex-bspline.png");
$mpdf->showWatermarkImage = true;
$mpdf->AddPage('L','','','','',10,10,10,10,16,13);
$mpdf->WriteHTML($html);

$mpdf->Output('Invoice-'.$code[1] .'-' .$datos['codigo_usuario'] .'.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================
     /* //echo"<pre>"; print_r($html);die();

      //$mpdf=new mPDF('win-1252','LEGAL','','',15,15,35,25,5,7);*/
      //$mpdf=new mPDF('c', 'LETTER','','',30,30,30,30);
      //

      /*

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
