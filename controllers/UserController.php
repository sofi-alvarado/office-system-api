<?php
  require_once '../models/User.php';

  class UserController {
    private $userModel;

    public function __construct($pdo) {
      $this->userModel = new UserModel($pdo);
  }
    // Handle user authentication
    public function authenticateUser($email, $password) {
      $user = $this->userModel->authenticate($email, $password);
      if ($user) {
        return ['status' => 'success', 'user' => $user];
      } else {
        return ['status' => 'error', 'message' => 'Usuario o contraseña inválidos.'];
      }
    }

      // Get all users
    public function getUsers() {
      return $this->userModel->getAllUsers();
    }

    // Update user password
    public function updatePassword($id, $newPassword) {
      $success = $this->userModel->updatePass($id, $newPassword);
        if ($success) {
          return ['status' => 'success', 'message' => 'Contraseña actualizada exitosamente.'];
        } else {
          return ['status' => 'error', 'message' => 'Error al actualizar la contraseña.'];
        }
    }

    // Create a new user
    public function createUser($email, $password, $role) {
      $success = $this->userModel->create($email, $password, $role);
        if ($success) {
            return ['status' => 'success', 'message' => 'Usuario creado exitosamente.'];
        } else {
            return ['status' => 'error', 'message' => 'Error al crear el usuario.'];
        }
    }
  }
  ?>