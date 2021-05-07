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
    </form>

<?php

$output = Array(); // это массив для возврата в js
$output['success'] = 0; // Пока не получили результат, тут будет отрицательный код обработки
$results = Array();  // это массив с результатами запроса 

if (isset($_POST['submit'])) {
    $number = ($_POST['date']);

    $sql = $conn->prepare("SELECT * FROM users WHERE YEAR(bdate) = :yob");
    if($sql->execute(['yob' => $number]))
    $output['success'] = 1;

    echo "<table width='300px'><tr><th>id</th><th>first_name</th><th>last_name</th><th>bdate</th></tr>";

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr align='center'>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['bdate'] . "</td>";
        echo "</tr>";
        array_push($results,$row);
    }
    $output['results'] = $results;
    file_put_contents("output.txt", json_encode($output));
	echo json_encode($output);
    echo "<table>";
}

?>

<script>

        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">

    $(document).ready (function () {
            $("input.submit").on("click", function() {
                var bdateValue =  $('input.date').val();


                $.ajax({                                                                                
                  method: "POST",
                  url: "http://localhost/mywebsite1/index.php",
                  dataType: 'json',
                  data: { date:bdateValue},
                  success: function(response)
            {
                    $("#mytable").empty(); // таблицу результатов предварительно надо очистить. (обратите внимание. в балицу добавлен id!)
                    if(response['success']==0) return; // если success=0 выходим
                    var res = response['results'];
                    $.each(res,function(i,row) { // цикл по строкам
                        var newline=''; //сюда накопим html строки
                        $.each(row,function(i,val) { //цикл по столбцам
                          newline+='<td>'+val+'</td>'; // добавляем ячейку со значением
                        });
                        $("#mytable").append('<tr>'+newline+'</tr>'); // добавляем в таблицу строку
                    });
           }
                })


                 $('input.date').val(); 


            })
    })

    alert('Hello world');

</script>