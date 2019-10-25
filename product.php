<?php

use Slim\Http\Request; //namespace
use Slim\Http\Response; //namespace

//include productsProc.php file
include __DIR__ . '/../function/productProc.php';

//read table products
$app->get('/products', function (Request $request, Response $response, array $arg){

  $data = getAllProducts($this->db); 
  return $this->response->withJson(array('data' => $data), 200);
});


//post table products
$app->post('/products', function ($request,  $response,  $arg){
  
  $form_dat=$request->getParsedBody();
  
  $data=insertProduct($this->db,$form_dat);
  $data2=getProduct($this->db,$data);
  if ($data<=0){
    return $this ->response ->withJson(array('error'=>'fail'),500);
    
  }

  return $this->response->withJson(array($data => $data2), 201);
});

//request table products by condition
$app->get('/products/[{id}]', function ($request, $response, $args){
    
    $productId = $args['id'];
   if (!is_numeric($productId)) {
      return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
   }
  $data = getProduct($this->db,$productId);
  if (empty($data)) {
    return $this->response->withJson(array('error' => 'no data'), 404);
 }
   return $this->response->withJson(array('data' => $data), 200);
});

//delete row
$app->delete('/products/del/[{id}]', function ($request, $response, $args){
    
  $productId = $args['id'];
 if (!is_numeric($productId)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
 }
$data = deleteProduct($this->db,$productId);
if (empty($data)) {
  //echo $productId + "is deleted";
 return $this->response->withJson(array($productId=> 'is successfully deleted'), 202);};
});

//put table products
$app->put('/products/put/[{id}]', function ($request,  $response,  $args){
  $productId = $args['id'];
  $date = date("Y-m-j h:i:s");
  

 if (!is_numeric($productId)) {
    return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
 }
  $form_dat=$request->getParsedBody();
  
$data=updateProduct($this->db,$form_dat,$productId,$date);

return $this->response->withJson(array('data' => $data), 200);

});
