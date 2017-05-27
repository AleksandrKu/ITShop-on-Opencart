<?php

require_once('bd_pdo.php');

//phpinfo();
// ***************** вытаскиваем из базы  логин и пароль  нашего постащика *******************************
/*$opt = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
];
$id = 1; // id компании поставщика, это  Brain
$pdo = new  PDODriver($config['host'], $config['username'], $config['password'], $config['database'], $opt);
$sql = $pdo->getConnection()->prepare("SELECT * FROM login_password_to_suppliers WHERE id_supplier=:id");
$sql->execute(array('id' => $id));
$result = $sql->fetch(PDO::FETCH_ASSOC);
//var_dump($result);
echo "<br>";
echo $login = $result['login'];
echo "<br>";
echo $password = $result['password'];
echo "<br>";
/*$supplier = $result['supplier'];*/
// ***************** КОНЕЦ   вытаскиваем из базы  логин и пароль  нашего постащика *******************************

// authorize to get SID
/*$AP = new apiplus();
$session_id = $AP->_api_auth($login, $password);
echo $session_id;*/

/*начало кода по выводу ******************************************************************************************
echo mb_internal_encoding();  // возвращала в непонятной кодировке , не смог преобразовать, нашел в интернете массив преобразования и прошелся по всему сообщению
$session_id = get_session_id(1, $config, $opt); // получении идентификатора сессии   1- BRAIN
$url = "http://api.brain.com.ua/targets/".$session_id;
// инициализация сеанса
$ch_stock = curl_init();
// установка URL и других необходимых параметров
curl_setopt($ch_stock, CURLOPT_RETURNTRANSFER, 1); //результатответа не віводить на єкран
curl_setopt($ch_stock, CURLOPT_TRANSFERTEXT, 1); //выводит в виде строки
curl_setopt($ch_stock, CURLOPT_URL, $url);
// загрузка страницы и выдача её браузеру
$output_stock = curl_exec($ch_stock);
function escape_win ($path) {
	$path = strtoupper ($path);
	return strtr($path, array("\U0430"=>"а", "\U0431"=>"б", "\U0432"=>"в",
		"\U0433"=>"г", "\U0434"=>"д", "\U0435"=>"е", "\U0451"=>"ё", "\U0436"=>"ж", "\U0437"=>"з", "\U0438"=>"и",
		"\U0439"=>"й", "\U043A"=>"к", "\U043B"=>"л", "\U043C"=>"м", "\U043D"=>"н", "\U043E"=>"о", "\U043F"=>"п",
		"\U0440"=>"р", "\U0441"=>"с", "\U0442"=>"т", "\U0443"=>"у", "\U0444"=>"ф", "\U0445"=>"х", "\U0446"=>"ц",
		"\U0447"=>"ч", "\U0448"=>"ш", "\U0449"=>"щ", "\U044A"=>"ъ", "\U044B"=>"ы", "\U044C"=>"ь", "\U044D"=>"э",
		"\U044E"=>"ю", "\U044F"=>"я", "\U0410"=>"А", "\U0411"=>"Б", "\U0412"=>"В", "\U0413"=>"Г", "\U0414"=>"Д",
		"\U0415"=>"Е", "\U0401"=>"Ё", "\U0416"=>"Ж", "\U0417"=>"З", "\U0418"=>"И", "\U0419"=>"Й", "\U041A"=>"К",
		"\U041B"=>"Л", "\U041C"=>"М", "\U041D"=>"Н", "\U041E"=>"О", "\U041F"=>"П", "\U0420"=>"Р", "\U0421"=>"С",
		"\U0422"=>"Т", "\U0423"=>"У", "\U0424"=>"Ф", "\U0425"=>"Х", "\U0426"=>"Ц", "\U0427"=>"Ч", "\U0428"=>"Ш",
		"\U0429"=>"Щ", "\U042A"=>"Ъ", "\U042B"=>"Ы", "\U042C"=>"Ь", "\U042D"=>"Э", "\U042E"=>"Ю", "\U042F"=>"Я"));
}
$convertedText = escape_win($output_stock);
$output_array = explode("TARGETID", $convertedText);
var_dump($output_array);
curl_close($ch_stock);

Конец кода по ввыводу номера склада     *************************************************************************** */
/*echo "<br>Номер одесского склада 3620<br>";*/
$AP = new apiplus();
$session_id = $AP->_api_auth($login, $password);

$product = $AP->_product($session_id, '220153');
var_dump($product->large_image); echo "<br>";
if ($product->stocks_expected) { var_dump($product->stocks_expected); echo  $product->product_code; } else { echo "empty {$product->product_code}"; }
echo "<br>";echo "<br>";
$product1 = $AP->_product($session_id, '275078');
if ($product1->stocks_expected) { var_dump($product1->stocks_expected); echo $product1->product_code; } else { echo "empty {$product1->product_code}"; }
echo "<br>";
echo "<br>";
$product2 = $AP->_product($session_id, '222130');
if ($product2->stocks_expected) { var_dump($product2->stocks_expected); echo "empty {$product2->product_code} "; } else {  echo "empty {$product2->product_code} ";  }
echo "<br>";

