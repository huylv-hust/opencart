<?php

	class Import
	{
		
		function __construct()
		{
			$connect = mysql_connect('localhost', 'root', '') or die('you can not connect to database');
			mysql_select_db('opencart', $connect);
			mysql_set_charset('utf8',$connect);
			return $connect;
		}

		function selectCategory($data)
		{
			//get all category
			$sql = 'SELECT category_id FROM oc_category_description WHERE oc_category_description.name ="'.$data.'"';
			$category_id = mysql_fetch_array(mysql_query($sql));
			return $category_id;
		}

		function selectAttribute()
		{
			$sql = 'SELECT attribute_id, name FROM oc_attribute_description';

			$attribute = $this->mysql_fetch_all(mysql_query($sql));
		
			return $attribute;
		}

		function insert($data,$table)
		{

			$column = '';
			$value = '';

			foreach ($data as $k => $v) {
				$column .= $k.',';
				$value .= '"'.$v.'"'.',';
			}

			$column = trim($column,',');
			$value = trim($value,',');
			//insert product to 

			$sql = 'INSERT INTO '.$table.' ('.$column.') VALUES ('.$value.')';

			$result = mysql_query($sql);
			return $result;

		}
		function mysql_fetch_all($result) {
		   while($row=mysql_fetch_array($result)) {
		       $return[] = $row;
		   }
		   return $return;
		}
		
	}
?>
