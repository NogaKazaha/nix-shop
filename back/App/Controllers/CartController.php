<?php

namespace Controllers;

use Models\CartModel;

class CartController extends CartModel
{

  private $db;
  private $requestMethod;
  private $cartId;
  private $cart;

  public function __construct($db, $requestMethod, $cartId)
  {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->cartId = $cartId;

    $this->cart = new CartModel($db);
  }

  public function processRequest()
  {
    switch ($this->requestMethod) {
      case 'GET':
        if ($this->cartId) {
          $response = $this->getCart($this->cartId);
        } else {
          $response = $this->getAllCarts();
        };
        break;
      case 'POST':
        $response = $this->createCartFromRequest();
        break;
      case 'PUT':
        $response = $this->updateCartFromRequest($this->cartId);
        break;
      case 'DELETE':
        $response = $this->deleteCart($this->cartId);
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

  private function getAllCarts()
  {
    $result = $this->cart::getAll();
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }

  private function getCart($id)
  {
    $result = $this->cart::find($id);
    if (!$result) {
      return $this->notFoundResponse();
    }
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }

  private function createCartFromRequest()
  {
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $this->cart::create($input);
    $response['status_code_header'] = 'HTTP/1.1 201 Created';
    $arr = array('message' => "User created");
    $response['body'] = json_encode($arr);
    return $response;
  }

  private function updateCartFromRequest($id)
  {
    $result = $this->cart->find($id);
    if (!$result) {
      return $this->notFoundResponse();
    }
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $this->cart::update($input, $id);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $arr = array('message' => "User updated");
    $response['body'] = json_encode($arr);
    return $response;
  }

  private function deleteCart($id)
  {
    $result = $this->cart->find($id);
    if (!$result) {
      return $this->notFoundResponse();
    }
    $this->cart::destroy($id);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $arr = array('message' => "User deleted");
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
