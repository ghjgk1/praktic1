<?php
// Подключение к базе данных
$servername = "localhost"; // Имя сервера
$username = "root";        // Имя пользователя БД
$password = "";            // Пароль пользователя БД
$dbname = "book";       // Имя базы данных

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем параметр поиска из формы
    $search = $conn->real_escape_string($_POST['search']);

    // SQL-запрос для поиска книги
    $sql = "SELECT * FROM Книги WHERE Наименование LIKE '%$search%' OR Автор LIKE '%$search%' OR Жанр LIKE '%$search%' OR Год_издания LIKE '%$search%' OR Издательство LIKE '%$search%'";
    $result = $conn->query($sql);

    // Проверяем, есть ли результаты
    if ($result->num_rows > 0) {
        /*while ($row = $result->fetch_assoc()) {
        echo "<script> 
        alert('\\nID: {$row["ID"]}\\nНаименование: {$row["Наименование"]}\\nАвтор: {$row["Автор"]}\\nЖанр: {$row["Жанр"]}\\nГод издания: {$row["Год_издания"]}\\nИздательство: {$row["Издательство"]}'); 
                    window.location.href = 'datawatch.html';
      </script>";
      exit();	}*/		
        // Выводим данные о книгах
        echo "<h2>Результаты поиска:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Номер</th>
                    <th>Наименование</th>
                    <th>Автор</th>
                    <th>Жанр</th>
                    <th>Год издания</th>
                    <th>Издательство</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["ID"] . "</td>
                    <td>" . $row["Наименование"] . "</td>
                    <td>" . $row["Автор"] . "</td>
                    <td>" . $row["Жанр"] . "</td>
                    <td>" . $row["Год_издания"] . "</td>
                    <td>" . $row["Издательство"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Книги не найдены.</p>";
    }
}

// Закрываем подключение
$conn->close();
?>