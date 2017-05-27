<?php
/*require_once(__DIR__ . '/../../upload/bd_pdo.php');
$pdo = new  PDODriver($config['host'], $config['username'], $config['password'], $config['database'], $opt);*/
/*if (!$_POST && !empty($_POST)) {
	echo $count_for_change_price = $_POST['count_for_change_price'];
}*/
?>
<h2>Обновление цен</h2>

<div class="list-group" style="width: 20%; font-size: large">
    <button type="button" class="list-group-item up_price" value="all" id="all">Обновить все цены</button>
    <button type="button" class="list-group-item up_price" value="20">Обновить 20</button>
    <button type="button" class="list-group-item up_price" value="5">Обновить 5</button>
</div>
<img src="/upload/views/preloader.gif" style="margin-right: 50px" class="hidden" id="loading" alt="loading" >
<div id="result">
</div>

