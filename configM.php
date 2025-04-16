<?php
$host = 'localhost';         
$user = 'root';      
$password = '';  
$database = 'bushin_205s1';


$mysqli = new mysqli($host, $user, $password, $database);


if ($mysqli->connect_error) {
            die('Ошибка подключения (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
}
?>
