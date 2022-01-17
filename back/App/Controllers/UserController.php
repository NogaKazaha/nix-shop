<?php

namespace Controllers;

use Models\User;

class UserController extends User
{

  private $db;
  private $requestMethod;
  private $userData;
  private $user;

  public function __construct($db, $requestMethod, $userData)
  {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->userData = $userData;

    $this->user = new User($db);
  }

  public function processRequest()
  {
    switch ($this->requestMethod) {
      case 'GET':
        if ($this->userData) {
          if ($this->userData == 'email') {
            $response = $this->getUserByEmail();
          } else {
            $response = $this->getUser((int)$this->userData);
          }
        } else {
          $response = $this->getAllUsers();
        };
        break;
      case 'POST':
        $response = $this->createUserFromRequest();
        break;
      case 'PUT':
        $response = $this->updateUserFromRequest((int)$this->userData);
        break;
      case 'DELETE':
        $response = $this->deleteUser((int)$this->userData);
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
    $result = $this->user::getAll();
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }

  private function getUserByEmail()
  {
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $result = $this->user::findByEmail('email', $input['email'], 'password',  hash('md5', $input['password']));
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $response['body'] = json_encode($result);
    return $response;
  }

  private function getUser($id)
  {
    $result = $this->user::find($id);
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
    $this->user::create($input);
    $response['status_code_header'] = 'HTTP/1.1 201 Created';
    $arr = array('message' => "User created");
    $response['body'] = json_encode($arr);
    return $response;
  }

  private function updateUserFromRequest($id)
  {
    $result = $this->user->find($id);
    if (!$result) {
      return $this->notFoundResponse();
    }
    $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    $this->user::update($input, $id);
    $response['status_code_header'] = 'HTTP/1.1 200 OK';
    $arr = array('message' => "User updated");
    $response['body'] = json_encode($arr);
    return $response;
  }

  private function deleteUser($id)
  {
    $result = $this->user->find($id);
    if (!$result) {
      return $this->notFoundResponse();
    }
    $this->user::destroy($id);
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

  private function notFoundResponse()
  {
    $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
    $response['body'] = null;
    return $response;
  }
}
