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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

<style>
    th{ 
        color:#fff;
            }
</style>


    <form method="POST" action="index.php">
        <input type="number" name="date" min="1000" max="9999"/>
        <input type="submit" value="Показать" name="submit"/>
    </form>	
	<table class="table table-striped">
    <tr  class="bg-info">
		<th>id</th>
        <th>first_name</th>
        <th>last_name</th>
        <th>bdate</th>
    </tr>

    <tbody id="myTable">       
    </tbody>
</table>

<?php

$output = Array(); // это массив для возврата в js
$output['success'] = 0; // Пока не получили результат, тут будет отрицательный код обработки
$results = Array();  // это массив с результатами запроса 

if (isset($_POST['submit'])) {
    $number = ($_POST['date']);

    $sql = $conn->prepare("SELECT * FROM users WHERE YEAR(bdate) = :yob");
    if($sql->execute(['yob' => $number]))
    $output['success'] = 1;

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        array_push($results,$row);
    }
    $output['results'] = $results;
}
?>

<script>

var RESULTS = '<?php echo json_encode($output['results']);?>';
	var myArray = $.parseJSON(RESULTS);	
	
	buildTable(myArray)

	function buildTable(data){
		var table = document.getElementById('myTable')

		for (var i = 0; i < data.length; i++){
			var row = `<tr>
							<td>${data[i].id}</td>
							<td>${data[i].first_name}</td>
							<td>${data[i].last_name}</td>
							<td>${data[i].bdate}</td>
					  </tr>`
			table.innerHTML += row

		}
	}

</script>