<?php
include '../extenciones/mpdf60/mpdf.php';
include '../models/documentoModels.php';
//include '../models/invoiceModels.php';
include '../models/invoicesServicesModels.php';
include '../models/supplierInvoiceModels.php';
include '../models/shippingInvoiceModels.php';

$mpdf=new mPDF('c','A4','','l',10,10,10,10,16,13);

$codigo_documento=base64_decode($_GET['docket']);
$buscardocumento = Docket::soloCodigo($codigo_documento);
$array_d = $buscardocumento->selectDocket();
if ($array_d->num_rows==0) {
  echo "NO EXIST";
}else{
  $datos_d = $array_d->fetch_array();
  $fecha1 = explode('-', $datos_d['fecha']);
  $fecha_formateada1 = $fecha1[1] .'-' .$fecha1[2] .'-' .$fecha1[0];
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

  $html.='<img src="../theme/img/logonetex.png" border="1" width="160" height="90">

        <h3>DOCKET '.$datos_d['codigo'].'</h3>
        <table border="1" width="100%">
          <thead>
            <tr>
            <td colspan="2px" width="33%"><center><b> SHIPPER: &nbsp;'.ucwords($datos_d['shipper']).'</b></center></td>
            <td colspan="2px" width="33%"><center><b> CC#: &nbsp;'.ucwords($datos_d['cc']).'</b></center></td>
            <td colspan="2px" width="33%"><center><b>DOCKET #: &nbsp;'.$datos_d['codigo'].'</b></center></td>
            </tr>
          </thead>
        </table>

        <table border="1" width="100%">
          <thead>
            <tr>
              <td colspan="2px" width="33%"><center><b>ORIGIN: &nbsp;'.$datos_d['origen'].', '.ucfirst($datos_d['lugar_origen']).'</b></center></td>
              <td colspan="2px" width="33%"><b><center>DESTINATION: &nbsp;'.$datos_d['destino'].', '.ucfirst($datos_d['lugar_destino']).'</b></center></td>
              <td colspan="2px" width="33%"><b><center>DATE: &nbsp;'.$fecha_formateada1.'</b></center></td>
            </tr>
          </thead>
        </table>

        <table border="1" width="100%">
          <thead>
            <tr>
            <td colspan="2px" width="100%"><b><center>PIECES / WEIGHT / DIMENSIONS: &nbsp;
            '.$datos_d['pieza'].' '.ucfirst($datos_d['tipo_pieza']).' &nbsp;&nbsp;&nbsp;
            '.$datos_d['peso'].' '.ucfirst($datos_d['tipo_peso']).' &nbsp;&nbsp;&nbsp;
            '.$datos_d['alto'].' X '.$datos_d['ancho'].' X '.$datos_d['largo'].'  '.ucfirst($datos_d['tipo_dimension']).'</b></center></td>
            </tr>
          </thead>
        </table>

        <table border="1" width="100%">
          <thead>
            <tr>
            <td colspan="7px" width="60%"><b><center>NOTE: &nbsp;'.ucfirst($datos_d['descripcion']).'</b></center></td>
            </tr>
          </thead>
        </table>';

  $mpdf->AddPage('L','','','','',10,10,10,10,16,13);
  $mpdf->WriteHTML($html);
  /***********Imprimir los invoice de este documento****************/

  $buscarInvoice = Docket::soloCodigo($codigo_documento);
  $array_i = $buscarInvoice->SelectInvoiceDocket();
  if ($array_i->num_rows!=0) {

    $con=0;
    while ($datos_i = $array_i->fetch_array()) {
      $con++;
      $codigo_factura = $datos_i['codigo_invoice'];
      $fecha = explode('-', $datos_i['fecha']);
      $fecha_formateada = $fecha[1] .'-' .$fecha[2] .'-' .$fecha[0];
      $paginas.$con='
      <h3>INVOICE</h3>
      <table border="1" width="100%">
        <thead>
          <tr>
            <td colspan="2px" width="20%"><center><b>DOCKET #: &nbsp;'.$datos_i['codigo_docket'].'</b></center></td>
            <td colspan="2px" width="20%"><b><center>INVOICE #: &nbsp;'.$datos_i['codigo_usuario'].'</b></center>
            </td>
            <td colspan="2px" width="25%"><b><center>DATE: &nbsp;'.$fecha_formateada.'</b></center></td>
            <td colspan="2px" width="35%"><b><center>BILL TO: &nbsp;'.ucwords($datos_i['cliente']).'</b></center></td>
          </tr>
        </thead>
      </table>

      <table border="1" width="100%">
        <thead>
          <tr>
            <td colspan="2px" width="30%"><center><b>ORIGIN: &nbsp;'.$datos_i['pais_origen'].', '.ucfirst($datos_i['lugar_origen']).'</b></center></td>
            <td colspan="2px" width="30%"><b><center>DESTINATION: &nbsp;'.$datos_i['pais_destino'].', '.ucfirst($datos_i['lugar_destino']).'</b></center></td>
            <td colspan="2px" width="20%"><b><center>PIECES: &nbsp;'.$datos_i['pieza'].' '.ucfirst($datos_i['tipo_pieza']).'</b></center></td>
            <td colspan="2px" width="20%"><b><center>WEIGHT: &nbsp;'.$datos_i['peso'].' '.ucfirst($datos_i['tipo_peso']).'</b></center></td>
          </tr>
        </thead>
      </table>

      <table border="1" width="100%">
        <thead>
          <tr>
            <td colspan="1px" width="40%"><center><b>DIMENSIONS: &nbsp;'.$datos_i['alto'].' X '.$datos_i['ancho'].' X '.$datos_i['largo'].'  '.ucfirst($datos_i['tipo_dimension']).'</b></center></td>
            <td colspan="7px" width="60%"><b><center>NOTE: &nbsp;'.ucfirst($datos_i['descripcion']).'</b></center></td>
          </tr>
        </thead>
      </table>';

      $buscarServInvoice = invoicesServices::soloCodigo($codigo_factura);
      $array1 = $buscarServInvoice->SelectServicosInvoice();

      $paginas.$con.='
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
        $paginas.$con.='
        <tbody>
          <tr>
            <td colspan="5" width="100%"><center>No services</center></td>
          </tr>
        </tbody>';
      }else{
        $i=0;
        while($datos_servi=$array1->fetch_assoc()){
        $i++;
        $paginas.$con.='
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
            <td width="25%"><center>'.ucfirst($datos_servi['nota']).'</center>
            </td>
          </tr>
        </tbody>';
        }
      }
      $paginas.$con.='</table> ';

      $buscarSupplierInvoice = SupplierInvoice::soloCodigo($codigo_factura);
      $array3 = $buscarSupplierInvoice->SelectProvedorInvoice();
      $paginas.$con.='
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
          $paginas.$con.='
          <tbody>
            <tr>
              <td colspan="3" width="100%"><center>NO SERVICES</center></td>
            </tr>
          </tbody>';
        }else{
          $i=0;
          while($datos_supli=$array3->fetch_assoc()){
          $i++;
          $paginas.$con.='
          <tbody>
            <tr>
              <td><center>'.$i.'</center></td>
              <td><center>'.ucwords($datos_supli['supplier']).'</center></td>
              <td><center>'.$datos_supli['dinero'].'</center></td>
            </tr>
          </tbody>';
          }
        }
      $paginas.$con.='
      </table>';

      $buscarViaEnvio = ShippingInvoice::soloCodigo($codigo_factura);
      $array2 = $buscarViaEnvio->SelectViaEnvio();

      $paginas.$con.='
      <h3>Ship Via</h3>';

      if($array2->num_rows==0){
        $paginas.$con.='
        <div>
          <center>No ship via</center>
        <div>';
      }else{
        $paginas.$con.='
        <table border="1">
          <tbody>
            <tr>';
        $i=0;
        while($datos2=$array2->fetch_assoc()){
        $i++;
        $nota = ($datos2['id_envio']==6) ? ": ".ucfirst($datos2['nota']) : "" ;
          $paginas.$con.='
              <td>
                <p>'.$datos2['descripcion'].'</p><b>'.$nota.'</b>
              </td>';
        }
      }
        $paginas.$con.='
            </tr>
          </tbody>
        </table>';
        $mpdf->SetWatermarkImage("../theme/img/logonetex-bspline.png");
        $mpdf->showWatermarkImage = true;
        $mpdf->SetHTMLHeader('<div><img src="../theme/img/logonetex.png" style="margin-left:1%;margin-top:-45px;width:120px;height:60px;"></div>');
    $mpdf->AddPage('L','','','','',10,10,10,10,16,13);
    $mpdf->WriteHTML($paginas.$con);
    }
  }

  $mpdf->SetTitle('Docket - '.$datos_d['codigo']);
  $mpdf->Output('Docket - '.$datos['codigo'].'.pdf','I');
