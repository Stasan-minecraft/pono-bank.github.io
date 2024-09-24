<?php
// Функція для зчитування всіх даних з db.txt
function read_db() {
    $file = fopen("db.txt", "r");
    $data = [];
    while (($line = fgetcsv($file)) !== FALSE) {
        $data[] = $line;
    }
    fclose($file);
    return $data;
}

// Функція для запису нових даних у db.txt
function write_db($data) {
    $file = fopen("db.txt", "a");
    fputcsv($file, $data);
    fclose($file);
}

// Функція для конвертації PON в гривні
function convert_pon_to_uah($pon) {
    $uah_rate = 37.5;
    return $pon * $uah_rate;
}
?>