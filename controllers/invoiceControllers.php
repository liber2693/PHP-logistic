<?php
//include '../models/documentoModels.php';
include '../models/invoiceModels.php';
include '../models/catalogoModels.php';
include '../models/supplierInvoiceModels.php';
include '../models/supplierInvoiceTempModels.php';
include '../models/shippingInvoiceModels.php';
include '../models/invoicesServicesTempModels.php';
include '../models/invoicesServicesModels.php';
include '../models/docketInvoiceDeleteModels.php';
include '../funciones/funciones.php';

session_start();
date_default_timezone_set("America/Caracas");
$fecha_registro=date("Y-m-d");

if(isset($_POST['codigo_documento']) && isset($_POST['usuario_documento'])){
    //echo "<pre>";print_r($_POST);die();
    $codigo_documento=$_POST['codigo_documento'];
    $quien=post("quien_paga");
    $tipoDocumento=$_POST['tipo'];

    //codigo creado por el usuario
    $codigo_usuario = post("codigo_usuario");
    //fecha de creacion del docmuento, establecida por el usuario
    $fecha = $_POST['fecha'];
    //Usuario que se encuentra en sesion
    $usuario=$_SESSION['id_usuario'];
    /*generar el correlativo*/
    $tipo='F';
    $correlativo = new Catalogo('','',$tipo,'','');
    $array = $correlativo->SelectCodigo();
    $cantidad=$array->fetch_assoc();
    $array->free();
    $digito=$cantidad['correlativo']+1;
    $codigo="F-".str_pad($digito,1,"0",STR_PAD_LEFT);
    $actualizar= new Catalogo($cantidad['id'],$digito,$tipo,'','');
    $actualizar->UpdateCorrelativo();
    /*fin generando el correlativo*/
    /*Se guardan los proveedores de esta factura*/

    /*$cantidad_Supli=count($_POST['supplier']);
    for ($i=1; $i <= $cantidad_Supli ; $i++) {
        if (!empty($_POST['supplier'][$i])) {
            $supplier = addslashes($_POST['supplier'][$i]);
            $dinero = addslashes(substr($_POST['dinero'][$i],1));
            $idservicio_sup = $_POST['select_servicio'][$i];
            $insert_supl = new SupplierInvoice($codigo,$supplier,$dinero,$idservicio_sup,$usuario,$fecha_registro,'','');
            $insert_supl->InsertProvedorInvoice();
        }
    }*/
    $consulta_supplier = new supplierInvoiceTemp($codigo_documento,'','','','',$usuario,'','','');
    $array1=$consulta_supplier->SelectAllSupplier();
    while ($resSupplier=$array1->fetch_assoc()) 
    {
        $id_tabla = $resSupplier['id'];
        $supplier = $resSupplier['supplier'];
        $dinero = $resSupplier['dinero'];
        $idservicio_sup = $resSupplier['id_servicio'];
        $nota = $resSupplier['nota'];
        $fecha_creacion = $resSupplier['fecha_creacion'];
        # code...
        //guardar los registros guardados de la tabla temporal
        $insert_supl = new SupplierInvoice($codigo,$supplier,$dinero,$idservicio_sup,$usuario,$fecha_registro,'','');
        $insert_supl->InsertProvedorInvoice();
        //elinarlos de la tabla temporal
        $eliminar = new supplierInvoiceTemp('','','','','','','','',$id_tabla);
        $array=$eliminar->EliminarSupplierTablaTemp();
    //echo "<pre>";print_r($eliminar);die();
    }
    $array1->free();
    /*Se guardan los proveedores de esta factura*/
    /*buscar en la tabla invoices_services_temp para verificar si tiene servicios el documento de la factura para transladarlos a la tabla de servicos por facturas*/
    $consulta_serv = new invoicesServicesTemp($codigo_documento,'','','','',$usuario,'','');
    $array1=$consulta_serv->SelectServicosTablaTemp();
    while ($resServi=$array1->fetch_assoc()) 
    {
        $id_tabla = $resServi['id'];
        $id_servico = $resServi['id_servico'];
        $pago_us = $resServi['pago_us'];
        $pago_can = $resServi['pago_can'];
        $fecha_registro = $resServi['fecha_registro'];
        $nota = $resServi['nota'];
        # code...
        //guardar los registros guardados de la tabla temporal
        $insert_servicios = new invoicesServices($codigo,$id_servico,$pago_us,$pago_can,$nota,$usuario,$fecha_registro,'','');
        $insert_servicios->InsertServiceInvoice();
        //elinarlos de la tabla temporal
        $eliminar = new invoicesServicesTemp('','','','','','','',$id_tabla);
        $array=$eliminar->EliminarServicioTablaTemp();
    }
    $array1->free();

    /*FIN*/
    /*registrar el metodo de envio*/
    $cantidad_envio=count($_POST['envio']);
    for ($i=0; $i <$cantidad_envio; $i++) {
        $id_envio=$_POST['envio'][$i];
        $otro = ($id_envio==6) ? post("otro") : null ;
        $insert_envi = new ShippingInvoice($codigo,$id_envio,$otro,$usuario,$fecha_registro,'','');
        $insert_envi->InsertfactipoEnvio();
    }

    /*FIN*/
    /*registrar en la tabla de invoice por fin*/
    $insert_invoice = new Invoice($codigo,$codigo_documento,$codigo_usuario,$fecha,$tipoDocumento,$quien,'','','',$usuario,$fecha_registro,'','','');
    $insert_invoice->InsertInvoice();
    //echo "<pre>";print_r($insert_invoice);die();

    echo"<meta http-equiv='refresh' content='0;URL=../view/detail_invoice.php?invoice=".base64_encode($codigo)."'>";
}
if(isset($_POST['servicio'])){
    $servicio = $_POST['servicio'];
    $dinero_us = substr($_POST['dinero_us'],1);
    $dinero_cad = substr($_POST['dinero_cad'],1);
    $nota = post("nota");
    $codigo = $_POST['codigo'];
    $usuario = $_POST['usuario'];

    $insert = new invoicesServicesTemp($codigo,$servicio,$dinero_us,$dinero_cad,$nota,$usuario,$fecha_registro,'');
    $insert->InsertTablaTempServi();
    //llamar al monmento de resgistar
    $consulta = new invoicesServicesTemp($codigo,'','','','',$usuario,'','');
    $array=$consulta->SelectServicosTablaTemp();
    if($array->num_rows!=0){
        while($resultado = $array->fetch_assoc()) {
          $data []= array('id' => $resultado['id'],
                          'codigo_ser' => $resultado['codigo_ser'],
                          'descripcion' => $resultado['descripcion'],
                          'dolar_us' => $resultado['pago_us'],
                          'dolar_cad' => $resultado['pago_can'],
                          'nota' => $resultado['nota'],
                        );
        }
        $array->free();
    }else{
        $data=0;
    }
    echo json_encode($data);
}
//llama cuando se habre la pagina
if(isset($_GET['tabla']) && $_GET['tabla']==1){
    $codigo = $_GET['codigo'];
    $usuario = $_GET['usuario'];
    $consulta = new invoicesServicesTemp($codigo,'','','','',$usuario,'','');
    $array=$consulta->SelectServicosTablaTemp();
    if($array->num_rows!=0){
        while($resultado = $array->fetch_assoc()) {
          $data []= array('id' => $resultado['id'],
                          'codigo_ser' => $resultado['codigo_ser'],
                          'descripcion' => $resultado['descripcion'],
                          'dolar_us' => $resultado['pago_us'],
                          'dolar_cad' => $resultado['pago_can'],
                          'nota' => $resultado['nota'],
                        );
        }
        $array->free();
    }else{
        $data=0;
    }
    echo json_encode($data);
}
//eliminar registro de la tabla temporal de servicos
if(isset($_POST['id'])){
    $id=$_POST['id'];
    $eliminar = new invoicesServicesTemp('','','','','','','',$id);
    $array=$eliminar->EliminarServicioTablaTemp();

    echo json_encode(3);
}
/************ ACTUALIZAR ***************/
//Actulalizando Supplier de un invoice
if(isset($_GET['tabla']) && $_GET['tabla']==2){
    $supplier = $_GET['supplier'];
    $codigo_invoice = $_GET['codigo_invoice'];
    $usuario = $_GET['usuario_documento'];
    $pago_supplier = substr($_GET['pago_supplier'],1);
    $servicio_suppl = $_GET['servicio_suppl'];
    $nota_supplier = $_GET['nota_supplier'];
    //echo "<pre>";print_r($_GET);die();

    //registro nuevo en el proceso de actualizar un INVOICE en supplier
    $actualizarRegistro = new SupplierInvoice($codigo_invoice,$supplier,$pago_supplier,$servicio_suppl,$nota_supplier,$usuario,$fecha_registro,'','');
    $actualizarRegistro->InsertProvedorInvoice();

    //llamar al monmento los registros para mostrarlos
    $consulta = new SupplierInvoice($codigo_invoice,'','','','','','','','');
    $array=$consulta->SelectProvedorInvoice();

    if($array->num_rows!=0){
        while($resultado = $array->fetch_assoc()) {
          $data []= array('id' => $resultado['id'],
                          'codigo_invoice' => $resultado['codigo_invoice'],
                          'supplier' => $resultado['supplier'],
                          'dinero' => $resultado['dinero'],
                          'servicio' => $resultado['descripcion'],
                          'nota' => $resultado['nota']
                        );
        }
        $array->free();
    }else{
        $data=0;
    }
    echo json_encode($data);
}
//buscar los supplier que tiene un invoice
if(isset($_GET['tabla']) && $_GET['tabla']==3){
    $codigo_invoice = $_GET['codigo_invoice'];
    //llamar al monmento los registros para mostrarlos
    $consulta = new SupplierInvoice($codigo_invoice,'','','','','','','','');
    $array=$consulta->SelectProvedorInvoice();


    if($array->num_rows!=0){
        while($resultado = $array->fetch_assoc()) {
          $data []= array('id' => $resultado['id'],
                          'codigo_invoice' => $resultado['codigo_invoice'],
                          'supplier' => $resultado['supplier'],
                          'dinero' => $resultado['dinero'],
                          'servicio' => $resultado['descripcion'],
                          'nota' => $resultado['nota']
                        );
        }
        $array->free();
    }else{
        $data=0;
    }
    echo json_encode($data);
}
//eliminar registro
if(isset($_GET['id_supplier'])){
    $id=$_GET['id_supplier'];
    $eliminar = new SupplierInvoice('','','','','','','','',$id);
    //echo "<pre>";print_r($eliminar);die();
    $eliminar->DeleteProvedorInvoice();
        echo json_encode(4);
}
//buscar los supplier que tiene un invoice
if(isset($_GET['tabla']) && $_GET['tabla']==4){
    $codigo_invoice = $_GET['codigo_invoice'];
    //llama los servicos adquirodos por el usuario cuando se registro
    $consulta = new invoicesServices($codigo_invoice,'','','','','','','','');
    $array=$consulta->SelectServicosInvoice();
    if($array->num_rows!=0){
        while($resultado = $array->fetch_assoc()) {
          $data []= array('codigo_ser' => $resultado['codigo_ser'],
                          'id' => $resultado['id_servico'],
                          'descripcion' => $resultado['descripcion'],
                          'nota' => $resultado['nota'],
                          'precio_us' => $resultado['precio_us'],
                          'precio_ca' => $resultado['precio_ca'],
                        );
        }
        $array->free();
    }else{
        $data=0;
    }
    echo json_encode($data);
}

