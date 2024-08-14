<?php
require_once 'models/Employee.php';

class EmployeeController {
    private $employee;

    public function __construct($pdo) {
        $this->employee = new Employee($pdo);
    }
}
?>
