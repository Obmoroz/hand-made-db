<?php
echo "1";

require_once 'db.php'; // подключаем скрипт

// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database)
or die("Ошибка " . mysqli_error($link));
// выполняем операции с базой данных
$query ="SELECT * FROM item_quan";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
if($result)
{

        $rows = mysqli_num_rows($result); // количество полученных строк

        echo "<table><tr><th>Id</th><th>Название</th><th>Колличество</th></tr>";
        for ($i = 0 ; $i < $rows ; ++$i)
        {
            $row = mysqli_fetch_row($result);
            echo "<tr>";
            for ($j = 0 ; $j < 3 ; ++$j) echo "<td>$row[$j]</td>";
            echo "</tr>";
        }
        echo "</table>";

        // очищаем результат
        mysqli_free_result($result);




    echo "Выполнение запроса прошло успешно";
    var_dump($result);

}
// закрываем подключение
mysqli_close($link);









?>




