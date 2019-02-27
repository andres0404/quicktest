<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require 'clientes.php';
require 'productos.php';
require 'facturas.php';
//header('Content-Type: application/json');
$app = new \Slim\App;
//$app = new \Slim\Slim();
//----------------------------- CLIENTES -------------------------------
$app->get('/api/clientes[/{id}]', function(Request $request, Response $response, $args) {
    try {
        $id = null;
        if(isset($args['id'])){
            $id = $args['id'];
        }
        $arrClientes = Clientes::run()->listarClientes($id);
        $response->withJson(["data" => $arrClientes],201);
    } catch (DAOException $ex) {
        $response->getBody()->write($ex->getMessage());
    }
    return $response;
});

$app->post('/api/clientes', function(Request $request, Response $response){
    //$customer_id = $request->getParam("customer_id");
    $_objCliente = new DAO_Clientes();
    $arrMapa = $_objCliente->getMapa();
    foreach($arrMapa as $campo => $atributos){
        if($request->getParam($campo)){
            $_objCliente->{'set_'.$campo}($request->getParam($campo));
        }
    }
    if(!$_objCliente->guardar()){
        $response->withJson(['mensaje' => $_objCliente->get_sql_error()],304)->withHeader('Content-type', 'application/json');
        return $response;
    }
    $arrResponse = [
        'ok' => 1,
        'URL' => '/api/clientes/'.$_objCliente->get_cli_id()
    ];
    $response->withJson($arrResponse,201)->withHeader('Content-type', 'application/json');
    return $response;
});

$app->put('/api/clientes/{id}', function(Request $request, Response $response, $args){
    //$customer_id = $request->getParam("customer_id");
    if(!isset($args['id'])){
        $response->withJson(['mensaje' => 'No se establecio el cliente a modificar'],304)->withHeader('Content-type', 'application/json');
        return $response;
    }
    $_objCliente = new DAO_Clientes();
    $arrMapa = $_objCliente->getMapa();
    foreach($arrMapa as $campo => $atributos){
        if($request->getParam($campo)){
            $_objCliente->{'set_'.$campo}($request->getParam($campo));
        }
    }
    $_objCliente->set_cli_id($args['id']);
    if(!$_objCliente->guardar()){
        $response->withJson(['mensaje' => $_objCliente->get_sql_error()],304)->withHeader('Content-type', 'application/json');
    }
    $arrResponse = [
        'ok' => 1,
        'URL' => '/api/clientes/'.$_objCliente->get_cli_id()
    ];
    $response->withJson($arrResponse,201)->withHeader('Content-type', 'application/json');
    return $response;
    
});

$app->delete('/api/clientes/{id}', function(Request $request, Response $response, $args){
    try{
        $cli_id = $args['id'];
        Clientes::run()->eliminarCliente($cli_id);
        $response->withJson(['mensaje' => "Cliente $cli_id eliminado"],200)->withHeader('Content-type', 'application/json');
    } catch (DAOException $ex) {
        $response->withJson(['mensaje' => $ex->getMessage()],204)->withHeader('Content-type', 'application/json');
    }
    
});

// --------------------------- PRODUCTOS ----------------------------------------

$app->get('/api/productos[/{id}]', function(Request $request, Response $response,$args) {
    try {
        $id = null;
        if(isset($args['id'])){
            $id = $args['id'];
        }
        $arrProductos = Productos::run()->listarProductos($id);
        $response->withJson(["data"=> $arrProductos],201)->withHeader('Content-type', 'application/json');
    } catch (DAOException $ex) {
        $response->getBody()->write($ex->getMessage());
    }
    return $response;
});
$app->delete('/api/productos/{id}', function(Request $request, Response $response, $args){
    try{
        $pro_id = $args['id'];
        Productos::run()->eliminarProducto($pro_id);
        $response->withJson(['mensaje' => "producto $pro_id eliminado"],200)->withHeader('Content-type', 'application/json');
    } catch (DAOException $ex) {
        $response->withJson(['mensaje' => $ex->getMessage()],204)->withHeader('Content-type', 'application/json');
    }
    
});
$app->post('/api/productos', function(Request $request, Response $response,$args){
    //$customer_id = $request->getParam("customer_id");
    //print_r($_POST);
    $_obj = new DAO_Productos();
    $arrMapa = $_obj->getMapa();
    foreach($arrMapa as $campo => $atributos){
        echo $request->getParam($campo);
        if($request->getParam($campo)){
            $_obj->{'set_'.$campo}($request->getParam($campo));
        }
    }
    //print_r($_obj);
    if(!$_obj->guardar()){
        $response->withJson(['mensaje' => $_obj->get_sql_query()],204)->withHeader('Content-type', 'application/json');
        return $response;
    }
    $arrResponse = [
        'ok' => 1,
        'URL' => '/api/productos/'.$_obj->get_prod_id()
    ];
    $response->withJson($arrResponse,201)->withHeader('Content-type', 'application/json');
    return $response;
});

