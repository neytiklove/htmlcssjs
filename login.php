<?php
// Подключение к базе данных
$servername = "MySQL-5.7"; // Имя вашего сервера
$username_db = "root"; // Имя пользователя базы данных
$password_db = ""; // Пароль базы данных (обычно пустой для OpenServer или XAMPP)
$dbname = "passwandlogins"; // Имя базы данных

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем данные из формы
$email = $_POST['email'];
$password = $_POST['password'];

// Проверяем, чтобы поля были заполнены
if (empty($email) || empty($password)) {
    echo "<script>alert('Пожалуйста, заполните все поля.'); window.history.back();</script>";
    exit();
}

// Поиск пользователя по email
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Проверка, существует ли пользователь с таким email
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Сравнение введённого пароля с паролем из базы данных (пароль в открытом виде)
    if ($password === $user['pass']) {
        // Если пароль совпадает, то пользователь залогинен
        session_start();
        $_SESSION['user_id'] = $user['id']; // Сохраняем ID пользователя в сессии
        $_SESSION['login'] = $user['login']; // Сохраняем логин пользователя

        echo "<script>alert('Вход выполнен успешно!'); window.location.href = 'index.html';</script>";
        exit();
    } else {
        // Если пароли не совпадают
        echo "<script>alert('Неправильный пароль. Попробуйте снова.'); window.history.back();</script>";
        exit();
    }
} else {
    // Если пользователь с таким email не найден
    echo "<script>alert('Пользователь с таким email не найден.'); window.history.back();</script>";
    exit();
}

// Закрываем соединение
$stmt->close();
$conn->close();
?>
