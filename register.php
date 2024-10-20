<?php
// Подключение к базе данных
$servername = "MySQL-5.7"; // Укажите ваше имя сервера
$username_db = "root"; // Имя пользователя базы данных
$password_db = ""; // Пароль базы данных (пустой для локального сервера, если используется OpenServer или XAMPP)
$dbname = "passwandlogins"; // Имя базы данных

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем данные из формы
$login = $_POST['username']; // Поле username в форме соответствует login в таблице
$email = $_POST['email'];
$password = $_POST['password']; // Пароль сохраняется как есть
$confirm_password = $_POST['confirm_password'];
$phone = ''; // Если поле phone нужно, добавьте его в форму и измените этот код

// Проверяем, чтобы все поля были заполнены
if (empty($login) || empty($email) || empty($password) || empty($confirm_password)) {
    echo "<script>alert('Пожалуйста, заполните все поля.'); window.history.back();</script>";
    exit();
}

// Проверка, совпадают ли пароли
if ($password !== $confirm_password) {
    echo "<script>alert('Пароли не совпадают. Попробуйте снова.'); window.history.back();</script>";
    exit();
}

// Проверка на существующий email в базе данных
$sql_check_email = "SELECT * FROM users WHERE email = ?";
$stmt_check = $conn->prepare($sql_check_email);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "<script>alert('Этот email уже зарегистрирован. Попробуйте другой.'); window.history.back();</script>";
    exit();
}

// Вставляем данные нового пользователя в таблицу, включая пароль без хеширования
$sql = "INSERT INTO users (login, email, phone, pass) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $login, $email, $phone, $password);

// Выполняем запрос и проверяем, удалось ли сохранить пользователя
if ($stmt->execute()) {
    echo "<script>alert('Регистрация прошла успешно!'); window.location.href = 'login.html';</script>";
} else {
    echo "<script>alert('Ошибка при регистрации. Попробуйте позже.'); window.history.back();</script>";
}

// Закрываем соединение
$stmt->close();
$conn->close();
?>