exit;
}
/*
if ($array->num_rows==0) {
  echo "NO EXIST";
}else{
  $datos = $array->fetch_array();

  $html = '<style>

      h2{
        text-align:center
      }
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

  $html.='<h2>FACTURA</h2>
          <h3>
            <p>
              Docket: &nbsp;'.$datos['codigo_docket'].'<br>
              Invoice: &nbsp;'.$datos['codigo_invoice'].'<br>
              Date: &nbsp;'.$datos['fecha_creacion'].'<br>
              Origin: &nbsp;'.$datos['pais_origen'].', '.$datos['lugar_origen'].'<br>
              Destino: &nbsp;'.$datos['pais_destino'].', '.$datos['lugar_destino'].'<br>
              SUB BILL: &nbsp;'.$datos['cliente'].'<br>

              pieza: &nbsp;'.$datos['pieza'].' tipo_pieza: &nbsp;'.$datos['tipo_pieza'].'<br>
              peso: &nbsp;'.$datos['peso'].' tipo_peso: &nbsp;'.$datos['tipo_peso'].'<br>
              alto: &nbsp;'.$datos['alto'].' ancho: &nbsp;'.$datos['ancho'].' largo: &nbsp;'.$datos['largo'].'
              tipo_dimension: &nbsp;'.$datos['tipo<br>_dimension'].'<br>
              descripcion: &nbsp;'.$datos['descripcion'].'<br>

            </p>
          </h3>';




}*/


//==============================================================
//==============================================================
//==============================================================

//$mpdf=new mPDF('c','A4','','l',10,10,10,10,16,13);
//$mpdf->SetTitle('Invoice - '.$datos['codigo_invoice']);

//$mpdf->SetDisplayMode('fullpage');

//$mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
//$stylesheet = file_get_contents('mpdfstyletables.css');
//$mpdf->WriteHTML($stylesheet,1);  // The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->AddPage('L','','','','',10,10,10,10,16,13);
//$mpdf->WriteHTML($html);

//$mpdf->Output('Invoice - '.$datos['codigo_invoice'].'.pdf','I');
//exit;
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
