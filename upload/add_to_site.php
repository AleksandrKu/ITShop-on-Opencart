<?php
require_once('bd_pdo.php');
// получение всей информации о товаре из таблицы brain, которая была загруженна из прайса
if ($_POST['category_id']) {
	$category_id = (int)$_POST['category_id'];
	$categories_brain = [
	];

	upload_from_price_brain($session_id, $config, $category_id);
}

		function upload_from_price_brain($session_id, $config, $category_id = "0") {
	//var_dump($category_id); echo "<b>";
			$opt = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			];
			$pdo_add_to_site = new  PDODriver($config['host'], $config['username'], $config['password'], $config['database'], $opt);

			$properties_before_upload = [
				'quantity' => 0,
				'stock_status_id' => 5
			];
			$pdo_add_to_site->update_all_filed('oc_product', $properties_before_upload);

	$download_image = new DownloadImages();


    if ($category_id == 0) {
		/*$sql_add = "SELECT  cat_id, article, vendor, priceusd, categoryname FROM brain  GROUP BY cat_id ORDER BY  cat_id  ASC";	*/
		$sql_add = "SELECT  cat_id, article, vendor, priceusd, categoryname FROM brain   GROUP BY categoryname  ORDER BY  categoryname  ASC";
    } else {
        $sql_add = "SELECT  cat_id, code, article, vendor, model, name, description, id_item,
   priceusd, categoryname, stock, daydelivery, country, retailprice, productid FROM brain  WHERE cat_id = :category_id ";
    }
	$stm_add = $pdo_add_to_site->getConnection()->prepare($sql_add);
	$parameter = ['category_id' => $category_id];
	$stm_add->execute($parameter);
	$number = 0;?>
			<table class="table" style="width: 60%">
			<tr><th>№</th>
				<th>ID </th>
				<th>Категория ID</th>
				<th>Категория</th>
				<th>Модель</th>
				<th>Производитель</th>
				<th>Цена закупки $</th>
			</tr>
			<?php
	while ($row = $stm_add->fetch()) {
		$product_id = $row['productid'];
	    echo "<tr><td>".$number++."</td><td>{$product_id}</td><td>{$row['cat_id']}</td><td>{$row['categoryname']}</td>
		<td>{$row['article']}</td><td>{$row['vendor']}</td><td>{$row['priceusd']}</td></tr>";
		$param_for_adding_oc_product_to_store = [
			'product_id' => $product_id,
			'store_id' => 0
		];
		$pdo_add_to_site->delete('oc_product_to_store', 'product_id',$product_id);
		$pdo_add_to_site->insert('oc_product_to_store', $param_for_adding_oc_product_to_store);

		$keyword_url_seo = $row['vendor']."-".$row['article']."-".$row['model'];
		$keyword_url_seo = str_replace(" ","-", $keyword_url_seo);
		$keyword_url_seo = str_replace("/","-", $keyword_url_seo);
		$keyword_url_seo = str_replace("(","-", $keyword_url_seo);
		$keyword_url_seo = str_replace(")","-", $keyword_url_seo);
		$keyword_url_seo = str_replace("+","-", $keyword_url_seo);
		$keyword_url_seo = str_replace("\"","-", $keyword_url_seo);
		$keyword_url_seo = str_replace(",","-", $keyword_url_seo);
		/*$keyword_url_seo = urlencode($keyword_url_seo);*/
		$param_for_adding_utl_alias_seo = [
			'product_id' => $product_id,
			'query' =>	'product_id='.$product_id,
            'keyword' =>  $keyword_url_seo
		];
		$pdo_add_to_site->delete('oc_url_alias', 'product_id',$product_id);
		$pdo_add_to_site->insert('oc_url_alias', $param_for_adding_utl_alias_seo);



		$category_id_opencart = $pdo_add_to_site->find_category_id('oc_category_description','category_id_brain',$category_id);
		$param_for_adding_oc_product_to_category = [
			'product_id' => $product_id,
			'category_id' => $category_id_opencart->category_id
		];

		$pdo_add_to_site->delete('oc_product_to_category', 'product_id',$product_id);
		$pdo_add_to_site->insert('oc_product_to_category', $param_for_adding_oc_product_to_category);
//установка родительской атегории
		if($category_id == '1097' || $category_id == '1264'  || $category_id == '1403' || $category_id == '1441' || $category_id == '1334'
			|| $category_id == '1361' || $category_id == '1442' || $category_id == '1108') {
			$param_for_adding_oc_product_to_category_parent = [
				'product_id' => $product_id,
				'category_id' => 25
			];


		//$pdo_add_to_site->delete('oc_product_to_category', 'product_id',$product_id);
		$pdo_add_to_site->insert('oc_product_to_category', $param_for_adding_oc_product_to_category_parent);
	}


		$AP = new apiplus();
		$product = $AP->_product($session_id, $product_id);
		$full_description = $product->name."<br>".$product->brief_description."<br>".$product->description."<br>Гарантия {$product->warranty} мес.";
		$param_for_adding_oc_product_description = [
			'product_id' => $product_id,
			'language_id' => 1,
			'name' =>  $row['article'],
			'description' => $full_description,

            'tag' => $row['article'],
			'meta_title' => $row['article'],
            'meta_description' => $row['article']." ".$row['name']." ".$row['description'],
			'meta_keyword' => $row['article']." ".$row['code']." ".$row['model']
		];
		$pdo_add_to_site->delete('oc_product_description', 'product_id',$product_id);
		$pdo_add_to_site->insert('oc_product_description', $param_for_adding_oc_product_description);

		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');
		$stock_status_id = ($row['stock']) ? 7 : 6;  // 7: in stock; 6: 2-3 Days; 5: out of stock
		$image = $download_image->download_image_from_brain($session_id,$category_id,$product_id);
		$manufacturer_id = 1;
		if($row['vendor'] == 'Lenovo') { $manufacturer_id = 12; }
		if($row['vendor'] == 'INTEL') { $manufacturer_id = 13; }
		if($row['vendor'] == 'AMD') { $manufacturer_id = 14; }
		if($row['vendor'] == 'ASRock') { $manufacturer_id = 15; }
		if($row['vendor'] == 'ASUS') { $manufacturer_id = 11; }
		if($row['vendor'] == 'GIGABYTE') { $manufacturer_id = 16; }
		if($row['vendor'] == 'MSI') { $manufacturer_id = 17; }

		if($row['vendor'] == 'Acer') { $manufacturer_id = 18; }
		if($row['vendor'] == 'AOC') { $manufacturer_id = 19; }
		if($row['vendor'] == 'BENQ') { $manufacturer_id = 20; }
		if($row['vendor'] == 'Dell') { $manufacturer_id = 21; }
		if($row['vendor'] == 'EIZO') { $manufacturer_id = 22; }
		if($row['vendor'] == 'HP') { $manufacturer_id = 23; }
		if($row['vendor'] == 'iiyama') { $manufacturer_id = 24; }
		if($row['vendor'] == 'LG') { $manufacturer_id = 25; }
		if($row['vendor'] == 'NEC') { $manufacturer_id = 26; }
		if($row['vendor'] == 'Neovo') { $manufacturer_id = 27; }
		if($row['vendor'] == 'PHILIPS') { $manufacturer_id = 28; }
		if($row['vendor'] == 'Samsung') { $manufacturer_id = 29; }
		if($row['vendor'] == 'Viewsonic') { $manufacturer_id = 30; }
		if($row['vendor'] == 'Assistant') { $manufacturer_id = 31; }
		if($row['vendor'] == 'Bravis') { $manufacturer_id = 32; }
		if($row['vendor'] == 'Ergo') { $manufacturer_id = 33; }
		if($row['vendor'] == 'Estar') { $manufacturer_id = 34; }
		if($row['vendor'] == 'EvroMedia') { $manufacturer_id = 35; }
		if($row['vendor'] == 'Impression') { $manufacturer_id = 36; }
		if($row['vendor'] == 'Nomi') { $manufacturer_id = 37; }
		if($row['vendor'] == 'PRESTIGIO') { $manufacturer_id = 38; }
		if($row['vendor'] == 'Sigma') { $manufacturer_id = 39; }
		if($row['vendor'] == '3Q') { $manufacturer_id = 40; }
		if($row['vendor'] == 'BRAIN') { $manufacturer_id = 41; }
		if($row['vendor'] == 'Brother') { $manufacturer_id = 42; }
		if($row['vendor'] == 'SHARP') { $manufacturer_id = 43; }
		if($row['vendor'] == 'XEROX') { $manufacturer_id = 44; }
		if($row['vendor'] == 'Inno3D') { $manufacturer_id = 45; }
		if($row['vendor'] == 'PALIT') { $manufacturer_id = 46; }
		if($row['vendor'] == 'PNY') { $manufacturer_id = 47; }
		if($row['vendor'] == 'Sapphire') { $manufacturer_id = 48; }
		if($row['vendor'] == 'ZOTAC') { $manufacturer_id = 49; }
		if($row['vendor'] == 'AeroCool') { $manufacturer_id = 50; }
		if($row['vendor'] == 'CASECOM') { $manufacturer_id = 51; }
		if($row['vendor'] == 'CHIEFTEC') { $manufacturer_id = 52; }
		if($row['vendor'] == 'Hitachi HGST') { $manufacturer_id = 53; }
		if($row['vendor'] == 'i.norys') { $manufacturer_id = 54; }
		if($row['vendor'] == 'Seagate') { $manufacturer_id = 55; }
		if($row['vendor'] == 'Western Digital') { $manufacturer_id = 56; }




		if(!$product->stocks_expected) { $quantity = 0; $stock_status_id = 5; } else { $quantity = 100; }
		$param_for_adding_oc_product = [
			'product_id' => $product_id,
			'model' => $row['code'],
		    'location' => $row['stock'],
		    'quantity' =>  $quantity,
			'stock_status_id' => $stock_status_id,
			'image' => "../image/catalog/".$category_id."/".$image,
			'manufacturer_id' => $manufacturer_id,
			'price' => $row['retailprice'],
			'date_available' => $date,
			'length_class_id' => 1,
			'subtract' => 1,
			'minimum' => 1,
			'status' => 1,
			'viewed' =>1,
			'date_added' => $datetime,
		];
		$pdo_add_to_site->delete('oc_product', 'product_id',$product_id);
		$pdo_add_to_site->insert('oc_product', $param_for_adding_oc_product);

	}
			?></table>  <?php
}

/*$category_id = 1097; // процессоры
upload_from_price_brain($session_id, $config, $category_id);*/

//$category_id = 1264; // материнки
/*$category_id = 7682; // мониторы
upload_from_price_brain($session_id, $config, $category_id);*/





