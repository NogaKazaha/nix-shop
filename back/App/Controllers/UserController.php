<?php

namespace Controllers;

use Models\User;

class UserController extends User
{

  private $db;
  private $requestMethod;
  private $userId;
  private $personGateway;

  public function __construct($db, $requestMethod, $userId)
  {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->userId = $userId;

    $this->personGateway = new User($db);
  }

  public function processRequest()
  {
    switch ($this->requestMethod) {
      case 'GET':
        if ($this->userId) {
          $response = $this->getUser($this->userId);
        } else {
          $response = $this->getAllUsers();
        };
        break;
      case 'POST':
        $response = $this->createUserFromRequest();
        break;
      case 'PUT':
        $response = $this->updateUserFromRequest($this->userId);
        break;
      case 'DELETE':
        $response = $this->deleteUser($this->userId);
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

  private function getAllUsers()
  {
    $result = $this->personGateway::getAll();
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }

  private function getUser($id)
  {
    $result = $this->personGateway::find($id);
    if (!$result) {
      return $this->notFoundResponse();
    }
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }

  private function createUserFromRequest()
  {
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $this->personGateway::create($input);
    $response['status_code_header'] = 'HTTP/1.1 201 Created';
    $arr = array('message' => "User created");
    $response['body'] = json_encode($arr);
    return $response;
  }

  private function updateUserFromRequest($id)
  {
    $result = $this->personGateway->find($id);
    if (!$result) {
      return $this->notFoundResponse();
    }
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $this->personGateway::update($input, $id);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $arr = array('message' => "User updated");
    $response['body'] = json_encode($arr);
    return $response;
  }

  private function deleteUser($id)
  {
    $result = $this->personGateway->find($id);
    if (!$result) {
      return $this->notFoundResponse();
    }
    $this->personGateway::destroy($id);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $arr = array('message' => "User deleted");
    $response['body'] = json_encode($arr);
    return $response;
  }

  private function validatePerson($input)
  {
    if (!isset($input['username'])) {
      return false;
    }
    if (!isset($input['email'])) {
      return false;
    }
    return true;
  }

  private function unprocessableEntityResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
    $response['body'] = json_encode([
      'error' => 'Invalid input'
    ]);
    return $response;
  }

  private function notFoundResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
  }
}
