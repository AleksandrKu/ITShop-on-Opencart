<?php
/*require_once('../../config.php');*/
require_once(__DIR__ . '/../../upload/bd_pdo.php');
ini_set('max_execution_time', 600); //300 seconds = 5 minutes
ini_set("memory_limit", "1000M");
?>

    <div style="width: 60%; font-size: large; padding: 10px; border: 1px solid gray; border-radius: 6px; text-align: center" id="form">
    Загрузка прайса в базу
        <form method="POST" ENCTYPE="multipart/form-data">
            <div class="row" style="margin: 20px; text-align: center">
                <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
                <input style="float: left; padding: 5px" name="fileToUpload" type="file" value="File">
                <input style="float: left" type="submit" value="Загрузить в базу" name="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
<?php
$opt = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new  PDODriver($config['host'], $config['username'], $config['password'], $config['database'], $opt);
$pdo2 = new  PDODriver($config['host'], $config['username'], $config['password'], $config['database'], $opt);


if (!empty($_FILES['fileToUpload']['name'])) {
	$pdo->delete('brain');
	require_once "Classes/PHPExcel.php";
	$tmpfname2 = $_FILES['fileToUpload']['tmp_name'];
	$downloadFileName = $_FILES['fileToUpload']['tmp_name'];
	$filecontent = file_get_contents($downloadFileName);
	$tmpfname = tempnam(sys_get_temp_dir(), "tmpxls");
	file_put_contents($tmpfname, $filecontent);
	date_default_timezone_set('Europe/Kiev');
	$date = date("d.m.Y__H:i");
	$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
	$excelObj = $excelReader->load($tmpfname);
	$worksheet = $excelObj->getSheet(0);
	echo $lastRow = $worksheet->getHighestRow();// колличество строк
	$post = 'brain';
	 for ($row = 2; $row <= $lastRow; $row++) {
		// формируем массив: ключ это имя поля таблицы , значение это значение поля
		 $from_array_price_brain = [
			 'id_item' => $row,
			 'cat_id' => $worksheet->getCell('A' . $row)->getValue(),
			 'code' => $worksheet->getCell('B' . $row)->getValue(),
			 'group_' => $worksheet->getCell('C' . $row)->getValue(),
			 'article' => $worksheet->getCell('D' . $row)->getValue(),
			 'vendor' => $worksheet->getCell('E' . $row)->getValue(),
			 'model' => $worksheet->getCell('F' . $row)->getValue(),
			 'name' => $worksheet->getCell('G' . $row)->getValue(),
			 'description' => $worksheet->getCell('H' . $row)->getValue(),
			 'priceusd' => $worksheet->getCell('I' . $row)->getValue(),
			 'categoryname' => $worksheet->getCell('K' . $row)->getValue(),
			 'recommendedprice' => $worksheet->getCell('M' . $row)->getValue(),
			 'ddp' => $worksheet->getCell('N' . $row)->getValue(),
			 'warranty' => $worksheet->getCell('O' . $row)->getValue(),
			 'stock' => $worksheet->getCell('P' . $row)->getValue(),
			 'daydelivery' => $worksheet->getCell('R' . $row)->getValue(),
			 'productid' => $worksheet->getCell('S' . $row)->getValue(),
			 'url' => $worksheet->getCell('T' . $row)->getValue(),
			 'groupid' => $worksheet->getCell('V' . $row)->getValue(),
			 'classid' => $worksheet->getCell('W' . $row)->getValue(),
			 'classname' => $worksheet->getCell('X' . $row)->getValue(),
			 'available' => $worksheet->getCell('Y' . $row)->getValue(),
			 'country' => $worksheet->getCell('Z' . $row)->getValue(),
			 'retailprice' => $worksheet->getCell('AA' . $row)->getValue()
		 ];

		 $pdo->insert('brain', $from_array_price_brain);
	 }
	/*$login_password_to_suppliers = [
		'id_supplier' => '10',
		'login' => 'homox@mail.ru',
		'password' => '',
		'supplier' => 'https://brain.com.ua/login'];
	$pdo->insert('brain', $login_password_to_suppliers);*/
} else { ?>
    <br><div style="font-size: large">
	 <strong> Количество позиций в базе:</strong>


    <?php
	$sql_2 = "SELECT  id_item  FROM brain  ORDER BY id_item DESC LIMIT 1";
	$obj = $pdo->getConnection()->query($sql_2)->fetchObject();
	echo $obj->id_item; echo "шт <br>";
	?> <br> <table class="table" style="width: 60%">
        <tr><th>№</th>
            <th>ID </th>
            <th>Категория</th>
            <th>шт</th>
        <?php
	$sql_2 = "SELECT  group_, vendor, categoryname, cat_id    FROM brain  GROUP BY categoryname ORDER BY categoryname ASC ";
	$stm_2 = $pdo->getConnection()->query($sql_2);
	$n=1;
	while ($row = $stm_2 ->fetch())
	{
		echo "</tr><td>{$n}</td></td><td>".$row['cat_id']."</td><td>  ".$row['categoryname']."</td>";
		$sql_quantity = "SELECT  count(*) AS number   FROM brain WHERE cat_id =  {$row['cat_id']}";
		$obj = $pdo->getConnection()->query($sql_quantity)->fetchObject();
		echo "<td>".($obj->number); echo "</td></tr>";
		$n++;
	}

    } ?></table>
</div>
