<?php
require_once 'config/config.php';
require_once 'controllers/EmployeeController.php';

$employeeController = new EmployeeController($pdo);

$action = $_GET['action'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch ($action) {
    // Employee Routes
    case 'createEmployee':
        $data = json_decode(file_get_contents('php://input'), true);
        $employeeController->createEmployee($data);
        echo json_encode(["message" => "Employee created successfully!"]);
        break;

    case 'getEmployees':
        $employees = $employeeController->getEmployees();
        echo json_encode($employees);
        break;

    case 'getEmployee':
        if ($id) {
            $employee = $employeeController->getEmployee($id);
            echo json_encode($employee);
        } else {
            echo json_encode(["message" => "Employee ID is required"]);
        }
        break;

    case 'updateEmployee':
        if ($id) {
            $data = json_decode(file_get_contents('php://input'), true);
            $employeeController->updateEmployee($id, $data);
            echo json_encode(["message" => "Employee updated successfully!"]);
        } else {
            echo json_encode(["message" => "Employee ID is required"]);
        }
        break;

    case 'deleteEmployee':
        if ($id) {
            $employeeController->deleteEmployee($id);
            echo json_encode(["message" => "Employee deleted successfully!"]);
        } else {
            echo json_encode(["message" => "Employee ID is required"]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid action"]);
        break;
}
?>
