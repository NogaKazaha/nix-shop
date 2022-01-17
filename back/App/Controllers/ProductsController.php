<?php

namespace Controllers;

use Models\ProductsModel;

class ProductsController extends ProductsModel
{

  private $db;
  private $requestMethod;
  private $productId;
  private $product;

  public function __construct($db, $requestMethod, $productId)
  {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->productId = $productId;

    $this->product = new ProductsModel($db);
  }

  public function processRequest()
  {
    switch ($this->requestMethod) {
      case 'GET':
        if ($this->productId) {
          $response = $this->getProduct($this->productId);
        } else {
          $response = $this->getAllProducts();
        };
        break;
      case 'POST':
        $response = $this->createProductFromRequest();
        break;
      case 'PUT':
        $response = $this->updateProductFromRequest($this->productId);
        break;
      case 'DELETE':
        $response = $this->deleteProduct($this->productId);
        break;
      default:
        $response = $this->notFoundResponse();
        break;
    }
    header($response['status_code_header']);
    if ($response['body']) {
      echo $response['body'];
    }
  }

  private function getAllProducts()
  {
    $result = $this->product::getAll();
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }

  private function getProduct($id)
  {
    $result = $this->product::find($id);
    if (!$result) {
      return $this->notFoundResponse();
    }
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }

  private function createProductFromRequest()
  {
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $this->product::create($input);
    $response['status_code_header'] = 'HTTP/1.1 201 Created';
    $arr = array('message' => "Product created");
    $response['body'] = json_encode($arr);
    return $response;
  }

  private function updateProductFromRequest($id)
  {
    $result = $this->product->find($id);
    if (!$result) {
      return $this->notFoundResponse();
    }
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $this->product::update($input, $id);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $arr = array('message' => "Product updated");
    $response['body'] = json_encode($arr);
    return $response;
  }

  private function deleteProduct($id)
  {
    $result = $this->product->find($id);
    if (!$result) {
      return $this->notFoundResponse();
    }
    $this->product::destroy($id);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $arr = array('message' => "Product deleted");
    $response['body'] = json_encode($arr);
    return $response;
  }

  private function notFoundResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
  }
}
