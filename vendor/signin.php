<?php
session_start();

require_once 'StaticConnection.php';

$login = $_POST['login'];
$password = $_POST['password'];

$error_fields = [];

if ($login === '') {
    $error_fields[] = 'login';
}

if ($password === '') {
    $error_fields[] = 'password';
}

if (!empty($error_fields)) {
    $response = [
        "status" => false,
        "type" => 1,
        "message" => "Проверьте правильность полей",
        "fields" => $error_fields
    ];

    echo json_encode($response);

    die();
}

$password = md5($password);

$db = StaticConnection::getConnection();
$sth = $db->prepare("SELECT * FROM users WHERE login = :login AND password = :password");
$sth->bindParam(':login', $login, PDO::PARAM_STR);
$sth->bindParam(':password', $password, PDO::PARAM_STR);
$sth->execute();

if ($sth->rowCount() > 0) {

    $user = $sth->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user'] = [
        "id" => $user['id'],
        "full_name" => $user['full_name'],
        "email" => $user['email']
    ];

    $response = [
        "status" => true
    ];

    echo json_encode($response);

} else {

    $response = [
        "status" => false,
        "message" => 'Не верный логин или пароль'
    ];

    echo json_encode($response);
}
?>
