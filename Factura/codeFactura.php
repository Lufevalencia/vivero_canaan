<!-- Instrucciones de uso  https://sweetalert.js.org/guides/#installation -->
<script src="../js/sweetalert.js"></script>

<?php
//incluimos la conexion a la base de datos 
include("../Conexion/conexion.php");


//Recibimos las variables enviadas
$Fecha = (isset($_POST['Fecha'])) ? $_POST['Fecha'] : "";
$Id_fac = (isset($_POST['Id_fac'])) ? $_POST['Id_fac'] : "";
$Id_cli = (isset($_POST['Id_cli'])) ? $_POST['Id_cli'] : "";
$id = (isset($_POST['id'])) ? $_POST['id'] : "";
$Id_prov = (isset($_POST['Id_prov'])) ? $_POST['Id_prov'] : "";
$Id_art = (isset($_POST['Id_art'])) ? $_POST['Id_art'] : "";
$Cantidad = (isset($_POST['Cantidad'])) ? $_POST['Cantidad'] : "";
$Form_pag = (isset($_POST['Form_pag'])) ? $_POST['Form_pag'] : "";




$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";


switch ($accion) {
    case 'btnAgregar':

                /* la variable sentencia recolecta la informacion del formulario y 
                la envia a la base de datos.
                La variable conn nos brinda la conexion a la base de datos.
                ->prepare nos prepara la sentencia SQL para que inyecte los valores a la BD.
                */

                $insercionFactura = $conn->prepare(
                "INSERT INTO factura (Fecha, Id_fac, Id_cli, id, Id_prov, Id_art, Cantidad, Form_pag) 
                               VALUES ('$Fecha','$Id_fac','$Id_cli','$id','$Id_prov','$Id_art', '$Cantidad','$Form_pag')"
             );



        $insercionFactura->execute();
        $conn->close();

        header('location: index.php');



        break;


    case 'btnEliminar':


        $eliminarFactura = $conn->prepare(" DELETE FROM factura
        WHERE Id_fac = '$Id_fac' ");

        // $consultaFoto->execute();
        $eliminarFactura->execute();
        $conn->close();

        header('location: index.php');

        break;

    case 'btnCancelar':
        header('location: index.php');
        break;


}



/* Consultamos todas las Facturas  */
$consultaFactura = $conn->prepare("SELECT * FROM factura 
INNER JOIN cliente ON factura.Id_cli = cliente.Id_cli 
INNER JOIN empleados ON factura.id = empleados.id 
INNER JOIN proveedor ON factura.Id_prov = proveedor.Id_prov 
INNER JOIN articulo ON factura.Id_art =articulo.Id_art");
$consultaFactura->execute();
$listaFactura = $consultaFactura->get_result();



/* Consultamos todos los Clientes  */
$consultaCliente = $conn->prepare("SELECT * FROM cliente");
$consultaCliente->execute();
$listaCliente = $consultaCliente->get_result();



/* Consultamos todos los Empleados  */
$consultaEmpleados = $conn->prepare("SELECT * FROM empleados");
$consultaEmpleados->execute();
$listaEmpleados = $consultaEmpleados->get_result();


/* Consultamos todos los Proveedores  */
$consultaProveedor = $conn->prepare("SELECT * FROM proveedor");
$consultaProveedor->execute();
$listaProveedor = $consultaProveedor->get_result();


/* Consultamos todos los Articulos  */
 $consultaArticulo = $conn->prepare("SELECT * FROM articulo");
$consultaArticulo->execute();
$listaArticulo= $consultaArticulo->get_result();

//Al final de todas las consultas se cierra la conexion
 $conn->close();