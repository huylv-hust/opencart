<?php
require 'db.php';
require '../admin/config.php';
class Import
{
	public $path_img;
	public $file_csv;
	private static $db;
	function __construct($file_csv)
	{

		$config = array ('username' => DB_USERNAME, 'password' => DB_PASSWORD, 'host' => DB_HOSTNAME, 'dbname' => DB_DATABASE);
		self::$db = new database($config);
		$this->file_csv = $file_csv;
	}
	public function convert_utf8()
	{
		$data = file_get_contents($this->file_csv);
		if(mb_detect_encoding($data,'UTF-8',true) === false)
		{
			$encode_ary = array(
				'ASCII',
				'JIS',
				'eucjp-win',
				'sjis-win',
				'EUC-JP',
				'UTF-8',
			);
			$data = mb_convert_encoding($data,'UTF-8',$encode_ary);
		}

		$fp = tmpfile();
		fwrite($fp,$data);
		rewind($fp);
		return $fp;
	}
	public function get_file_csv()
	{
		$arr_data = array();
		$fp = $this->convert_utf8();
		while(($data = fgetcsv($fp, 10000, ',')) !== false)
		{
			$arr_data[] = $data;
		}

		return $arr_data;
	}
	public function get_category_from_file_csv()
	{
		$data = $this->get_file_csv();
		array_shift($data);
		$arr_category_temp = array();
		foreach($data as $key => $row)
		{
			$arr_category_temp[$row['14']][] = $row['15'];
		}

		$arr_category = array();
		foreach($arr_category_temp as $parent => $child)
		{
			$is_child = array_unique($child);
			if(count($is_child) == 1 && $is_child['0'] == $parent)
				$arr_category[$parent] = [];
			else
				$arr_category[$parent] = $is_child;
		}

		return $arr_category;
	}
	public function get_category_id($name,$list_category)
	{
		$name = trim($name);
		if(isset($list_category[$name]))
		{
			return $list_category[$name]['category_id'];
		}
		else
		{

			return 0;
		}
	}
	public function get_all_category()
	{
		self::$db->query('SET NAMES utf8;');
		$rs = self::$db->select('oc_category_description',null,null,null,'name');
		$cate =array();

		//print_r($rs);
		foreach($rs as $name=>$row)
		{
			$cate[trim($name)]= $row;
		}
		return $cate;

	}
	public function get_all_attribute()
	{
		self::$db->query('SET NAMES utf8;');
		return self::$db->select('oc_attribute_description',null,null,null,'name');
	}
	public function import_product($row,$list_category,$list_attribute)
	{
		/**
		*Insert to table
		oc_product
		oc_product_attribute
		oc_product_description
		oc_product_image
		oc_product_to_category
		oc_product_to_store
		oc_product_to_layout
		 */
		self::$db->query('SET NAMES utf8;');
		if(file_exists(DIR_IMAGE.'catalog/product/'.$row['2'].'.jpg'))
		{
			$img = 	'catalog/product/'.$row['2'].'.jpg';
		}
		else
		{
			$img = null;
		}

		$arr_product = array(
			'model'	          => $row['2'],
			'price'           => (int)$row['10'],
			'jan'             => substr($row['13'],0,13),
			'tax_class_id'	  => 0,
			'image'			  => $img,
			'sku'			  => '',
			'upc'             =>'',
			'ean'             =>'',
			'isbn'            =>'',
			'mpn'             =>'',
			'location'        =>'',
			'manufacturer_id' => 0,
			'quantity'        => 1,
			'stock_status_id' => 6,
			'weight_class_id' => 1,
			'length_class_id' => 1,
			'status'          => 1,
			'date_available'  => date('Y-m-d'),
			'date_added'      => date('Y-m-d H:i:s'),
			'date_modified'   => date('Y-m-d H:i:s'),
 		);

		$category_id = (int)$this->get_category_id($row['15'],$list_category);

		if ($category_id == 0) {
			$category_id = (int)$this->get_category_id($row['14'],$list_category);
		}
		if($category_id)
		{

			$product_id = self::$db->insert('oc_product',$arr_product);
			if($product_id == 0)
			{
				return 0;
			}
			$arr_product_to_store = array(
				'product_id' => $product_id,
				'store_id'   => 0
			);

			self::$db->insert('oc_product_to_store',$arr_product_to_store);

			$arr_product_to_layout = array(
				'product_id' => $product_id,
				'store_id'   => 0,
				'layout_id'  => 0,
			);

			self::$db->insert('oc_product_to_layout',$arr_product_to_layout);

			$description = '';
			if($row['19'])
				$description .= '●用途&lt;br&gt;'.$row['19'];
			if($row['20'])
				$description .= '&lt;br&gt;●特長&lt;br&gt;'.trim(str_replace('。', '。&lt;br&gt;', $row['20']), '&lt;br&gt;');
			if($row['21'])
				$description .= '&lt;br&gt;●注意&lt;br&gt;'.$row['21'];
			if($row['22'])
				$description .= '&lt;br&gt;●配送&lt;br&gt;'.$row['22'];
			if($row['23'])
				$description .= '&lt;br&gt;●決済&lt;br&gt;'.$row['23'];
			if($row['24'])
				$description .= '&lt;br&gt;●出荷&lt;br&gt;'.$row['24'];

			$description = trim($description,'&lt;br&gt;');

			$arr_prodcut_description = array(
				'product_id'  => $product_id,
				'name'        => $row['3'],
				'language_id' => 2,
				'description' => $description,
				'tag'         => ' ',
				'meta_title'  => ' ',
				'meta_description' => ' ',
				'meta_keyword'     => ' ',
			);

			self::$db->insert('oc_product_description',$arr_prodcut_description);

			$arr_prodcut_to_category = array(
				'product_id'  => $product_id,
				'category_id' => $category_id,
			);
			self::$db->insert('oc_product_to_category',$arr_prodcut_to_category);

			if(isset($list_attribute['宇佐美仕入価格']['attribute_id']))
			{
				$arr_product_attribute_1 = array(
					'product_id'   => $product_id,
					'language_id'  => 2,
					'attribute_id' => $list_attribute['宇佐美仕入価格']['attribute_id'],
					'text'         => $row['9'],
				);
				self::$db->insert('oc_product_attribute',$arr_product_attribute_1);
			}

			if(isset($list_attribute['メーカー名']['attribute_id']))
			{
				$arr_product_attribute_2 = array(
					'product_id'   => $product_id,
					'language_id'  => 2,
					'attribute_id' => $list_attribute['メーカー名']['attribute_id'],
					'text'         => $row['11'],

				);
				self::$db->insert('oc_product_attribute',$arr_product_attribute_2);
			}

			if(isset($list_attribute['メーカー型式']['attribute_id']))
			{
				$arr_product_attribute_3 = array(
					'product_id'   => $product_id,
					'language_id'  => 2,
					'attribute_id' => $list_attribute['メーカー型式']['attribute_id'],
					'text'         => $row['12'],

				);
				self::$db->insert('oc_product_attribute',$arr_product_attribute_3);
			}
			if(isset($list_attribute['商品分類名']['attribute_id']))
			{
				$arr_product_attribute_4 = array(
					'product_id'   => $product_id,
					'language_id'  => 2,
					'attribute_id' => $list_attribute['商品分類名']['attribute_id'],
					'text'         => $row['7'],

				);
				self::$db->insert('oc_product_attribute',$arr_product_attribute_4);
			}
			if(isset($list_attribute['商品コード']['attribute_id']))
			{
				$arr_product_attribute_5 = array(
					'product_id'   => $product_id,
					'language_id'  => 2,
					'attribute_id' => $list_attribute['商品コード']['attribute_id'],
					'text'         => $row['16'],

				);
				self::$db->insert('oc_product_attribute',$arr_product_attribute_5);
			}
			if(isset($list_attribute['荷姿コード']['attribute_id']))
			{
				$arr_product_attribute_6 = array(
					'product_id'   => $product_id,
					'language_id'  => 2,
					'attribute_id' => $list_attribute['荷姿コード']['attribute_id'],
					'text'         => $row['17'],

				);
				self::$db->insert('oc_product_attribute',$arr_product_attribute_6);
			}
			if(isset($list_attribute['カタログ掲載ページ番号']['attribute_id']))
			{
				$arr_product_attribute_7 = array(
					'product_id'   => $product_id,
					'language_id'  => 2,
					'attribute_id' => $list_attribute['カタログ掲載ページ番号']['attribute_id'],
					'text'         => $row['1'],

				);
				self::$db->insert('oc_product_attribute',$arr_product_attribute_7);
			}
			if(isset($list_attribute['詳細①']['attribute_id']))
			{
				$arr_product_attribute_8 = array(
					'product_id'   => $product_id,
					'language_id'  => 2,
					'attribute_id' => $list_attribute['詳細①']['attribute_id'],
					'text'         => $row['4'],

				);
				self::$db->insert('oc_product_attribute',$arr_product_attribute_8);
			}
			if(isset($list_attribute['詳細②']['attribute_id']))
			{
				$arr_product_attribute_9 = array(
					'product_id'   => $product_id,
					'language_id'  => 2,
					'attribute_id' => $list_attribute['詳細②']['attribute_id'],
					'text'         => $row['5'],

				);
				self::$db->insert('oc_product_attribute',$arr_product_attribute_9);
			}
			if(isset($list_attribute['請求書商品名称']['attribute_id']))
			{
				$arr_product_attribute_10 = array(
					'product_id'   => $product_id,
					'language_id'  => 2,
					'attribute_id' => $list_attribute['請求書商品名称']['attribute_id'],
					'text'         => $row['18'],

				);
				self::$db->insert('oc_product_attribute',$arr_product_attribute_10);
			}

			return $product_id;
		}
		else {
			return 0;
		}


	}
	public function check_exits_category_name($name,$list_category)
	{

		$category_id = (int)$this->get_category_id($name,$list_category);
		return $category_id;
	}
	public function empty_db()
	{
		self::$db->query('TRUNCATE oc_product');
		self::$db->query('TRUNCATE oc_product_description');
		self::$db->query('TRUNCATE oc_product_to_store');
		self::$db->query('TRUNCATE oc_product_to_layout');
		self::$db->query('TRUNCATE oc_product_attribute');
		self::$db->query('TRUNCATE oc_product_to_category');
	}
	public function runs()
	{
		$arr_data = $this->get_file_csv();
		$list_category = $this->get_all_category();
		$list_attribute = $this->get_all_attribute();
		array_shift($arr_data);
		$arr_rs = array();
		$arr_not_exits = array();
		foreach($arr_data as $line => $row)
		{
			$cate_id = $this->check_exits_category_name($row['15'],$list_category);
			if($cate_id == 0)
				$cate_id = $this->check_exits_category_name($row['14'],$list_category);

			if($cate_id == 0)
			{
				$arr_not_exits[$line] = 'Line '.($line+2).' category '.$row['14'].' not exits';
			}

		}
		//$arr_not_exits = array();
		if(count($arr_not_exits) == 0)
		{
			foreach($arr_data as $line => $row)
			{
				$product_id = $this->import_product($row,$list_category,$list_attribute);
				if($product_id == 0)
				{
					$arr_rs[$line]  = 'Line:'.($line+2).' insert product error!';
				}
			}

			return $arr_rs;
		}

		return $arr_not_exits;

	}
}


echo '<meta charset="utf-8" />';
echo '<div style="text-align:left; padding:20px 0px 0px 50px;">';
echo '<h1>Import data from csv</h1>';
echo 'NOTE: Image push folder: <strong>image/catalog/product</strong><br/><br/>';
echo '<form action="" method="post" enctype="multipart/form-data">';
echo '<input type="file" name="csv"><br/><br/>';
echo '<input type="submit" value="Submit" name="submit">';
echo '</form>';

if(count($_POST))
{
	$arr_file = $_FILES['csv'];
	if(substr($arr_file['name'],-4) == '.csv')
	{
		$import = new Import($arr_file['tmp_name']);
		$import->empty_db();
		$rs = $import->runs();
		echo '<b>Result</b><br/>';
		if(count($rs) == 0)
			echo 'DONE';
		else
		{
			foreach($rs as $k=>$row)
			{
				echo ($k+1).'. '.$row.'<br/>';
			}
		}
	}
	else
	{
		if($arr_file['name'])
			echo '<b>'.$arr_file['name'].'</b> not format!';
		else
			echo 'You must choose file upload!';
	}
}
echo '</div>';



