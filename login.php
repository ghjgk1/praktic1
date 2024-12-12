<?php 
$servername = "127.0.0.1"; // или ваш сервер 
$username = "root"; // замените на ваше имя пользователя 
$password = ""; // замените на ваш пароль 
$dbname = "book"; // замените на имя вашей базы данных 

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname); 

// Проверяем соединение
if ($conn->connect_error) { 
    die("Ошибка подключения: " . $conn->connect_error); 
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $login = $_POST['login']; 
    $password = $_POST['password']; // Получаем пароль без хеширования

    // Подготовленный запрос
    $stmt = $conn->prepare("SELECT `Пароль` FROM `Авторизация` WHERE `Логин` = ?");
    $stmt->bind_param("s", $login); // Привязываем параметр

    // Выполняем запрос
    $stmt->execute();
    $result = $stmt->get_result(); 

    if ($result->num_rows > 0) { 
        $row = $result->fetch_assoc(); 
        // Проверяем пароль
        if (password_verify($password, $row['Пароль'])) { 
            header("Location: datawatch.html"); // Перенаправляем на следующую страницу
            exit(); 
        } else { 
            echo "<script>alert('Неправильный пароль'); window.location.href = 'Index.html';</script>"; 
        } 
    } else { 
        echo "<script>alert('Такого логина нет, зарегистрируйтесь'); window.location.href = 'Index.html';</script>"; 
    } 

    // Закрываем подготовленный запрос
    $stmt->close();
} 

// Закрываем соединение
$conn->close();
?>