<?php
	include 'database.php';
	$conn = new IMPORT();

if (isset($_FILES['csv']))
{
	$data = file_get_contents($_FILES['csv']['tmp_name']);
	if (substr($data, 0, 3) == "\xEF\xBB\xBF") 
	{
        $data = substr($data, 3);
    }

    //encode file to utf8
    if (mb_detect_encoding($data, "UTF-8", true) === false) {
        $encode_ary = array("ASCII", "JIS", "eucjp-win", "sjis-win", "EUC-JP", "UTF-8");
        $data = mb_convert_encoding($data, 'UTF-8', $encode_ary);
    }

    $fp = tmpfile();
    fwrite($fp, $data);
    rewind($fp);

    $data = fgetcsv($fp,1000,",");
    while (($data = fgetcsv($fp,1000,",")) !== false)
    {
    	if (isset($data[11]) !== '')
    	{
    		$category_id = $conn->selectCategory($data[11]);
    		

//insert data to oc_product 		

    		$product_ar = array(
    			'model' => $data[0],
    			'jan' => $data[6],
    			'price' => $data[3],
    			'status' => '1',
    			'quantity' => '1',
    			);
    		$conn->insert($product_ar, 'oc_product');
    		$product_id = mysql_insert_id();

//insert to oc_product_to_store

    		$store_ar = array(
    			'product_id' => $product_id,
    			'store_id' => '0',
    			);
    		$store = $conn->insert($store_ar, 'oc_product_to_store');

//insert to oc_product_to_category

    		$pc = array(
    			'product_id' => $product_id,
    			'category_id' => $category_id[0],
    			);
    		$conn->insert($pc, 'oc_product_to_category');

//insert name of product to oc_product_description
    		$title = '';
    		$title1 = '';
    		$title2 = '';
    		$title3 = '';
    		$title4 = '';
    		if($data[12] !== '')
			{
				$title1 ='●詳細\n'.$data[12].'\n\n';
			}
			if($data[13] !== '')
			{
				$title2 = '●特徴\n'.$data[13].'\n\n';
			} 
			if($data[14] !== '')
			{
				$title3 = '●用途\n'.$data[14].'\n\n';
			} 
			if($data[15] !== '')
			{
				$title4 = '●注意\n'.$data[15];
			}
			
			$title = $title1.$title2.$title3.$title4;
    		$pd = array(
    			'product_id' => $product_id,
    			'name' => $data[1],
    			'language_id' => '3',
    			'description' => $title,
    			);
    		$conn->insert($pd, 'oc_product_description');

//insert data to oc_product_attribute

    		$attribute_ar = $conn->selectAttribute();

    		foreach ($attribute_ar as $k => $v) 
    		{
    			$attribute[$v[0]] = $v[1];
    		}

    		foreach ($attribute as $key => $value)
    		{
    			if ($value =='宇佐美仕入価格') 
    			{
    				$dt = array(
		    			'product_id' => $product_id,
		    			'attribute_id' => $key,
		    			'language_id' => '3',
		    			'text' => $data[2],
		    			'date_added' =>date('Y-m-d H:i:s', time());
    			    	);

    				$conn->insert($dt, 'oc_product_attribute');
    			}

    			if ($value =='メーカー型式') 
    			{
    				$dt1 = array(
		    			'product_id' => $product_id,
		    			'attribute_id' => $key,
		    			'language_id' => '3',
		    			'text' => $data[5],
		    			'date_added' =>date('Y-m-d H:i:s', time());
    			    	);

    				$conn->insert($dt1, 'oc_product_attribute');
    			}

    			if ($value =='商品コード') 
    			{
    				$dt2 = array(
		    			'product_id' => $product_id,
		    			'attribute_id' => $key,
		    			'language_id' => '3',
		    			'text' => $data[8],
		    			'date_added' =>date('Y-m-d H:i:s', time());
    			    	);

    				$conn->insert($dt2, 'oc_product_attribute');
    			}

    			if ($value =='荷姿コード') 
    			{
    				$dt3 = array(
		    			'product_id' => $product_id,
		    			'attribute_id' => $key,
		    			'language_id' => '3',
		    			'text' => $data[9],
		    			'date_added' =>date('Y-m-d H:i:s', time());
    			    	);

    				$conn->insert($dt3, 'oc_product_attribute');
    			}

    			if ($value =='商品分類名') 
    			{
    				$dt4 = array(
		    			'product_id' => $product_id,
		    			'attribute_id' => $key,
		    			'language_id' => '3',
		    			'text' => $data[7],
		    			'date_added' =>date('Y-m-d H:i:s', time());
    			    	);

    				$conn->insert($dt4, 'oc_product_attribute');
    			}
    			if ($value =='メーカー名') 
    			{
    				$dt5 = array(
		    			'product_id' => $product_id,
		    			'attribute_id' => $key,
		    			'language_id' => '3',
		    			'text' => $data[4],
		    			'date_added' =>date('Y-m-d H:i:s', time());
    			    	);

    				$conn->insert($dt5, 'oc_product_attribute');
    			}
    		}

    	}
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>IMPORT</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
	<form action="import.php" method="POST" enctype="multipart/form-data">
		<div>
			<span class="text-info" id="filename"></span>
			<input name="csv" type="file" id="csv" />
			<button class="btn btn-primary btn-sm" type="submit" name="import"><i class="glyphicon glyphicon-upload icon-white"></i> アップロード実行</button>
		</div>
	</form>
</body>
</html>
