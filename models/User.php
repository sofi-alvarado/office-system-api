<?php
class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Authenticate a user
    public function authenticate($email, $password) {
      $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if ($user && password_verify($password, $user['password'])) {
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['user_email'] = $user['email'];
          $_SESSION['user_role'] = $user['role'];
          return $user;
      }
  
      return false;
  }

    // Get all users
    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update a user's password
    public function updatePass($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Create a new user
    public function create($email, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO users (email, password, role) VALUES (:email, :password, :role)");
        return $stmt->execute([
            'email' => $email,
            'password' => $hashedPassword,
            'role' => $role
        ]);
    }
}
?>
