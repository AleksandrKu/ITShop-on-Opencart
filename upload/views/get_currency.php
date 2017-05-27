<?php
require_once(__DIR__ . '/../../upload/bd_pdo.php');
$pdo = new  PDODriver($config['host'], $config['username'], $config['password'], $config['database'], $opt);

$brain_currency = $AP->_currency($session_id);
echo "<h2>Курс $</h2>";
$brain_currency_to_base = [
	'date' => date('Y-m-d H:i:s'),
	'grn_bez' => $brain_currency['currency'][0]->value,
	'grn_nal' => $brain_currency['currency'][1]->value,
	'grn_ddp' => $brain_currency['currency'][2]->value,
];
	$pdo->insert('brain_currency', $brain_currency_to_base);
$sql = "SELECT date, grn_bez, grn_nal, grn_ddp FROM brain_currency ORDER BY id DESC LIMIT 15";
$stm = $pdo->getConnection()->query($sql);
?> <table class="table" style="width: 60%">
	<tr><th>Дата</th>
		<th>Безнал</th>
		<th>Грн. нал</th>
		<th>ДДП</th>  </tr><tr>
<?php
while ($row = $stm->fetch()) {
echo "<tr><td>{$row['date']}</td><td>{$row['grn_bez']}</td><td>{$row['grn_nal']}</td><td>{$row['grn_ddp']}</td>
 </tr>";
} ?>
</table>