$app->put('/api/productos/{id}', function(Request $request, Response $response, $args){
    //$customer_id = $request->getParam("customer_id");
    if(!isset($args['id'])){
        $response->withJson(['mensaje' => 'No se establecio el producto a modificar'],304)->withHeader('Content-type', 'application/json');
        return $response;
    }
    $_obj= new DAO_Productos();
    $arrMapa = $_obj->getMapa();
    foreach($arrMapa as $campo => $atributos){
        if($request->getParam($campo)){
            $_obj->{'set_'.$campo}($request->getParam($campo));
        }
    }
    $_obj->set_prod_id($args['id']);
    if(!$_obj->guardar()){
        $response->withJson(['mensaje' => $_obj->get_sql_error()],304)->withHeader('Content-type', 'application/json');
    }
    $arrResponse = [
        'ok' => 1,
        'URL' => '/api/clientes/'.$_obj->get_prod_id()
    ];
    $response->withJson($arrResponse,201)->withHeader('Content-type', 'application/json');
    return $response;
    
});
// --------------------------------- FACTURAS -------------------------------
$app->get('/api/facturas[/{id}]', function(Request $request, Response $response, $args) {
    try {
        $id = null;
        if(isset($args['id'])){
            $id = $args['id'];
        }
        $arrFacturas = Facturas::run()->listarFacturas($id);
        $response->withJson($arrFacturas,201)->withHeader('Content-type', 'application/json');
    } catch (DAOException $ex) {
        $response->getBody()->write($ex->getMessage());
    }
    return $response;
});

$app->delete('/api/facturas/{id}', function(Request $request, Response $response, $args){
    try{
        $fac_id = $args['id'];
        Facturas::run()->eliminarFactura($fac_id);
        $response->withJson(['mensaje' => "Factura $fac_id eliminada"],200)->withHeader('Content-type', 'application/json');
    } catch (DAOException $ex) {
        $response->withJson(['mensaje' => $ex->getMessage()],204)->withHeader('Content-type', 'application/json');
    }
    
});
$app->delete('/api/facturas/{id}/{id_itm}', function(Request $request, Response $response, $args){
    try{
        $fac_id = $args['id'];
        Facturas::run()->eliminarItem($fac_id,$args['id_itm']);
        $response->withJson(['mensaje' => "Item {$args['id_itm']} eliminado"],200)->withHeader('Content-type', 'application/json');
    } catch (DAOException $ex) {
        $response->withJson(['mensaje' => $ex->getMessage()],204)->withHeader('Content-type', 'application/json');
    }
    
});
$app->post('/api/facturas', function(Request $request, Response $response){
    //$customer_id = $request->getParam("customer_id");
    $_obj = new DAO_Facturas();
    $arrMapa = $_obj->getMapa();
    foreach($arrMapa as $campo => $atributos){
        if($request->getParam($campo)){
            $_obj->{'set_'.$campo}($request->getParam($campo));
        }
    }
    if(!$_obj->guardar()){
        $response->withJson(['mensaje' => $_obj->get_sql_error()],304)->withHeader('Content-type', 'application/json');
        return $response;
    }
    $arrResponse = [
        'ok' => 1,
        'URL' => '/api/facturas/'.$_obj->get_fac_id()
    ];
    $response->withJson($arrResponse,201)->withHeader('Content-type', 'application/json');
    return $response;
});
// agregar items a factura
$app->post('/api/facturas/{id}/agregar', function(Request $request, Response $response,$args){
    //$customer_id = $request->getParam("customer_id");
    if(!$_objFactura = Facturas::run()->existeFactura($args['id'])){
        //print_r($_objFactura);
        $response->withJson(['mensaje' => "No existe factura"],304)->withHeader('Content-type', 'application/json');
        return $response;
    }
    $_obj = new DAO_Factura_items();
    $arrMapa = $_obj->getMapa();
    foreach($arrMapa as $campo => $atributos){
        if($request->getParam($campo)){
            $_obj->{'set_'.$campo}($request->getParam($campo));
        }
    }
    // calcular valor items
    $arrProd = Productos::run()->listarProductos($_obj->get_prod_id());
    $catindad = $_obj->get_itm_cantidad();
    $precio = $arrProd[0]['prod_precio'];
    $_obj->set_itm_total($catindad * $precio);
    $_obj->set_fac_id($_objFactura->get_fac_id());
    if(!$_obj->guardar()){
        $response->withJson(['mensaje' => $_obj->get_sql_query()],304)->withHeader('Content-type', 'application/json');
        return $response;
    }
    $_objFactura->actualizar_total();
    $arrResponse = [
        'ok' => 1,
        'URL' => '/api/facturas/'.$args['id']
    ];
    $response->withJson($arrResponse,201)->withHeader('Content-type', 'application/json');
    return $response;
});

$app->put('/api/facturas/{id}', function(Request $request, Response $response, $args){
    //$customer_id = $request->getParam("customer_id");
    if(!isset($args['id'])){
        $response->withJson(['mensaje' => 'No se establecio la factura a modificar'],304)->withHeader('Content-type', 'application/json');
        return $response;
    }
    $_obj= new DAO_Facturas();
    $arrMapa = $_obj->getMapa();
    foreach($arrMapa as $campo => $atributos){
        if($request->getParam($campo)){
            $_obj->{'set_'.$campo}($request->getParam($campo));
        }
    }
    $_obj->set_fac_id($args['id']);
    if(!$_obj->guardar()){
        $response->withJson(['mensaje' => $_obj->get_sql_error()],304)->withHeader('Content-type', 'application/json');
    }
    $arrResponse = [
        'ok' => 1,
        'URL' => '/api/clientes/'.$_obj->get_fac_id()
    ];
    $response->withJson($arrResponse,201)->withHeader('Content-type', 'application/json');
    return $response;
    
});



/*$app->delete('/api/customers/eliminar/{id}', function(Request $request, Response $response){
    $customer_id = $request->getAttribute("id");
    echo "eliminando $customer_id";
});*/

$app->run();
