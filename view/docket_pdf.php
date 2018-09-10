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
  $datos_d = $array_d->fetch_assoc();
  //echo "<pre>";print_r($datos_d);exit;
  $array_d->free();
  $fecha1 = explode('-', $datos_d['fecha']);
  $fecha_formateada1 = $fecha1[1] .'-' .$fecha1[2] .'-' .$fecha1[0];
  $a="'";
  $html = '<style>

      h3{
        text-align:center;
      }
      p{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
        line-height: 12px;
        text-align:center

      }

      table th{
        color: #ffffff;
        background-color: #3692cd;
      }
      .table-striped > tbody > tr > td{
        border:2px solid #ffffff;
        background-color: #d1f1fc;
      }
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
          <tr>
            <td><b>SHIPPER: </b> &nbsp;'.ucwords($datos_d['shipper']).'</td>
            <td><b>CC#: </b>&nbsp;'.ucwords($datos_d['cc']).'</td>
            <td><b>DOCKET #: </b>&nbsp;'.$datos_d['codigo'].'</td>
          </tr>
          <tr>
            <td><b>ORIGIN: </b>&nbsp;'.$datos_d['origen'].', '.ucfirst($datos_d['lugar_origen']).'</td>
            <td><b>DESTINATION: </b>&nbsp;'.$datos_d['destino'].', '.ucfirst($datos_d['lugar_destino']).'</td>
            <td><b>DATE: </b>&nbsp;'.$fecha_formateada1.'</td>
          </tr>
          <tr>
            <td colspan="1">
              <b>PIECES / WEIGHT / DM '.$a.'S: </b>&nbsp;
              '.$datos_d['pieza'].' '.ucfirst($datos_d['tipo_pieza']).' &nbsp;
              '.$datos_d['peso'].' '.ucfirst($datos_d['tipo_peso']).' &nbsp;';

              $varI=null;
              if (!empty($datos_d['alto']) && empty($datos_d['ancho']) && empty($datos_d['largo'])) {
                $varI=$datos_d['alto'];
              }
              if (!empty($datos_d['alto']) && !empty($datos_d['ancho']) && empty($datos_d['largo'])) {
                $varI=$datos_d['alto']." X ".$datos_d['ancho'];
              }
              if (!empty($datos_d['alto']) && !empty($datos_d['ancho']) && !empty($datos_d['largo'])) {
                $varI=$datos_d['alto']." X ".$datos_d['ancho']." X ".$datos_d['largo'];
              }
              if (empty($datos_d['alto']) && !empty($datos_d['ancho']) && empty($datos_d['largo'])) {
                $varI=$datos_d['ancho'];
              }
              if (empty($datos_d['alto']) && !empty($datos_d['ancho']) && !empty($datos_d['largo'])) {
                $varI=$datos_d['ancho']." X ".$datos_d['largo'];
              }
              if (empty($datos_d['alto']) && empty($datos_d['ancho']) && !empty($datos_d['largo'])) {
                $varI=$datos_d['largo'];
              }
              //echo $varI." ".ucfirst($datos['tipo_dimension']);

            $html.=$varI." ".ucfirst($datos_d['tipo_dimension']).'
            </td>
            <td>
              <b>PO #:</b>&nbsp;'.ucwords($datos_d['po']).'
              </td>
            <td>
              <b>CONSIGNEE:</b>&nbsp;'.ucwords($datos_d['consignee']).'
              </td>
          </tr>
          <tr>
            <td colspan="3"><b>DESCRIPTION: </b>&nbsp;'.ucfirst($datos_d['descripcion']).'</td>
          </tr>
          <tr>
            <td colspan="3"><b>DOCKET COMMENTS: </b>&nbsp;'.ucfirst($datos_d['comentarios']).'</td>
          </tr>
        </table>';

  $mpdf->AddPage('L','','','','',10,10,10,10,16,13);
  $mpdf->WriteHTML($html);
  /***********Imprimir los invoice de este documento****************/

  $buscarInvoice = Docket::soloCodigo($codigo_documento);
  $array_i = $buscarInvoice->SelectInvoiceDocket();
  if ($array_i->num_rows!=0) {

    $con=0;
    while ($datos_i = $array_i->fetch_assoc()) {
      $con++;
      //echo "<pre>";print_r($datos_i);die;
      $codigo_factura = $datos_i['codigo_invoice'];
      if (!empty($datos_i['fecha'])) {
        $fecha = explode('-', $datos_i['fecha']);
        $fecha_formateada = $fecha[1] .'-' .$fecha[2] .'-' .$fecha[0];

      }
      else{
        $fecha_formateada = "Not registered";
      }
      $varCode = ($datos_i['codigo_usuario']) ? $datos_i['codigo_usuario'] : "Not registered" ;
      $fecha_docket = explode('-', $datos_i['fecha_docket']);
      $paginas.$con='<br><br>
      <table border="1" width="100%">
        <tr>
          <td><b>DOCKET #: </b>&nbsp;'.$datos_i['codigo_docket'].'</td>
          <td><b>DATE DOCKET #: </b>&nbsp;'.$fecha_docket[1] .'-' .$fecha_docket[2] .'-' .$fecha_docket[0].'</td>
          <td><b>INVOICE #: </b>&nbsp;'.$varCode.'</td>
          <td><b>DATE: </b>&nbsp;'.$fecha_formateada.'</td>
        </tr>
        <tr>
          <td colspan="2"><b>BILL TO: </b>&nbsp;'.ucwords($datos_i['cliente']).'</td>
          <td><b>ORIGIN: </b>&nbsp;'.$datos_i['pais_origen'].', '.ucfirst($datos_i['lugar_origen']).'</td>
          <td><b>DESTINATION: </b>&nbsp;'.$datos_i['pais_destino'].', '.ucfirst($datos_i['lugar_destino']).'</td>
        </tr>
        <tr>
          <td><b>PIECES: </b>&nbsp;'.$datos_i['pieza'].' '.ucfirst($datos_i['tipo_pieza']).'</td>
          <td><b>WEIGHT: </b>&nbsp;'.$datos_i['peso'].' '.ucfirst($datos_i['tipo_peso']).'</td>
          <td colspan="1">
              <b>PO #:</b> &nbsp;'.ucfirst($datos_d['po']).'
          </td>
          <td colspan="1">
              <b>CONSIGNEE:</b> &nbsp;'.ucfirst($datos_d['consignee']).'
          </td>
        </tr>
        <tr>
        <td colspan="2">
          <b>NOTE:</b> &nbsp;'.ucfirst($datos_i['descripcion']).'
        </td>
        <td colspan="1">
            <b>CC #:</b> &nbsp;'.ucfirst($datos_d['cc']).'
        </td>
        <td colspan="1">
            <b>SHIPPER:</b> &nbsp;'.ucfirst($datos_i['shipper']).'
        </td>
        </tr>

        <tr>
        <td colspan="2">
          <b>DOCKET COMMENTS: </b>
             '.ucfirst($datos_d['comentarios']).'
        </td>
        <td colspan="2">
          <b>DOCKET DESCRIPTION: </b>
          '.ucfirst($datos_d['descripcion']).'
        </td>
        </tr>
        <tr>
        <td colspan="2">
          <b>PAYMENTS: </b>
          '.ucfirst($datos_i['pagos']).'
        </td>
        <td colspan="2">
          <b>INVOICE COMMENTS: </b>
              '.ucfirst($datos_i['comentarios']).'
        </td>
        </tr>
      </table>';

      $buscarServInvoice = invoicesServices::soloCodigo($codigo_factura);
      $array1 = $buscarServInvoice->SelectServiciosInvoice();

      $paginas.$con.='
      <h3>Services</h3>
        <table border="1" width="100%">
          <thead>
            <tr>
              <td align="center"><b>#</b></td>
              <td align="center"><b>Description</b></td>
              <td align="center"><b>Note</b></td>
              <td align="center"><b>USD$</b></td>
              <td align="center"><b>CAD$</b></td>
            </tr>
          </thead>';
      if($array1->num_rows==0){
        $paginas.$con.='
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
        $paginas.$con.='
          <tbody>
            <tr>
              <td width="10%">'.$i.'</td>
              <td width="30%">'.$datos_servi['descripcion'].'</td>
              <td width="30%">'.$datos_servi['nota'].'</td>
              <td width="15%">'.$precio_us.'</td>
              <td width="15%">'.$precio_ca.'</td>
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
            <td align="center"><b>#</b></td>
            <td align="center"><b>Supplier</b></td>
            <td align="center"><b>Service</b></td>
            <td align="center"><b>Note</b></td>
            <td align="center"><b>USD$</b></td>
            <td align="center"><b>CAD$</b></td>
          </tr>
        </thead>';
        if($array3->num_rows==0){
          $paginas.$con.='
          <tbody>
            <tr>
              <td colspan="5" align="center">No supplier</td>
            </tr>
          </tbody>';
        }else{
          $i=0;
          while($datos_supli=$array3->fetch_assoc()){
          //echo "<pre>";print_r($datos_supli);die;
          $precio_us = ($datos_supli['dinero_us']) ? "$ ".$datos_supli['dinero_us'] : "" ;
          $precio_ca = ($datos_supli['dinero_cad']) ? "$ ".$datos_supli['dinero_cad'] : "" ;
          $i++;
          $paginas.$con.='
          <tbody>
            <tr>
              <td>'.$i.'</td>
              <td width=25%>'.ucwords($datos_supli['supplier']).'</td>
              <td width=20%>'.$datos_supli['descripcion'].'</td>
              <td width=20%>'.$datos_supli['nota'].'</td>
              <td width=15%>'.$precio_us.'</td>
              <td width=15%>'.$precio_ca.'</td>

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
        <div align="center">No ship via<div>';
      }else{
        $paginas.$con.='
        <table border="1" width="40%" style="margin-left:auto; margin-right: auto">
            <tr>';
        $i=0;
        while($datos2=$array2->fetch_assoc()){
        $i++;
        $nota = ($datos2['id_envio']==6) ? ": ".ucfirst($datos2['nota']) : "" ;
          $paginas.$con.='
              <td style="text-align:center">
                &nbsp;&nbsp;<b>'.$datos2['descripcion'] .$nota.'</b>&nbsp;&nbsp;
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

?>
