<?php

require_once "db_connect.php";

$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);
$rows = mysqli_num_rows($result);

echo "<table width='300px'><tr><th>id</th><th>first_name</th><th>last_name</th></tr>";

for ($i = 0; $i < $rows; ++$i) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr align='center'>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "</tr>";
    }
}
echo "</table>";
?>