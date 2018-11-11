<?php

require __DIR__ . '\..\vendor\autoload.php';
require_once 'db.php'; // подключаем файл конфигурации БД
require_once 'preparedata.php'; // подключаем скрипт содержащий пользовательские функции
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// Проверяем загружен ли файл
if(is_uploaded_file($_FILES['filename']['tmp_name']))
{
    // Если файл загружен успешно, перемещаем его
    // из временной директории в конечную
    var_dump($_FILES['filename']);
    var_dump(move_uploaded_file($_FILES['filename']['tmp_name'], __DIR__ .'\..\upload\upload.xlsx'));
} else {
    echo('Ошибка загрузки файла');
}
//открытие файла библиотекой
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load(__DIR__ . '\..\upload\upload.xlsx');
$reader->setReadDataOnly(TRUE);
$worksheet = $spreadsheet->getActiveSheet();

//создаине коннекта с БД
$dsn = "mysql:host=$host;dbname=$database;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);

//обьявление колонок из которых будут забираться занчения
$nameColumn = 'A';
$QuantityColumn = 'F';
$lastRow = $worksheet->getHighestRow();//забираем файлик
for ($row = 1; $row <= $lastRow; $row++) {
    $cell = $worksheet->getCell($nameColumn.$row);
    $cellvalue=$cell->getValue();
    if ($cellvalue===NULL){continue;}
    // нахождения названия товара
    if (strpos($cellvalue, ', шт')>0){
        $attrname=cutAndEncodetoUTF($cellvalue);// Перекодирование строки и обрезка ШТ.
        $Quantity = $worksheet->getCell($QuantityColumn.$row)->getValue();// забор значения колличества товара
        $stmt = $pdo->prepare('UPDATE oc_product SET quantity=? WHERE sku LIKE ?');
        if ($stmt->execute([$Quantity,$attrname])){
            echo "Выполнение запроса прошло успешно". "\n";
        }
        else{
            echo "Ошибка";
        }

    }

}
$pdo=null;
// закрываем подключение
//mysqli_close($link);



/*foreach ($worksheet->getRowIterator() as $row) {
    echo '<tr>' . PHP_EOL;
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
    //    even if a cell value is not set.
    // By default, only cells that have a value
    //    set will be iterated.
    foreach ($cellIterator as $cell) {
        echo '<td>' .
            $cell->getValue() .
            '</td>' . PHP_EOL;
    }
    echo '</tr>' . PHP_EOL;
}
echo '</table>' . PHP_EOL;*/

/*$link = mysqli_connect($host, $user, $password, $database)
or die("Ошибка " . mysqli_error($link));

$query ="SELECT * FROM oc_product";



$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
if($result)
{

        $rows = mysqli_num_rows($result); // количество полученных строк

    echo '<html>';
 echo ' <head>';
  echo ' <title>description</title>';
   echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> ';
   echo '<meta name="description" content="Сайт об HTML и создании сайтов"> ';
  echo '</head> ';
  echo '<body>';
    echo '<h1>nen</h1>>';

        echo "<table><tr><th>Id</th><th>Название</th><th>Колличество</th></tr>";
        for ($i = 0 ; $i < $rows ; ++$i)
        {
            $row = mysqli_fetch_row($result);
            echo "<tr>";
            for ($j = 0 ; $j < 3 ; ++$j) echo "<td>$row[$j]</td>";
            echo "</tr>";
        }
        echo "</table>";
    echo '</body>';
echo '</html>';

        // очищаем результат
        mysqli_free_result($result);*/


?>




