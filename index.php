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

<form method="GET" action = "index.php">
    <input type="date" name="date" />
    <input type="submit" value="Показать" name="submit" />
</form>

<?php

session_start();

if (isset($_REQUEST['submit'])) {
    $number = $_REQUEST['number'];
    $sql = "SELECT * FROM `users` WHERE `bdate` LIKE'$number%'";
    $result = $conn->query($sql);
    echo $result;
}

?>