<?php
include 'configM.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5(sha1($_POST['password']));

    $sql = "SELECT id, password, role FROM users WHERE email = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hashed_password, $role);
            $stmt->fetch();

            if ($password === $hashed_password) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['role'] = $role;
                header("Location: index.php");
                exit;
            } else {
                echo '<script>
                        alert("Пароль неверен!");
                        window.location.href = "autorization.php";
                      </script>';
            }
        } else {
            echo '<script>
                    alert("Неверный email или пароль.");
                    window.location.href = "autorization.php";
                  </script>';
        }
        $stmt->close();
    } else {
        die("Ошибка при подготовке запроса: " . $mysqli->error);
    }
}
?>
