<?php
class DownloadImages extends apiplus
{

public function download_image_from_brain ($session_id, $category_id, $prod_id) {
	$AP = new apiplus();
	$product = $AP->_product($session_id, $prod_id);
	/*var_dump($product);*/
	/*	var_dump(basename($product->small_image));
var_dump($product->medium_image);*/
	/*	var_dump($product->large_image);*/

	if (!empty($product->large_image))    // получение фото продукта по URI
	{
		$imgdir = "../image/catalog/" . $category_id . "/";
		$img = $product->large_image;
		/*var_dump($imgdir . basename($img));*/
	/*	if (!file_exists($imgdir . basename($img))) {*/
			$ret = $AP->_download_image($img, $imgdir . basename($img));
			if ($ret) {
				//$imgs[] = basename($img); // name of downloaded image

				/*var_dump(basename($img));*/
				return basename($img);
			}
		/*}*/
	}
	return false;
}

public function downloadAllImages() {
/*	$prod_id = 2028;
	$product = $AP->_product($session_id, $prod_id);
	var_dump($product);
	var_dump($product->small_image);
	/*var_dump($product->medium_image);
	var_dump($product->large_image);*/

	/*if (!empty($product->small_image))    // получение фото продукта по URI
	{

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
			}
		$product->images = $imgsss; // array of downloaded images
		echo "<br>";
		//var_dump($imgs);
	}*/
}
}