//eliminar registro de la tabla servicos
if(isset($_POST['id_eliminar'])){
    $id=$_POST['id_eliminar'];
    $eliminar = new invoicesServices('','','','','','','','',$id);

    $array=$eliminar->DeleteServicio();

    echo json_encode(3);
}
//actualziar los servicios por ajax gracias jquery
if(isset($_POST['codigo_factura']) && !empty($_POST['codigo_factura'])){
    $servicio = $_POST['servicio_update'];
    $dinero_us = substr($_POST['dinero_us'],1);
    $dinero_cad = substr($_POST['dinero_cad'],1);
    $nota = post("nota");
    $codigo_invoice = $_POST['codigo_factura'];
    $usuario_documento = post("usuario_documento");
    //insertando registro de servivios por invoice
    $insert = new invoicesServices($codigo_invoice,$servicio,$dinero_us,$dinero_cad,$nota,$usuario_documento,$fecha_registro,'','');
    $insert->InsertServiceInvoice();

    //llamar al monmento de resgistar para mostrar en la tabla
    $consulta = new invoicesServices($codigo_invoice,'','','','','','','','');
    $array=$consulta->SelectServicosInvoice();
    if($array->num_rows!=0){
        while($resultado = $array->fetch_assoc()) {
          $data []= array('codigo_ser' => $resultado['codigo_ser'],
                          'id' => $resultado['id_servico'],
                          'descripcion' => $resultado['descripcion'],
                          'nota' => $resultado['nota'],
                          'precio_us' => $resultado['precio_us'],
                          'precio_ca' => $resultado['precio_ca'],
                        );
        }
        $array->free();
    }else{
        $data=0;
    }
    echo json_encode($data);
}


