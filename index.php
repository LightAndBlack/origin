<?php

/* 
	1) Установить xampp.
	2) Создать базу данных под названием “fp”, а в ней таблицу “users” с полями id, first_name, last_name.
	3) Заполнить таблицу тремя пользователями.
	4) Написать скрипт, который отображает трех пользователей на экране в виде таблицы.
	5) Добавить поле «bdate» (дата рождения). У первого пользователя будет 01.10.1990, у второго 01.11.1990, у третьего 05.11.1980.
	6) Изменить sql-запрос так, чтобы в таблице выводились только пользователи 1990 года рождения.
	7) Cделать на странице форму с полем для ввода года рождения и кнопкой «Показать». 
	При нажатии на кнопку нужно отобразить только тех пользователей, у кого год рождения совпадает.
	8) Аякс-запрос должен возвращать json-объект со структурой {"success":1, "results":[...]}
	9) В js из полученный через ajax массива нужно собрать таблицу и вставить в страницу.
*/

require_once "db_connect.php";

$number = ($_POST['date'])??'';

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
    <input type="number" value="<?php echo $number;?>" name="date" min="1000" max="9999"/>
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

<script>

	fetch('json.php?date=<?php echo $number; ?>')
	//fetch('output.json')
  .then((response) => {
    return response.json();
  })
  .then((data) => {
    console.log(data);
	buildTable(data.results);
  });

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
