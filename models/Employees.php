<?php
class Employess {
    private $pdo;

    public function __construct($pdo) {
      $this->pdo = $pdo;
    }

    public function create($name, $lastname, $genre, $employment_area, $role_id, $password) {
      $stmt = $this->pdo->prepare("INSERT INTO employees (name, lastname, genre, employment_area) VALUES (?, ?, ?, ?)");
      $stmt->execute([$name, $lastname, $genre, $employment_area, $role_id, password_hash($password, PASSWORD_DEFAULT)]);
      return $this->pdo->lastInsertId();
    }
}
?>