// *****************  get CATEGORIES and upload to database itshop ****************************************************
/*$categories = $AP->_categories($session_id);
// вставить в таблицу значения
foreach ($categories['categories'] as $category_to_base) {
	$categories_brain = [
		'categoryID' => $category_to_base->categoryID,
		'parentID' => $category_to_base->parentID,
		'realcat' => $category_to_base->realcat,
		'name' => $category_to_base->name
];
$pdo->insert('brain_categories', $categories_brain);
}*/


// ******************  get VENDORS  and upload to database itshop  ****************************************************
// 7251 строк получилось .
// Можно делать запрос http://api.brain.com.ua/vendors/[categoryID/]SID для каждой категории отдельно, но не работает
/*$brain_vendors = $AP->_vendors($session_id);
foreach ($brain_vendors['vendors'] as $to_base) {
	$brain_vendors_to_base = [
		'vendorID' => $to_base->vendorID,
		'name' => $to_base->name,
		'categoryID' => $to_base->categoryID
	];
	$pdo->insert('brain_vendors', $brain_vendors_to_base);
}*/
//**********************************************************************************************************************


// **********  get CURRENCIES and upload to database itshop  **********************************************************
/*$brain_currency = $AP->_currency($session_id);
var_dump($brain_currency['currency']);
foreach ($brain_currency['currency'] as $to_base) {
	$brain_currency_to_base = [
		'currencyID' => $to_base->currencyID,
		'name' => $to_base->name,
		'value' => $to_base->value
	];
	//$pdo->insert('brain_currency', $brain_currency_to_base);
}*/
//***********************************************************************************************************************

//получить идентификаторы продуктов, содержащихся в категории.
// get product IDs in category (second parameter is the categoryID 1191)
//выводит в кратком описании, но все что я вижу вне склада, какое свойство отвечает за наличие на складе не определил.
// Таблицу под это еще не создавал
/*$prod_ids = $AP->_prod_ids_category($session_id,7743);
var_dump($prod_ids['products']->list);*/



//По этим идентификаторам продуктов можно получить и сами продукты:
// get product from remote server by product ID
/*$prod_id = 2028;
 $product = $AP->_product($session_id, $prod_id);
var_dump($product);
var_dump($product->small_image);
/*var_dump($product->medium_image);
var_dump($product->large_image);*/

/*if (!empty($product->small_image))    // получение фото продукта по URI
{
	$imgdir = './images/';
	$img = $product->small_image;
	$ret = $AP->_download_image($img,$imgdir.basename($img));
	if ($ret){
		$imgs[] = basename($img); // name of downloaded image
		$imgsss = basename($img); // name of downloaded image
	}
	$imgs = array();*/
//echo $img; echo"<br>";
//echo basename($img);
/*	foreach ($product->images as $img)
	{
		// first parameter - image URI
		// second parameter - path to file, where image should be downloaded
 	$imgdir = './images/';
	 	$ret = $AP->_download_image($img,$imgdir.basename($img));
	 	if ($ret){
			$imgs[] = basename($img); // name of downloaded image
			$imgsss = basename($img); // name of downloaded image
		}
	}*/
/*	$product->images = $imgsss; // array of downloaded images
	echo "<br>";
	 var_dump($imgs);
}*/

/*$down = new DownloadImages();
$down->download_image_from_brain($session_id, '2037');*/

// Получение фильтров по идентификатору категории:
// get product from remote server by category ID
/*$categoryID = 1191;
$filters_all = $AP->_filters_all($session_id,$categoryID);
var_dump($filters_all);*/

//Получение розничного прайса.
// get retail prices
//$prices_retail = $AP->_prices_opt($session_id);
//var_dump($prices_retail);
















// Метод для получения ссылки на прайслист *********************************************************************************************************************
/*$url_price = "http://api.brain.com.ua/pricelists/3620/xlsx/".$session_id."?full=1";*/
/*$url_price = "http://api.brain.com.ua/pricelists/3620/xlsx/".$session_id."?full=1";
// инициализация сеанса
$ch_price_link = curl_init();
// установка URL и других необходимых параметров
curl_setopt($ch_price_link, CURLOPT_RETURNTRANSFER, 1); //результат ответа не выводить на экран
curl_setopt($ch_price_link, CURLOPT_TRANSFERTEXT, 1); //выводит в виде строки
curl_setopt($ch_price_link, CURLOPT_URL, $url_price);
// загрузка страницы и выдача её браузеру
$price_link = curl_exec($ch_price_link);
curl_close($ch_price_link);
$js_ = json_decode($price_link);


$array_link = explode("\"",$price_link);
$link_to_file = preg_replace("/[\\\]/", '', $array_link[5]);
var_dump($link_to_file);*/
//brain_download($link_to_file);
// Конец метод для получения ссылки на прайслист ******************************************************************************************************************


//Получение розничного прайса.
/*echo "New function<br>";
$prices_retail = $AP->get_pricelist($session_id);
var_dump($prices_retail);*/
