<?php
include 'db.php';
session_start();

// Функція для реєстрації користувача або дитини
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $card_type = $_POST['card_type'];
    $balance = 100.0;  // Початковий баланс
    
    if ($card_type === 'Adult') {
        // Якщо дорослий реєструє дитину разом із собою
        $child_name = $_POST['child_name'];
        $card_color = $_POST['card_color'];
        $limit_amount = $_POST['limit_amount'];

        // Записуємо дані про дорослого і дитину
        $data_adult = ['Adult', $username, $password, $age, $card_type, $balance, '', '', ''];
        $data_child = ['Child', $username, $password, $age, $card_type, $balance, $child_name, $card_color, $limit_amount];

        // Запис у файл
        write_db($data_adult);
        write_db($data_child);

        echo "Дорослий і дитина зареєстровані успішно!";
    } else {
        echo "Реєстрація доступна тільки для дорослих!";
    }
}

// Вхід користувача
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Зчитуємо всі дані з db.txt
    $db_data = read_db();
    
    // Перевіряємо, чи існує користувач з такими даними
    foreach ($db_data as $user) {
        if ($user[1] == $username && $user[2] == $password) {
            $_SESSION['username'] = $username;
            header('Location: account.php');
            exit;
        }
    }

    echo "Невірний логін або пароль!";
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pono Bank</title>
    <script>
        // Функція для показу полів додавання дитини, якщо користувач дорослий
        function toggleChildFields() {
            var cardType = document.getElementById('card_type').value;
            var childFields = document.getElementById('child_fields');
            if (cardType === 'Adult') {
                childFields.style.display = 'block';
            } else {
                childFields.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <h2>Вхід або реєстрація</h2>

    <form action="" method="POST">
        <label>Ім'я користувача:</label><br>
        <input type="text" name="username" required><br>

        <label>Пароль:</label><br>
        <input type="password" name="password" required><br>

        <label>Вік:</label><br>
        <input type="number" name="age" required><br>

        <label>Тип карти:</label><br>
        <select name="card_type" id="card_type" onchange="toggleChildFields()" required>
            <option value="Adult">Карта для дорослих</option>
        </select><br><br>

        <!-- Поля для реєстрації дитини -->
        <div id="child_fields" style="display: none;">
            <h3>Додати дитину:</h3>

            <label>Ім'я дитини:</label><br>
            <input type="text" name="child_name"><br>

            <label>Колір карти дитини:</label><br>
            <select name="card_color">
                <option value="Red">Червоний</option>
                <option value="Blue">Синій</option>
                <option value="Green">Зелений</option>
                <option value="Yellow">Жовтий</option>
            </select><br>

            <label>Ліміт на перекази для дитини (PON):</label><br>
            <input type="number" name="limit_amount" value="50"><br>
        </div><br>

        <button type="submit" name="login">Увійти</button>
        <button type="submit" name="register">Реєстрація</button>
    </form>
</body>
</html>
