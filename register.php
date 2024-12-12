<?php
$servername = "127.0.0.1";
$username = "root";
$password = ""; 
$dbname = "book";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST['name'];
    $lastname = $_POST['surname'];
    $birthdate = $_POST['birthdate']; 
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $sql = "INSERT INTO Авторизация (Логин, Пароль) VALUES ('$login', '$password')";
    
    if ($conn->query($sql) === TRUE) {

        $last_id = $conn->insert_id;


        $sql = "INSERT INTO `Данные пользователя` (`Фамилия`, `Имя`, `Дата_рождения`, `Почта`, `Логин`, `Пароль`) 
                VALUES ('$lastname', '$firstname', '$birthdate', '$email', '$login', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script> 
            alert('Регистрация прошла успешно!'); 
				window.location.href = 'Index.html';
			exit();			
          </script>";
        } else {
			echo "<script> 
            alert('Ошибка при вставке в таблицу Данные пользователя: ' . $conn->error;); 
            window.location.href = 'register.html'; 
          </script>";
        }
    } else {
        echo "Ошибка при вставке в таблицу Авторизация: " . $conn->error;
    }
}

$conn->close();
?>