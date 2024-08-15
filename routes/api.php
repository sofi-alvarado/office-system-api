<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  exit(0);
}

require_once '../utils/JwtUtils.php';
require_once '../config/config.php';
require_once '../models/Employee.php';
require_once '../controllers/EmployeeController.php';
require_once '../controllers/UserController.php';

$employeeController = new EmployeeController($pdo);
$userController = new UserController($pdo); 

$action = $_GET['action'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

function authenticateRequest() {
  $headers = getallheaders();
  $token = isset($headers['Authorization']) ? $headers['Authorization'] : '';

  if (!$token) {
    http_response_code(401);
    echo json_encode(["message" => "No token provided"]);
    exit();
  }

  $decoded = validateJWT($token);
  if (!$decoded) {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized"]);
    exit();
  }
  return $decoded;
}

if ($action === 'authenticate') {
  $data = json_decode(file_get_contents("php://input"), true);
  $email = $data['email'] ?? '';
  $password = $data['password'] ?? '';
    
  $response = $userController->authenticateUser($email, $password);
  echo json_encode($response);
  exit();
}

$decodedToken = authenticateRequest();

switch ($action) {
  case 'createEmployee':
    $data = json_decode(file_get_contents('php://input'), true);
    $employeeController->createEmployee($data);
    echo json_encode(["message" => "¡Empleado creado exitosamente!"]);
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
      echo json_encode(["message" => "Debe ingresar el ID del empleado."]);
    }
  break;

  case 'updateEmployee':
    if ($id) {
      $data = json_decode(file_get_contents('php://input'), true);
      $employeeController->updateEmployee($id, $data);
      echo json_encode(["message" => "¡Empleado actualizado exitosamente!"]);
    } else {
      echo json_encode(["message" => "Debe ingresar el ID del empleado."]);
      }
  break;

  case 'deleteEmployee':
    if ($id) {
      $employeeController->deleteEmployee($id);
      echo json_encode(["message" => "¡Empleado eliminado exitosamente!"]);
    } else {
      echo json_encode(["message" => "Debe ingresar el ID del empleado."]);
    }
  break;

  case 'authenticate':
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
        
    $response = $userController->authenticateUser($email, $password);
    echo json_encode($response);
  break;
    
  case 'getUsers':
    $users = $userController->getUsers();
    echo json_encode($users);
  break;
    
  case 'updatePassword':
    $id = $_POST['id'] ?? null;
    $newPassword = $_POST['newPassword'] ?? '';
    $response = $userController->updatePassword($id, $newPassword);
    echo json_encode($response);
  break;

  case 'createUser':
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $role = $data['role'] ?? null;
    $response = $userController->createUser($email, $password, $role);
    echo json_encode($response);
  break;

  case 'logout':
    echo json_encode(['status' => 'success', 'message' => '¡Sesión cerrada exitosamente!']);
  break;

  default:
    echo json_encode(["message" => "Invalid action"]);
  break;
}
?>