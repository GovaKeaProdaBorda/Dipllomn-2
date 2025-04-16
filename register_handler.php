<?php include 'configM.php'; 

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password_raw = $_POST['password'];
$registration_date = date('Y-m-d');
$role = 'user';


$password_hashed = md5(sha1($password_raw));


$query = "SELECT * FROM users WHERE email = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    echo 'Пользователь с таким email уже существует!';
} else {
    $stmt = $mysqli->prepare("INSERT INTO users (name, email, password, registration_date, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $name, $email, $password_hashed, $registration_date, $role);


    if ($stmt->execute()) {
        echo '<script>
                alert("Регистрация прошла успешно!");
                window.location.href = "autorization.php";
              </script>';
    } else {
        echo 'Ошибка: ' . $mysqli->error;
    }
}


$stmt->close();
$mysqli->close();
?>
