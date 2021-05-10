<?php

require_once "db_connect.php";

$output = Array(); // это массив для возврата в js
$output['success'] = 0; // Пока не получили результат, тут будет отрицательный код обработки
$results = Array();  // это массив с результатами запроса 


    $number = ($_GET['date']);

    $sql = $conn->prepare("SELECT * FROM users WHERE YEAR(bdate) = :yob");
    if($sql->execute(['yob' => $number]))
    $output['success'] = 1;

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        array_push($results,$row);
    }
    $output['results'] = $results;

header('Content-Type: application/json');//сообщили браузеру что в ответе json mime type
echo json_encode($output, JSON_PRETTY_PRINT);
?>