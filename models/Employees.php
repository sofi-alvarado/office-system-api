<?php
class Employess {
  private $pdo;

  public function __construct($pdo) {
    $this->pdo = $pdo;
  }

  // Create an employee
  public function createEmployee($name, $lastname, $genre, $employment_area) {
    $stmt = $this->pdo->prepare("INSERT INTO employees (name, lastname, genre, employment_area) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $lastname, $genre, $employment_area]);
    return $this->pdo->lastInsertId();
  }

  // Show all employees
  public function getAllEmployees() {
    $stmt = $this->pdo->query("SELECT employees * FROM employees");
    return $stmt->fetchAll();
  }

  // Get an employee by id
  public function getEmployeeById($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM employees WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }

  // Update an employee
  public function updateEmployee($id, $name, $lastname, $genre, $employment_area) {
    $stmt = $this->pdo->prepare("UPDATE employees SET name = ?, lastname = ?, genre = ?, employment_area = ? WHERE id = ?");
    $stmt->execute([$name, $lastname, $genre, $employment_area, $id]);
  }

  // Delete an employee
  public function deleteEmployee($id) {
    $stmt = $this->pdo->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->execute([$id]);
  }
}
?>