/***********ACTUALIZAR EL INVOIVE COMO TAL COMPLETO************/

if(isset($_POST['codigo_invoice']) && isset($_POST['update']) && !empty($_POST['update'])){

    $codigo_invoice = $_POST['codigo_invoice'];
    $usuario_documento = post("usuario_documento");
    $quien_paga = post("quien_paga");

    $codigo_usuario = post("codigo_usuario");
    $fecha = $_POST['fecha'];

    $cantidad_envios_regis = count($_POST['id_envio_seleccionado']);
    for ($i=0; $i <$cantidad_envios_regis; $i++) {
        if (!empty($_POST['id_envio_seleccionado'][$i])) {
            $id_envio=$_POST['id_envio_seleccionado'][$i];
            $eliminar_envio = new ShippingInvoice($codigo_invoice,'','','','','',$id_envio);
            $eliminar_envio->DeleteViaEnvio();
        }
    }

    //ahora registrar lo que el usuario quiso
    $cantidad_envio=count($_POST['envio']);
    for ($i=0; $i <$cantidad_envio; $i++) {
        $id_envio=$_POST['envio'][$i];
        $otro = ($id_envio==6) ? post("otro") : null ;
        $insert_envi = new ShippingInvoice($codigo_invoice,$id_envio,$otro,$usuario_documento,$fecha_registro,'','');
        $insert_envi->InsertfactipoEnvio();
    }

    $update_invoice = new Invoice($codigo_invoice,'',$codigo_usuario,$fecha,'',$quien_paga,'','','',$usuario_documento,'',$fecha_registro,'','');
    $update_invoice->UpdateInvoice();


    echo"<meta http-equiv='refresh' content='0;URL=../view/detail_invoice.php?invoice=".base64_encode($codigo_invoice)."'>";

}
//eliminar factura
if (isset($_POST['boton_eliminar'])) {
    $codigo_docket = $_POST['codigo_factura_documento'];
    $codigo_invoice = $_POST['codigo_factura_elimanar'];
    $codigo_factura_usuario = $_POST['codigo_factura_usuario'];
    $descripcion = post("descripcion_eliminar");

    $usuario=$_SESSION['id_usuario'];
    $tipo_factura = 'F';
    $delete_invoice = new Invoice($codigo_invoice,'','','','','','','','','','',$fecha_registro,'','');
    $delete_invoice->DeleteInvoice();

    //guardar regsitros de las facturas eliminadas
    $delete_register = new DocketInvoiceDelete($codigo_docket,$codigo_invoice,$codigo_factura_usuario,$tipo_factura,$descripcion,$usuario,$fecha_registro,'','');
    //echo "<pre>";print_r($delete_register);die();
    $delete_register->InsertDocketInvoice();

    echo"<meta http-equiv='refresh' content='0;URL=../view/detail_docket.php?docket=".base64_encode($codigo_docket)."'>";
}
//activar 2 una factura que esta en estatu en proceso 1
if (isset($_GET['active']) && !empty($_GET['active'])) {
    $codigo_invoice_active = base64_decode($_GET['active']);
    $codigo_docket_active = base64_decode($_GET['docket']);

    $procesar_invoice = new Invoice($codigo_invoice_active,'','','','','','','','','','','','','');
    $procesar_invoice->UpdateStatusInvoice();
    //echo "<pre>";print_r($procesar_invoice);die();

    echo"<meta http-equiv='refresh' content='0;URL=../view/detail_docket.php?docket=".base64_encode($codigo_docket_active)."'>";
}
//agregar comentario de invoice desde la lista de invoices
if (isset($_POST['boton_comentario'])) {
    $codigo_invoice = $_POST['codigo_invoice_comentario'];
    $pagos = post('compo_pagos');
    $comentario = post('campo_comentario');

    $comentario_invoice = new Invoice($codigo_invoice,'','','','','','',$pagos,$comentario,'','','','','');
    $comentario_invoice->UpdateComment();

    //echo "<pre>";print_r($_POST);die();

    echo"<meta http-equiv='refresh' content='0;URL=../view/detail_docket.php?docket=".base64_encode($_POST['codigo_docket_comentario'])."'>";

}

