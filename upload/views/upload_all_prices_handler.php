<?php
require_once(__DIR__ . '/../../upload/bd_pdo.php');
/*$pdo = new  PDODriver($config['host'], $config['username'], $config['password'], $config['database']);*/
if ($_POST['count_for_change_price']) {
	$count_for_change_price = $_POST['count_for_change_price'];
	if ($count_for_change_price == "all") {
		$sql_id = "SELECT  product_id,  name  FROM oc_product_description";
	} else {
		$count_for_change_price = (int)$count_for_change_price;
		$sql_id = "SELECT  product_id,  name  FROM oc_product_description ORDER BY product_id DESC LIMIT  {$count_for_change_price}";
	}
	$stm = $pdo->getConnection()->query($sql_id);
	?>
    <table class="table" style="width: 60% ">
        <tr>
            <th>№</th>
            <th>ID модели</th>
            <th>Модель</th>
            <th>Старая цена</th>
            <th>Новая цена</th>
        </tr>
	<?php
	$n = 1;
	while ($row = $stm->fetch()) {
		$id = $row['product_id'];
		$sql_old_price = "SELECT  price FROM oc_product WHERE product_id = {$id}";
		$old_price = $pdo->getConnection()->query($sql_old_price);
		$row_one = $old_price->fetchColumn();
		$old_price = round(floatval($row_one), 1);
		$product_price = $AP->product_price($session_id, $id);
		$product_price = round(floatval($product_price), 1);
		echo "<tr><td>{$n}</td><td>{$id}</td><td>{$row['name']}</td>
		<td>{$old_price}</td><td> {$product_price}</td></tr>";
		$properties = [
			'price' => $product_price
		];
		$pdo->update('oc_product', 'product_id', $id, $properties);
		$n++;
	}
	echo "</table>";
}