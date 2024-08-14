<?php
class Employess {
  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  // Create an employee
  public function create($name, $lastname, $genre, $employment_area, $role_id, $password) {
    $stmt = $this->pdo->prepare("INSERT INTO employees (name, lastname, genre, employment_area) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $lastname, $genre, $employment_area, $role_id, password_hash($password, PASSWORD_DEFAULT)]);
    return $this->pdo->lastInsertId();
  }

  // Show all employees
  public function getAll() {
    $stmt = $this->pdo->query("SELECT employees * FROM employees");
    return $stmt->fetchAll();
  }

  // Get an employee by id
  public function getById($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM employees WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }
}
?>
