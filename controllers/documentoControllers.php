<?php
include '../models/documentoModels.php';
include '../models/archivoAdjuntosModels.php';
include '../models/catalogoModels.php';
include '../models/docketInvoiceDelete.php';
include '../funciones/funciones.php';
session_start();
date_default_timezone_set("America/Caracas");
$fecha_registro=date("Y-m-d");
$date=substr(date("Y"),2);


if(isset($_POST['enviar_documento'])){
    $tipoDocumento=$_POST['tipoDocumento'];
    $shipper=$_POST['shipper'];
    $telefono=$_POST['telefono'];
    $codigo_zip=$_POST['codigo_zip'];
    $fecha=$_POST['fecha'];
    $pais_origen=$_POST['pais_origen'];
    $lugar_origen=$_POST['origen'];
    $pais_destino=$_POST['pais_destino'];
    $lugar_destino=$_POST['destino'];
    $pieza=$_POST['pieza'];
    $tipo_pieza=$_POST['tipo_pieza'];
    $peso=$_POST['peso'];
    $tipo_peso=$_POST['tipo_peso'];
    $alto=$_POST['alto'];
    $ancho=$_POST['ancho'];
    $largo=$_POST['largo'];
    $tipo_dimension=$_POST['medida'];
    $descripcion=$_POST['descripcion'];

    $usuario=$_SESSION['id_usuario'];

    $correlativo = new Catalogo('','',$tipoDocumento,'','');
    if($tipoDocumento=='I'){
        $array = $correlativo->SelectCodigo();
        $cantidad=$array->fetch_assoc();
        $digito=$cantidad['correlativo']+1;
        $codigo="I-".str_pad($digito,1,"0",STR_PAD_LEFT).'-'.$date;
        $actualizar= new Catalogo($cantidad['id'],$digito,$tipoDocumento,'','');
        $actualizar->UpdateCorrelativo();
    }
    if($tipoDocumento=='E'){
        $array = $correlativo->SelectCodigo();
        $cantidad=$array->fetch_assoc();
        $digito=$cantidad['correlativo']+1;
        $codigo="E-".str_pad($digito,1,"0",STR_PAD_LEFT).'-'.$date;
        $actualizar= new Catalogo($cantidad['id'],$digito,$tipoDocumento,'','');
        $actualizar->UpdateCorrelativo();
    }

    $documento = new Docket($codigo,$shipper,$telefono,$codigo_zip,$fecha,$pais_origen,$lugar_origen,$pais_destino,$lugar_destino,$pieza,$tipo_pieza,$peso,$tipo_peso,$alto,$ancho,$largo,$tipo_dimension,$descripcion,$tipoDocumento,$fecha_registro,'',$usuario,'','');
    $documento->crearDocumento();

    if(!empty($_FILES['archivo'])){
        $cantidad=count($_FILES['archivo']['tmp_name']);
        for ($i=0; $i < $cantidad; $i++) {

            $nombreArchivo=str_replace(" ","_",$_FILES['archivo']['name'][$i]);
            $rutaArchivo="../img/documentos/".$codigo."_".$i."_".$nombreArchivo;
            $foto=$_FILES['archivo']['tmp_name'][$i];

            if (is_uploaded_file($foto)) {

                copy($foto,$rutaArchivo);
                $tipo=$_FILES['archivo']['type'][$i];
                $error=$_FILES['archivo']['error'][$i];
                $tamano=$_FILES['archivo']['size'][$i];

                $archivos = new ArchivoAdjuntos($codigo,$rutaArchivo,'',$nombreArchivo,'');
                $archivos->insertArchivoDocumento();
            }
        }

    }
    echo"<meta http-equiv='refresh' content='0;URL=../view/create_invoice.php?docket=".base64_encode($codigo)."'>";
}
if(isset($_POST['actualizar_documento'])){

    $codigo_docu = $_POST['codigo_docu'];
    $expedidor = $_POST['expedidor'];
    $fecha = $_POST['fecha'];
    $telefono = $_POST['telefono'];
    $codigo_zip = $_POST['codigo_zip'];
    $id_origen = $_POST['pais_origen_Actualizacion'];
    $lugar_origen = $_POST['origen'];
    $id_destino = $_POST['pais_destino_Actualizacion'];
    $lugar_destino = $_POST['destino'];
    $pieza = $_POST['pieza'];
    $tipo_pieza = $_POST['tipo_pieza'];
    $peso = $_POST['peso'];
    $tipo_peso = $_POST['tipo_peso'];
    $alto = $_POST['alto'];
    $ancho = $_POST['ancho'];
    $largo = $_POST['largo'];
    $medida = $_POST['medida'];
    $descripcion = $_POST['descripcion'];

    $usuario=$_SESSION['id_usuario'];



    $documento = new Docket($codigo_docu,$expedidor,$telefono,$codigo_zip,$fecha,$id_origen,$lugar_origen,$id_destino,$lugar_destino,$pieza,$tipo_pieza,$peso,$tipo_peso,$alto,$ancho,$largo,$medida,$descripcion,'','',$fecha_registro,$usuario,'','');
    $documento->UpdateDocumento();

    echo"<meta http-equiv='refresh' content='0;URL=../view/detail_docket.php?docket=".base64_encode($codigo_docu)."'>";
}
//eliminar documento
if(isset($_POST['boton_eliminar'])){

    $codigo_documento = $_POST['codigo_documento_elimanar'];
    $tipo_documento = $_POST['tipo_documento_eliminar'];
    $descripcion = $_POST['descripcion_eliminar'];
    $usuario=$_SESSION['id_usuario'];

    //primero consultar en invoices si existe el documento
    $invoiceDocket = Docket::soloCodigo($codigo_documento);
    $result = $invoiceDocket->selectDocketInvoice();
    if ($result->num_rows!=0) {
        while ($dato = $result->fetch_assoc()) {
            $codigo_factura_eliminar = $dato['codigo_invoice'];
            $tipo_factura = 'F';

            $delete_invoice_d = new Docket($codigo_factura_eliminar,'','','','','','','','','','','','','','','','','','','',$fecha_registro,'','','');
            $delete_invoice_d->DeleteInvoiceDocket();

            //guardar regsitros de las facturas eliminadas
            $delete_register = new DocketInvoiceDelete($codigo_documento,$codigo_factura_eliminar,$tipo_factura,$descripcion,$usuario,$fecha_registro,'','');
            $delete_register->InsertDocketInvoice();

        }
    }
    //eliminar el registro del documento
    $delete_docket = new Docket($codigo_documento,'','','','','','','','','','','','','','','','','','','',$fecha_registro,$usuario,'');
    $delete_docket->DeleteDocket();
    //eliminar el documento ponerlo en la tabla eliminados
    $delete_register_d = new DocketInvoiceDelete($codigo_documento,'',$tipo_documento,$descripcion,$usuario,$fecha_registro,'','');
    $delete_register_d->InsertDocketInvoice();

    echo"<meta http-equiv='refresh' content='0;URL=../view/docket_list.php'>";

}
?>
