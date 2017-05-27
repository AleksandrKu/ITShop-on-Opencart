<h2>Получить информацию по ID продукта.</h2>
<form method="post" >
	<div class="input-group" style="font-size: large">
			<!--<input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">-->
		<input type="text" name= "product_id" placeholder="product id" style="margin-right: 5px">
		<input type="submit" value= "Отправить">
	</div>

</form>
<?php
if ($_POST['product_id']) {
	$product_id = $_POST['product_id'];
	require_once('bd_pdo.php');
/*echo "<br>Номер одесского склада 3620<br>";*/
echo "<br><h3>Информация о продукте  по ID = {$product_id}</h3>" ;
$AP = new apiplus();
$session_id = $AP->_api_auth($login, $password);

$product = $AP->_product($session_id, $product_id);

echo "<div style='font-size: large'><b>Photo :</b> {$product->large_image}<br>";
echo "<b>Product Code :</b> {$product->product_code}<br>";
echo "<b>Name :</b> {$product->name}<br>";
echo "<b>Retail price :</b> {$product->retail_price_uah}<br>";

if ($product->stocks_expected) { echo "<b>Есть в наличии</b> </div>";  var_dump($product->stocks_expected); } else { echo "<span style='color: red'>Нет в наличии</span><br>"; }
echo "<br>";echo "<br>"; echo "<br>";echo "<br>";
	var_dump($product);

/*$product1 = $AP->_product($session_id, '275078');
if ($product1->stocks_expected) { var_dump($product1->stocks_expected); echo $product1->product_code; } else { echo "empty {$product1->product_code}"; }
echo "<br>";
echo "<br>";
$product2 = $AP->_product($session_id, '222130');
if ($product2->stocks_expected) { var_dump($product2->stocks_expected); echo "empty {$product2->product_code} "; } else {  echo "empty {$product2->product_code} ";  }
echo "<br>";*/
}