/****03-09-2018 nueva funcion para el registro de supplier de invoice****/
if(isset($_POST['supplier_regis']) && $_POST['registro_sup']==1){
    
    $supplier = $_POST['supplier_regis'];
    $id_servicio = $_POST['select_servicio'];
    $dinero = substr($_POST['dinero'],1);
    $nota = $_POST['nota_supplier'];
    $codigo = $_POST['codigo'];
    //Usuario que se encuentra en sesion
    $usuario=$_SESSION['id_usuario'];

    //guardar supplier nuevos en la tabla temporar
    $new_register = new supplierInvoiceTemp($codigo,$supplier,$dinero,$id_servicio,$nota,$usuario,$fecha_registro,'','');
    $new_register->InsertTablaTempSupplier();

    echo json_encode(1);
}
//llama la lista de supplier de un invoice nuevo cuando se habre la pagina
if(isset($_GET['tabla']) && $_GET['tabla']==5){
    $codigo = $_GET['codigo'];
    $usuario = $_GET['usuario'];
    $consulta = new supplierInvoiceTemp($codigo,'','','','',$usuario,'','','');
    $array=$consulta->SelectSupplierTablaTemp();
    if($array->num_rows!=0){
        while($resultado = $array->fetch_assoc()) {
          $data []= array('codigo_ser' => $resultado['codigo_ser'],
                          'id' => $resultado['id'],
                          'descripcion' => $resultado['descripcion'],
                          'nota' => $resultado['nota'],
                          'supplier' => $resultado['supplier'],
                          'dinero' => $resultado['dinero'],
                        );
        }
        $array->free();
    }else{
        $data=0;
    }
    echo json_encode($data);
}
//eliminar registro de un supplier en crear un invioice
if(isset($_POST['id_supplier']) && $_POST['eliminar_supplier'] == 7){
    $id=$_POST['id_supplier'];
    $eliminar = new supplierInvoiceTemp('','','','','','','','',$id);
    $eliminar->EliminarSupplierTablaTemp();
    //print_r($eliminar);die();

    echo json_encode(3);
}



?>
