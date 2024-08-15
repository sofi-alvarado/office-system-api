<?php
  use \Firebase\JWT\JWT;
  use Firebase\JWT\Key;

  require_once '../config/config.php';

  function generateJWT($user_id,  $role) {
    $secretKey = $_ENV['SECRET_KEY'];
    $issuedAt = time();
    $expiration = $issuedAt + 3600;

    $payload = [
      'iat' => $issuedAt,
      'exp' => $expiration,
      'userId' => $user_id,
      'role' => $role
    ];

    return JWT::encode($payload, $secretKey,'HS256');
  }

  function validateJWT($token) {
    $secretKey = $_ENV['SECRET_KEY'];
    try {
      $token = str_replace('Bearer ', '', $token);
      $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
      return (array) $decoded;
    } catch (Exception $e) {
      http_response_code(401);
      echo json_encode(["message" => "Unauthorized"]);
      exit();
    }
  }
  
?>
