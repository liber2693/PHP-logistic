<?php
include '../models/documentoModels.php';
include '../models/archivoAdjuntosModels.php';
include '../models/catalogoModels.php';
include '../models/docketInvoiceDeleteModels.php';
include '../funciones/funciones.php';
session_start();
date_default_timezone_set("America/Caracas");
$fecha_registro=date("Y-m-d");
$mes=date("m"); //CUANDO SEA  NOVIEMBRE, EL AÑO PASARA A 19
$date=substr(date("Y"),2);

if ($mes == '11' or $mes =='12'){
  $date=substr(date("Y"),2) + 1;
}

//print_r($date);die();
if(isset($_POST['tipoDocumento'])){
    $tipoDocumento=$_POST['tipoDocumento'];
    $shipper=post('shipper');
    $telefono=post('telefono');
    $po=post("po");
    $cc = post("cc");
    $consignee = post("consignee");
    $fecha=$_POST['fecha'];
    $pais_origen=$_POST['pais_origen'];
    $lugar_origen=post("origen");
    $pais_destino=$_POST['pais_destino'];
    $lugar_destino=post("destino");
    $pieza=post("pieza");
    $tipo_pieza=post("tipo_pieza");
    $peso=post("peso");
    $tipo_peso=post("tipo_peso");
    $alto=post("alto");
    $ancho=post("ancho");
    $largo=post("largo");
    $tipo_dimension=post("medida");
    $descripcion=post("descripcion");

    $usuario=$_SESSION['id_usuario'];

    $correlativo = new Catalogo('','',$tipoDocumento,'','');
    $array = $correlativo->SelectCodigo();
    $cantidad=$array->fetch_assoc();
    $array->free();
    if($tipoDocumento=='I'){
        $digito=$cantidad['correlativo']+1;
        $codigo="I-".str_pad($digito,3,"0",STR_PAD_LEFT).'-'.$date;
        $actualizar= new Catalogo($cantidad['id'],$digito,$tipoDocumento,'','');
        $actualizar->UpdateCorrelativo();
    }
    if($tipoDocumento=='E'){
        $digito=$cantidad['correlativo']+1;
        $codigo="E-".str_pad($digito,3,"0",STR_PAD_LEFT).'-'.$date;
        $actualizar= new Catalogo($cantidad['id'],$digito,$tipoDocumento,'','');
        $actualizar->UpdateCorrelativo();
    }

    $documento = new Docket($codigo,$shipper,$telefono,$po,$cc,$consignee,$fecha,$pais_origen,$lugar_origen,$pais_destino,$lugar_destino,$pieza,$tipo_pieza,$peso,$tipo_peso,$alto,$ancho,$largo,$tipo_dimension,$descripcion,'',$tipoDocumento,$fecha_registro,'',$usuario,'','');
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

                $archivos = new ArchivoAdjuntos($codigo,$rutaArchivo,'',$nombreArchivo,$i,'');
                $archivos->insertArchivoDocumento();
            }
        }

    }
    echo"<meta http-equiv='refresh' content='0;URL=../view/create_invoice.php?docket=".base64_encode($codigo)."'>";
}
if(isset($_POST['codigo_docu'])){

    $codigo_docu = $_POST['codigo_docu'];
    $expedidor = post("expedidor");
    $fecha = $_POST['fecha'];
    $telefono = post("telefono");
    $cc = post("cc");
    $consignee = post("consignee");
    $po = post("po");
    $id_origen = $_POST['pais_origen_Actualizacion'];
    $lugar_origen = post("origen");
    $id_destino = $_POST['pais_destino_Actualizacion'];
    $lugar_destino = post("destino");
    $pieza = post("pieza");
    $tipo_pieza = post("tipo_pieza");
    $peso = post("peso");
    $tipo_peso = post("tipo_peso");
    $alto = post("alto");
    $ancho = post("ancho");
    $largo = post("largo");
    $medida = post("medida");
    $descripcion = post("descripcion");

    $usuario=$_SESSION['id_usuario'];

    $documento = new Docket($codigo_docu,$expedidor,$telefono,$cc,$consignee,$po,$fecha,$id_origen,$lugar_origen,$id_destino,$lugar_destino,$pieza,$tipo_pieza,$peso,$tipo_peso,$alto,$ancho,$largo,$medida,$descripcion,'','','',$fecha_registro,$usuario,'','');
    $documento->UpdateDocumento();

    echo"<meta http-equiv='refresh' content='0;URL=../view/detail_docket.php?docket=".base64_encode($codigo_docu)."'>";
}
//eliminar documento
if(isset($_POST['boton_eliminar'])){

    $codigo_documento = $_POST['codigo_documento_elimanar'];
    $tipo_documento = $_POST['tipo_documento_eliminar'];
    $descripcion = addslashes($_POST['descripcion_eliminar']);
    $usuario=$_SESSION['id_usuario'];

    //primero consultar en invoices si existe el documento
    $invoiceDocket = Docket::soloCodigo($codigo_documento);
    $result = $invoiceDocket->selectDocketInvoice();
    if ($result->num_rows!=0) {
        while ($dato = $result->fetch_assoc()) {
            $codigo_factura_eliminar = $dato['codigo_invoice'];
            $codigo_usuario_eliminar = $dato['codigo_usuario'];
            $tipo_factura = 'F';

            $delete_invoice_d = new Docket($codigo_factura_eliminar,'','','','','','','','','','','','','','','','','','','','','','',$fecha_registro,'','','');
            $delete_invoice_d->DeleteInvoiceDocket();

            //guardar regsitros de las facturas eliminadas
            $delete_register = new DocketInvoiceDelete($codigo_documento,$codigo_factura_eliminar,$codigo_usuario_eliminar,$tipo_factura,$descripcion,$usuario,$fecha_registro,'','');
            $delete_register->InsertDocketInvoice();

        }
        $result->free();
    }
    //eliminar el registro del documento
    $delete_docket = new Docket($codigo_documento,'','','','','','','','','','','','','','','','','','','','','','','',$fecha_registro,$usuario,'');
    $delete_docket->DeleteDocket();
    //eliminar el documento ponerlo en la tabla eliminados
    $delete_register_d = new DocketInvoiceDelete($codigo_documento,'','',$tipo_documento,$descripcion,$usuario,$fecha_registro,'','');
    $delete_register_d->InsertDocketInvoice();

    echo"<meta http-equiv='refresh' content='0;URL=../view/docket_list.php'>";

}
//regresar un archivo de la lista de eliminados
if (isset($_POST['boton_regresar'])) {
    $id = $_POST['id_regresar'];

    $buscarEliminado = new DocketInvoiceDelete('','','','','','','','',$id);

    $array1 = $buscarEliminado->SelectIdDelete();
    $resultadoE=$array1->fetch_assoc();
    $array1->free();

    $codigoD = $resultadoE['codigo_docket'];

    if ($resultadoE['tipo']=='E' || $resultadoE['tipo']=='I') {
        //echo "estas regresando un documento";
        $retornarDocumento = new DocketInvoiceDelete($codigoD,'','','','','','','',$id);
        $retornarDocumento->ReturnDocket();
    }
    elseif ($resultadoE['tipo']=='F')
    {
        //echo "Estas regresando una factura";
        $codigoF = $resultadoE['codigo_invoice'];
        //pregunto si esxiste el documento de la factura aqui para retornarlo
        $todoDocumento = new DocketInvoiceDelete($codigoD,'','','','','','','','');
        $array2 = $todoDocumento->SelectAllDocInv();

        while ($varI=$array2->fetch_assoc()) {
            if($varI['tipo']=='E' || $varI['tipo']=='I'){
                //toca retornarla y eliminarla de una
                $varId = $varI['id'];
                $varCodigoDoc = $varI['codigo_docket'];
                $retornarDocumento = new DocketInvoiceDelete($varCodigoDoc,'','','','','','','',$varId);
                $retornarDocumento->ReturnDocket();
    //echo "<pre>";print_r($retornarDocumento);die();
            }
        }
        $array2->free();
        //cambiarle los estatus para retornarla
        //eliminarla de la tabla eliminados
        $retornandoFactura = new DocketInvoiceDelete('',$codigoF,'','','','','','','');
        $retornandoFactura->ReturnInvoice();
    }

    echo"<meta http-equiv='refresh' content='0;URL=../view/delete_list.php'>";
}
//actualizar imagen
if (isset($_POST['codigo_docket']) && !empty($_FILES['archivo'])) {
    //echo "empezar coño";
    $codigo_d = $_POST['codigo_docket'];

    $maximo = ArchivoAdjuntos::soloCodigo($codigo_d);
    $array = $maximo->SelectMax();
    $cantidad = $array->fetch_assoc();
    $array->free();

    $i = $cantidad['max'] + 1;

    //echo "<pre>";print_r($_FILES);die();

    $nombreArchivo=str_replace(" ","_",$_FILES['archivo']['name']);
    $rutaArchivo="../img/documentos/".$codigo_d."_".$i."_".$nombreArchivo;
    $foto=$_FILES['archivo']['tmp_name'];

    if (is_uploaded_file($foto)) {

        copy($foto,$rutaArchivo);
        $tipo=$_FILES['archivo']['type'];
        $error=$_FILES['archivo']['error'];
        $tamano=$_FILES['archivo']['size'];

        $archivos = new ArchivoAdjuntos($codigo_d,$rutaArchivo,'',$nombreArchivo,$i,'');
        $archivos->insertArchivoDocumento();
    }

    echo json_encode(1);
}
if(isset($_GET['codigo_docket_lista'])){
    $codigo_d = $_GET['codigo_docket_lista'];
    //si es correcto ahora busco
    $archivos = ArchivoAdjuntos::soloCodigo($codigo_d);
    $array2 = $archivos->SelectArchivoAdjunto();
    if($array2->num_rows!=0){
        while($resultado = $array2->fetch_assoc()) {
          $data []= array('id' => $resultado['id'],
                          'url_ubicacion' => $resultado['url_ubicacion'],
                          'nombre_archivo' => $resultado['nombre_archivo'],
                        );
        }
        $array2->free();
    }else{
        $data=0;
    }
    echo json_encode($data);
}
if(isset($_POST['id_archivo'])){
    //echo "preparado para eliminar";

    $id_archivo = $_POST['id_archivo'];

    $archivo = ArchivoAdjuntos::soloId($id_archivo);
    $result = $archivo->SelectIdRegister();
    $datos = $result->fetch_assoc();
    $result->free();

    $url = $datos['url_ubicacion'];
    if (file_exists($url)){
        unlink($url);
    }
    $archivo_eliminar = ArchivoAdjuntos::soloId($id_archivo);
    $archivo_eliminar->DeleteArchivo();
    echo json_encode(1);
}
//comentario para el docket desde la lista
if(isset($_POST['boton_comentario'])){
    $codigo_docket_comentario = $_POST['codigo_docket_comentario'];
    $campo_comentario = post('campo_comentario');

    $comentario = new Docket($codigo_docket_comentario,'','','','','','','','','','','','','','','','','','','',$campo_comentario,'','','','','','');
    $comentario->InsertCommentsDocket();
    //echo "<pre>";print_r($comentario);die();
    echo"<meta http-equiv='refresh' content='0;URL=../view/docket_list.php'>";

}
?>
