<?php
class database
{
	private $_resource;
	public function __construct($config)
	{
		$this->_resource = mysqli_connect($config['host'],$config['username'],$config['password'],$config['dbname']);
	}
	public function nameQuote($text) {
		$text = $this->_resource->real_escape_string ( $text );
		if (strpos ( '.', $text ) === false) {
			return '`' . $text . '`';
		} else {
			return $text;
		}
	}

	/**
	 * Quote
	 *
	 * @param string $text
	 * @return string
	 */
	public function quote($text, $escaped = true) {
		return '\'' . ($escaped ? $this->_resource->real_escape_string ( $text ) : $text) . '\'';
	}
	public function insert($table, $data) {
		if (! is_array ( $data ) || sizeof ( $data ) == 0)
		throw new Exception ( 'Empty insert data or data not valid' );

		$datas = array ();
		$datas [] = $data;

		return $this->insertMulti ( $table, $datas );
	}

	/**
	 * Insert many records in single query
	 *
	 * @param string $table DBTable name
	 * @param array $data
	 * @return int Last Insert Id
	 *
	 * @throws Exception
	 */
	public function insertMulti($table, $datas){
		if (! is_array ( $datas ) || sizeof ( $datas ) == 0)
		throw new Exception ( 'Empty insert data or data not valid' );
		//mysqli_begin_transaction(true);
		$table = $this->nameQuote ( $table );
		$sql = 'INSERT INTO ' . $table . ' (';
		$records = sizeof ( $datas );
		/**
		 * TODO Build danh sach cac truong can insert
		 */
		$columns = array_keys ( $datas [0] );
		$sizeOfColumns = sizeof ( $columns );
		$sql .= '`' . implode ( '`, `', $columns ) . '`) VALUES ';
		/**
		 * TODO Build gia tri cua cac truong can insert
		 */
		for($i = 0; $i < $records; ++ $i) {
			$value = array_values ( $datas [$i] );
			$sql .= "\n(";

			for($index = 0; $index < $sizeOfColumns; ++ $index) {
				if ($value [$index] === null) {
					$sql .= 'NULL';
				} else {
					$sql .= $this->quote ( $value [$index] );
				}

				if ($index != ($sizeOfColumns - 1)) {
					$sql .= ', ';
				}
			}

			if ($i != ($records - 1)) {
				$sql .= '), ';
			} else {
				$sql .= ")";
			}
		}
		//$this->beginTransaction();
		mysqli_query($this->_resource, $sql);
		if($this->getLastId() == 0 && $table == '`oc_product`')
		{
			//echo $sql;
		}
		return $this->getLastId();
		//$this->rollBack();
	}

	public function getLastId()
	{
		return $this->_resource->insert_id;
	}

	public function select($table,$where = null,$order = null,$limit = null,$key = 'id')
	{
		$sql = 'SELECT * FROM ' . $this->nameQuote ( $table ) . (($where !== null) ? ' WHERE ' . $where : '') . (($order !== null) ? ' ORDER BY ' . $order : '') . (($limit !== null) ? ' LIMIT ' . $limit : '');
		$rs = $this->_resource->query($sql);
		$result = array();

		while ( $row = mysqli_fetch_assoc ($rs) ) {
			if ($key != '') {
				$result[$row [$key]] = $row;
			} else {
				$result[] = $row;
			}
		}

		return $result;
	}
	public function query($sql)
	{
		return $this->_resource->query($sql);
	}

	public function beginTransaction()
	{
		mysqli_autocommit($this->_resource,false);
	}

	public function commit()
	{
		$this->_resource->commit();
	}

	public function rollBack()
	{
		$this->_resource->rollback();
	}
}