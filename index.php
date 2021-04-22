<?php

require_once "db_connect.php";

$sql = "SELECT * FROM `users` WHERE `bdate` BETWEEN '1990-01-01' AND '1990-12-31'";
$result = $conn->query($sql);

echo "<table width='300px'><tr><th>id</th><th>first_name</th><th>last_name</th><th>bdate</th></tr>";

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr align='center'>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['first_name'] . "</td>";
    echo "<td>" . $row['last_name'] . "</td>";
    echo "<td>" . $row['bdate'] . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "<br>";

?>

    <form method="POST" action="index.php">
        <input type="number" name="date" min="1000" max="9999"/>
        <input type="submit" value="Показать" name="submit"/>
        <input type="text" name="text"> <!-- Проверка для экранирования -->
    </form>

<?php

if (isset($_POST['submit'])) {
    $number = ($_POST['date']);
    $text = ($_POST['text']); echo $text;// <script>alert("hi");</script> для проверки на экранирование, а как это связать с PDO prepare 42 строка???
    echo "<br>";

//    $sql = "SELECT * FROM `users` WHERE `bdate` LIKE'$number%'";
    $sql = $conn -> prepare("SELECT * FROM `users` WHERE `bdate` LIKE'$number%'");
    $sql -> execute();
    //    $sql = $conn ->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
//        $sql = $conn ->prepare("SELECT * FROM `users` WHERE `bdate` LIKE'$number%'");
//        $sql -> execute();
//    $sql ->execute(array('3'));
//    $array = $sql->fetch(PDO::FETCH_ASSOC);
//    $result =$conn->query($sql);
//    $sql =$conn->query($sql);

    //https://tproger.ru/translations/how-to-configure-and-use-pdo/
    //Подготовленные запрос
//    $date = $conn->prepare("INSERT INTO users(bdate) VALUES(?, ?)");

    echo "<table width='300px'><tr><th>id</th><th>first_name</th><th>last_name</th><th>bdate</th></tr>";

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr align='center'>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['bdate'] . "</td>";
        echo "</tr>";
    }
    echo "<table>";
}
?>
