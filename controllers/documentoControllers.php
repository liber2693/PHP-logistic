<?php
include '../models/documentoModels.php';
include '../models/archivoAdjuntosModels.php';
include '../models/catalogoModels.php';
include '../funciones/funciones.php';
session_start();
date_default_timezone_set("America/Caracas");
$fecha_registro=date("Y-m-d");
$date=substr(date("Y"),2);


if(isset($_POST['enviar_documento'])){
    $tipoDocumento=$_POST['tipoDocumento'];
    $shipper=$_POST['shipper'];
    $supplier=$_POST['proveedor'];
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
        $codigo="E-".str_pad($digito,2,"0",STR_PAD_LEFT).'-'.$date;
        $actualizar= new Catalogo($cantidad['id'],$digito,$tipoDocumento,'','');
        $actualizar->UpdateCorrelativo();
    }

    $documento = new Docket($codigo,$shipper,$supplier,$telefono,$codigo_zip,$fecha,$pais_origen,$lugar_origen,$pais_destino,$lugar_destino,$pieza,$tipo_pieza,$peso,$tipo_peso,$alto,$ancho,$largo,$tipo_dimension,$descripcion,$tipoDocumento,$fecha_registro,'',$usuario,'','');
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



    $documento = new Docket($codigo_docu,$expedidor,'',$telefono,$codigo_zip,$fecha,$id_origen,$lugar_origen,$id_destino,$lugar_destino,$pieza,$tipo_pieza,$peso,$tipo_peso,$alto,$ancho,$largo,$medida,$descripcion,'','',$fecha_registro,'','','');
    $documento->UpdateDocumento();

    echo"<meta http-equiv='refresh' content='0;URL=../view/detail_docket.php?docket=".base64_encode($codigo_docu)."'>";
}
?>
