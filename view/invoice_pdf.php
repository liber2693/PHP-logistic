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
  $datos = $array->fetch_assoc();
  //echo "<pre>";print_r($datos);die;

  $html = '<style>

      h3{
        text-align:center;
      }
      p{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9px;
        line-height: 12px;
        text-align:center

      }

      table th{color: #ffffff; background-color: #3692cd;}
      .table-striped > tbody > tr > td{border:2px solid #ffffff; background-color: #d1f1fc;}

      td {
        height: 20px;
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
        font-size: 12px;
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
      $fecha_docket = explode('-', $datos['fecha_docket']);

      //echo "<pre>";print_r($datos);exit;
      $html.='
      <h3><br>INVOICE</h3>
      <table border="1" width="100%">
        <tr>
          <td><b>DOCKET #: </b>&nbsp;'.$datos['codigo_docket'].'</td>
          <td><b>DATE DOCKET #: </b>&nbsp;'.$fecha_docket[1] .'-' .$fecha_docket[2] .'-' .$fecha_docket[0].'</td>
          <td><b>INVOICE #: </b>&nbsp;'.$varCode.'</td>
          <td><b>DATE: </b>&nbsp;'.$fecha_formateada.'</td>
        </tr>
        <tr>
          <td colspan="2"><b>BILL TO: </b>&nbsp;'.ucwords($datos['cliente']).'</td>
          <td><b>ORIGIN: </b>&nbsp;'.$datos['pais_origen'].', '.ucfirst($datos['lugar_origen']).'</td>
          <td><b>DESTINATION: </b>&nbsp;'.$datos['pais_destino'].', '.ucfirst($datos['lugar_destino']).'</td>
        </tr>
        <tr>
            <td colspan="2">
              <b>PIECES / WEIGHT / DM '.$a.'S: </b>&nbsp;
              '.$datos['pieza'].' '.ucfirst($datos['tipo_pieza']).' &nbsp;
              '.$datos['peso'].' '.ucfirst($datos['tipo_peso']).' &nbsp;';

              $varI=null;
              if (!empty($datos['alto']) && empty($datos['ancho']) && empty($datos['largo'])) {
                $varI=$datos['alto'];
              }
              if (!empty($datos['alto']) && !empty($datos['ancho']) && empty($datos['largo'])) {
                $varI=$datos['alto']." X ".$datos['ancho'];
              }
              if (!empty($datos['alto']) && !empty($datos['ancho']) && !empty($datos['largo'])) {
                $varI=$datos['alto']." X ".$datos['ancho']." X ".$datos['largo'];
              }
              if (empty($datos['alto']) && !empty($datos['ancho']) && empty($datos['largo'])) {
                $varI=$datos['ancho'];
              }
              if (empty($datos['alto']) && !empty($datos['ancho']) && !empty($datos['largo'])) {
                $varI=$datos['ancho']." X ".$datos['largo'];
              }
              if (empty($datos['alto']) && empty($datos['ancho']) && !empty($datos['largo'])) {
                $varI=$datos['largo'];
              }
              //echo $varI." ".ucfirst($datos['tipo_dimension']);

            $html.=$varI." ".ucfirst($datos['tipo_dimension']).'
            </td>
            <td>
              <b>PO #:</b>&nbsp;'.ucwords($datos['po']).'
              </td>
            <td>
              <b>CONSIGNEE:</b>&nbsp;'.ucwords($datos['consignee']).'
              </td>
          </tr>
        <tr>
          <td colspan="2">
            <b>NOTE:</b> &nbsp;'.ucfirst($datos['descripcion']).'
          </td>
          <td colspan="1">
            <b>CC #:</b> &nbsp;'.ucfirst($datos['cc']).'
          </td>
          <td colspan="1">
            <b>SHIPPER:</b> &nbsp;'.ucfirst($datos['shipper']).'
          </td>
        </tr>
        <tr>
        <td colspan="2">
          <b>DOCKET COMMENTS: </b>
             '.ucfirst($datos['docket_comentario']).'
        </td>

          <td colspan="2">
            <b>DOCKET DESCRIPTION: </b>
            '.ucfirst($datos['descripcion']).'
          </td>
        </tr>
        <tr>
        <td colspan="2">
          <b>PAYMENTS: </b>
          '.ucfirst($datos['pagos']).'
        </td>
          <td colspan="2">
            <b>INVOICE COMMENTS: </b>
                '.ucfirst($datos['invoice_comments']).'
          </td>
        </tr>
      </table>';
  $buscarServInvoice = invoicesServices::soloCodigo($codigo_factura);
  $array1 = $buscarServInvoice->SelectServiciosInvoice();

  //echo "<pre>";print_r($array1);die;

  $html.='
  <h3>Services</h3>
  <table border="1" width="100%">
    <thead>
      <tr>
        <td align="center"><b>#</b></td>
        <td align="center"><b>Description</b></td>
        <td align="center"><b>Notes</b></td>
        <td align="center"><b>US$</b></td>
        <td align="center"><b>CAD$</b></td>
      </tr>
    </thead>';
  if($array1->num_rows==0){
     $html.='
    <tbody>
      <tr>
        <td colspan="5" align="center">No services</td>
      </tr>
    </tbody>';
  }else{
    $i=0;
    while($datos_servi=$array1->fetch_assoc()){
    $i++;
    $precio_us = ($datos_servi['precio_us']) ? "$ ".$datos_servi['precio_us'] : "" ;
    $precio_ca = ($datos_servi['precio_ca']) ? "$ ".$datos_servi['precio_ca'] : "" ;
    $html.='
      <tbody>
        <tr>
          <td>'.$i.'</td>
          <td>'.$datos_servi['descripcion'].'</td>
          <td>'.$datos_servi['nota'].'</td>
          <td>'.$precio_us.'</td>
          <td>'.$precio_ca.'</td>
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
        <td align="center"><b>#</b></td>
        <td align="center"><b>Supplier</b></td>
        <td align="center"><b>Service</b></td>
        <td align="center"><b>Cost US$</b></td>
      </tr>
    </thead>';
    if($array3->num_rows==0){
      $html.='
    <tbody>
      <tr>
        <td colspan="4" align="center">No supplier</td>
      </tr>
    </tbody>';
    }else{
      $i=0;
      while($datos_supli=$array3->fetch_assoc()){
      $i++;
      $html.='
      <tbody>
        <tr>
          <td>'.$i.'</td>
          <td>'.ucwords($datos_supli['supplier']).'</td>
          <td>'.$datos_supli['descripcion'].'</td>
          <td>$ '.$datos_supli['dinero'].'</td>
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
      <div align="center">No ship via<div>';
  }else{
    $html.='
    <table border="1" width="40%" style="margin-left:auto; margin-right: auto">

        <tr>';
    $i=0;
    while($datos2=$array2->fetch_assoc()){
    $i++;
    $nota = ($datos2['id_envio']==6) ? ": ".ucfirst($datos2['nota']) : "" ;
      $html.='
          <td style="text-align:center">
            &nbsp;&nbsp;<b>'.$datos2['descripcion'] .$nota.'</b>&nbsp;&nbsp;
          </td>';
    }
  }
    $html.='
        </tr>

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
$mpdf->SetHTMLHeader('<div><img src="../theme/img/logonetex.png" style="margin-left:1%;margin-top:-45px;width:145px;height:80px;"></div>');
$mpdf->SetWatermarkImage("../theme/img/logonetex-bspline.png");
$mpdf->showWatermarkImage = true;
$mpdf->AddPage('L','','','','',10,10,10,10,16,13);
$mpdf->WriteHTML($html);

$mpdf->Output('Invoice-'.$code[1] .'-' .$datos['codigo_usuario'] .'.pdf','I');
exit;

?>
