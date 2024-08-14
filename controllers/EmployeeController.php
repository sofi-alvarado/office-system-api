<?php
require_once 'models/Employee.php';

class EmployeeController {
  private $employee;

  public function __construct($pdo) {
    $this->employee = new Employee($pdo);
  }

  // Create an employee
  public function createEmployee($data) {
    return $this->employee->create($data['name'], $data['lastname'], $data['genre'], $data['employment_area']);
  }
  
  // Show all employees
  public function getEmployees() {
    return $this->employee->getAll();
  }

  // Get an employee by id
  public function getEmployee($id) {
      return $this->employee->getById($id);
  }

  // Update an employee
  public function updateEmployee($id, $data) {
      $this->employee->update($id, $data['name'], $data['lastname'], $data['genre'], $data['employment_area']);
  }

  // Delete an employee
  public function deleteEmployee($id) {
      $this->employee->delete($id);
  }
}
?>
