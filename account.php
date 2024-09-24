<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];

// Зчитуємо всі дані з db.txt
$db_data = read_db();

// Витягуємо інформацію про користувача та його дітей
$user_data = [];
$children_data = [];

foreach ($db_data as $user) {
    if ($user[1] == $username && $user[0] == 'Adult') {
        $user_data = $user;
    } elseif ($user[1] == $username && $user[0] == 'Child') {
        $children_data[] = $user;
    }
}

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Акаунт - Pono Bank</title>
</head>
<body>
    <h2>Ласкаво просимо, <?php echo $username; ?>!</h2>
    <p>Ваш баланс: <?php echo $user_data[5]; ?> PON (<?php echo convert_pon_to_uah($user_data[5]); ?> грн)</p>

    <h3>Ваша дитина:</h3>
    <?php if (!empty($children_data)): ?>
        <ul>
            <?php foreach ($children_data as $child): ?>
                <li><?php echo $child[6]; ?> (Колір карти: <?php echo $child[7]; ?>, Ліміт: <?php echo $child[8]; ?> PON)</li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Немає доданих дітей.</p>
    <?php endif; ?>
</body>
</html>
