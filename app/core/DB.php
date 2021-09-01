<?php 
/*
|--------------------------------------------------------------
| FjFrame Application Query Builder Class
|--------------------------------------------------
|
| Supported by @Mareimorsy.
|
*/
class DB{
	private static $_instance = null;
	private $_db = null, $table, $columns, $sql, $bindValues, $getSQL, $where, $orWhere, $whereCount=0, $isOrWhere = false, $rowCount=0, $limit, $orderBy, $join, $lastIDInserted = 0;

	// Initial values for pagination array
	private $pagination = ['previousPage' => null,'currentPage' => 1,'nextPage' => null,'lastPage' => null, 'totalRows' => null];

	private function __construct()
	{
		try {
			$this->_db = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'),Config::get('mysql/password'));
			$this->_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			/*$db_config = null;*/
		}catch(PDOException $e){
			die($e->getMessage());
		}

	}

	public static function getInstance()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}
	public function query($query, $args = [], $quick = false)
	{
		$this->resetQuery();
		$query = trim($query);
		$this->getSQL = $query;
		$this->bindValues = $args;

		if ($quick == true) {
			$stmt = $this->_db->prepare($query);
			$stmt->execute($this->bindValues);
			$this->rowCount = $stmt->rowCount();
			return $stmt->fetchAll();
		}else{
			if (strpos( strtoupper($query), "SELECT" ) === 0 ) {
				$stmt = $this->_db->prepare($query);
				$stmt->execute($this->bindValues);
				$this->rowCount = $stmt->rowCount();

				$rows = $stmt->fetchAll(PDO::FETCH_CLASS,'MareiObj');
				$collection= [];
				$collection = new Fjt_MareiCollection;
				$x=0;
				foreach ($rows as $key => $row) {
					$collection->offsetSet($x++,$row);
				}

				return $collection;

			}else{
				$this->getSQL = $query;
				$stmt = $this->_db->prepare($query);
				$stmt->execute($this->bindValues);
				return $stmt->rowCount();
			}
		}
	}
	public function exec()
	{
		//assemble query
			$this->sql .= $this->where;
			$this->getSQL = $this->sql;
			$stmt = $this->_db->prepare($this->sql);
			$stmt->execute($this->bindValues);
			return $stmt->rowCount();
	}

	private function resetQuery()
	{
		$this->table = null;
		$this->columns = null;
		$this->sql = null;
		$this->bindValues = null;
		$this->limit = null;
		$this->orderBy = null;
		$this->join = null;
		$this->getSQL = null;
		$this->where = null;
		$this->orWhere = null;
		$this->whereCount = 0;
		$this->isOrWhere = false;
		$this->rowCount = 0;
		$this->lastIDInserted = 0;
	}

	public function delete($table_name, $id=null)
	{
		$this->resetQuery();

		$this->sql = "DELETE FROM `{$table_name}`";
		
		if (isset($id)) {
			// if there is an ID
			if (is_numeric($id)) {
				$this->sql .= " WHERE `id` = ?";
				$this->bindValues[] = $id;
			// if there is an Array
			}elseif (is_array($id)) {
				$arr = $id;
				$count_arr = count($arr);
				$x = 0;

				foreach ($arr as  $param) {
					if ($x == 0) {
						$this->where .= " WHERE ";
						$x++;
					}else{
						if ($this->isOrWhere) {
							$this->where .= " Or ";
						}else{
							$this->where .= " AND ";
						}
						
						$x++;
					}
					$count_param = count($param);

					if ($count_param == 1) {
						$this->where .= "`id` = ?";
						$this->bindValues[] =  $param[0];
					}elseif ($count_param == 2) {
						$operators = explode(',', "=,>,<,>=,>=,<>,LIKE");
						$operatorFound = false;

						foreach ($operators as $operator) {
							if ( strpos($param[0], $operator) !== false ) {
								$operatorFound = true;
								break;
							}
						}

						if ($operatorFound) {
							$this->where .= $param[0]." ?";
						}else{
							$this->where .= "`".trim($param[0])."` = ?";
						}

						$this->bindValues[] =  $param[1];
					}elseif ($count_param == 3) {
						$this->where .= "`".trim($param[0]). "` ". $param[1]. " ?";
						$this->bindValues[] =  $param[2];
					}

				}
				//end foreach
			}
			// end if there is an Array
			$this->sql .= $this->where;

			$this->getSQL = $this->sql;
			$stmt = $this->_db->prepare($this->sql);
			$stmt->execute($this->bindValues);
			return $stmt->rowCount();
		}// end if there is an ID or Array
		// $this->getSQL = "<b>Attention:</b> This Query will update all rows in the table, luckily it didn't execute yet!, use exec() method to execute the following query :<br>". $this->sql;
		// $this->getSQL = $this->sql;
		return $this;
	}

	public function update($table_name, $fields = [], $id=null)
	{
		$this->resetQuery();
		$set ='';
		$x = 1;

		foreach ($fields as $column => $field) {
			$set .= "`$column` = ?";
			$this->bindValues[] = $field;
			if ( $x < count($fields) ) {
				$set .= ", ";
			}
			$x++;
		}

		$this->sql = "UPDATE `{$table_name}` SET $set";
		
		if (isset($id)) {
			// if there is an ID
			if (is_numeric($id)) {
				$this->sql .= " WHERE `id` = ?";
				$this->bindValues[] = $id;
			// if there is an Array
			}elseif (is_array($id)) {
				$arr = $id;
				$count_arr = count($arr);
				$x = 0;

				foreach ($arr as  $param) {
					if ($x == 0) {
						$this->where .= " WHERE ";
						$x++;
					}else{
						if ($this->isOrWhere) {
							$this->where .= " Or ";
						}else{
							$this->where .= " AND ";
						}
						
						$x++;
					}
					$count_param = count($param);

					if ($count_param == 1) {
						$this->where .= "`id` = ?";
						$this->bindValues[] =  $param[0];
					}elseif ($count_param == 2) {
						$operators = explode(',', "=,>,<,>=,>=,<>,LIKE");
						$operatorFound = false;

						foreach ($operators as $operator) {
							if ( strpos($param[0], $operator) !== false ) {
								$operatorFound = true;
								break;
							}
						}

						if ($operatorFound) {
							$this->where .= $param[0]." ?";
						}else{
							$this->where .= "`".trim($param[0])."` = ?";
						}

						$this->bindValues[] =  $param[1];
					}elseif ($count_param == 3) {
						$this->where .= "`".trim($param[0]). "` ". $param[1]. " ?";
						$this->bindValues[] =  $param[2];
					}

				}
				//end foreach
			}
			// end if there is an Array
			$this->sql .= $this->where;

			$this->getSQL = $this->sql;
			$stmt = $this->_db->prepare($this->sql);
			$stmt->execute($this->bindValues);
			return $stmt->rowCount();
		}// end if there is an ID or Array
		// $this->getSQL = "<b>Attention:</b> This Query will update all rows in the table, luckily it didn't execute yet!, use exec() method to execute the following query :<br>". $this->sql;
		// $this->getSQL = $this->sql;
		return $this;
	}

	public function insert( $table_name, $fields = [] )
	{
		$this->resetQuery();

		$keys = implode('`, `', array_keys($fields));
		$values = '';
		$x=1;
		foreach ($fields as $field => $value) {
			$values .='?';
			$this->bindValues[] =  $value;
			if ($x < count($fields)) {
				$values .=', ';
			}
			$x++;
		}
 
		$this->sql = "INSERT INTO `{$table_name}` (`{$keys}`) VALUES ({$values})";
		$this->getSQL = $this->sql;
		$stmt = $this->_db->prepare($this->sql);
		$stmt->execute($this->bindValues);
		$this->lastIDInserted = $this->_db->lastInsertId();

		return $this->lastIDInserted;
	}//End insert function

	public function lastId()
	{
		return $this->lastIDInserted;
	}

	public function table($table_name)
	{
		$this->resetQuery();
		$this->table = $table_name;
		return $this;
	}

	public function select($columns)
	{
		$columns = explode(',', $columns);
		foreach ($columns as $key => $column) {
			$columns[$key] = trim($column);
		}
		
		$columns = implode(', ', $columns);
		

		$this->columns = "{$columns}";;
		return $this;
	}

	public function where()
	{
		if ($this->whereCount == 0) {
			$this->where .= " WHERE ";
			$this->whereCount+=1;
		}else{
			$this->where .= " AND ";
		}

		$this->isOrWhere= false;

		// call_user_method_array('where_orWhere', $this, func_get_args());
		//Call to undefined function call_user_method_array()
		//echo print_r(func_num_args());
		$num_args = func_num_args();
		$args = func_get_args();
		if ($num_args == 1) {
			if (is_numeric($args[0])) {
				$this->where .= "`id` = ?";
				$this->bindValues[] =  $args[0];
			}elseif (is_array($args[0])) {
				$arr = $args[0];
				$count_arr = count($arr);
				$x = 0;

				foreach ($arr as  $param) {
					if ($x == 0) {
						$x++;
					}else{
						if ($this->isOrWhere) {
							$this->where .= " Or ";
						}else{
							$this->where .= " AND ";
						}
						
						$x++;
					}
					$count_param = count($param);
					if ($count_param == 1) {
						$this->where .= "`id` = ?";
						$this->bindValues[] =  $param[0];
					}elseif ($count_param == 2) {
						$operators = explode(',', "=,>,<,>=,>=,<>,LIKE");
						$operatorFound = false;

						foreach ($operators as $operator) {
							if ( strpos($param[0], $operator) !== false ) {
								$operatorFound = true;
								break;
							}
						}

						if ($operatorFound) {
							$this->where .= $param[0]." ?";
						}else{
							$this->where .= "`".trim($param[0])."` = ?";
						}

						$this->bindValues[] =  $param[1];
					}elseif ($count_param == 3) {
						$this->where .= "`".trim($param[0]). "` ". $param[1]. " ?";
						$this->bindValues[] =  $param[2];
					}
				}
			}
			// end of is array
		}elseif ($num_args == 2) {
			$operators = explode(',', "=,>,<,>=,>=,<>,LIKE");
			$operatorFound = false;
			foreach ($operators as $operator) {
				if ( strpos($args[0], $operator) !== false ) {
					$operatorFound = true;
					break;
				}
			}

			if ($operatorFound) {
				$this->where .= $args[0]." ?";
			}else{
				$this->where .= "`".trim($args[0])."` = ?";
			}

			$this->bindValues[] =  $args[1];

		}elseif ($num_args == 3) {
			
			$this->where .= "`".trim($args[0]). "` ". $args[1]. " ?";
			$this->bindValues[] =  $args[2];
		}

		return $this;
	}

	public function orWhere()
	{
		if ($this->whereCount == 0) {
			$this->where .= " WHERE ";
			$this->whereCount+=1;
		}else{
			$this->where .= " OR ";
		}
		$this->isOrWhere= true;
		// call_user_method_array ( 'where_orWhere' , $this ,  func_get_args() );

		$num_args = func_num_args();
		$args = func_get_args();
		if ($num_args == 1) {
			if (is_numeric($args[0])) {
				$this->where .= "`id` = ?";
				$this->bindValues[] =  $args[0];
			}elseif (is_array($args[0])) {
				$arr = $args[0];
				$count_arr = count($arr);
				$x = 0;

				foreach ($arr as  $param) {
					if ($x == 0) {
						$x++;
					}else{
						if ($this->isOrWhere) {
							$this->where .= " Or ";
						}else{
							$this->where .= " AND ";
						}
						
						$x++;
					}
					$count_param = count($param);
					if ($count_param == 1) {
						$this->where .= "`id` = ?";
						$this->bindValues[] =  $param[0];
					}elseif ($count_param == 2) {
						$operators = explode(',', "=,>,<,>=,>=,<>,LIKE");
						$operatorFound = false;

						foreach ($operators as $operator) {
							if ( strpos($param[0], $operator) !== false ) {
								$operatorFound = true;
								break;
							}
						}

						if ($operatorFound) {
							$this->where .= $param[0]." ?";
						}else{
							$this->where .= "`".trim($param[0])."` = ?";
						}

						$this->bindValues[] =  $param[1];
					}elseif ($count_param == 3) {
						$this->where .= "`".trim($param[0]). "` ". $param[1]. " ?";
						$this->bindValues[] =  $param[2];
					}
				}
			}
			// end of is array
		}elseif ($num_args == 2) {
			$operators = explode(',', "=,>,<,>=,>=,<>,LIKE");
			$operatorFound = false;
			foreach ($operators as $operator) {
				if ( strpos($args[0], $operator) !== false ) {
					$operatorFound = true;
					break;
				}
			}

			if ($operatorFound) {
				$this->where .= $args[0]." ?";
			}else{
				$this->where .= "`".trim($args[0])."` = ?";
			}

			$this->bindValues[] =  $args[1];

		}elseif ($num_args == 3) {
			
			$this->where .= "`".trim($args[0]). "` ". $args[1]. " ?";
			$this->bindValues[] =  $args[2];
		}

		return $this;
	}

	// private function where_orWhere()
	// {

	// }

	public function get()
	{
		$this->assembleQuery();
		$this->getSQL = $this->sql;

		$stmt = $this->_db->prepare($this->sql);
		$stmt->execute($this->bindValues);
		$this->rowCount = $stmt->rowCount();

		$rows = $stmt->fetchAll(PDO::FETCH_CLASS,'MareiObj');
		$collection= [];
		$collection = new Fjt_MareiCollection;
		$x=0;
		foreach ($rows as $key => $row) {
			$collection->offsetSet($x++,$row);
		}

		return $collection;
	}
	// Quick get
	public function QGet()
	{
		$this->assembleQuery();
		$this->getSQL = $this->sql;

		$stmt = $this->_db->prepare($this->sql);
		$stmt->execute($this->bindValues);
		$this->rowCount = $stmt->rowCount();

		return $stmt->fetchAll();
	}

	public function getFirst($n = 0)
	{
		if($this->QGet())
			return $this->QGet()[$n];
	}


	private function assembleQuery()
	{
		if ( $this->columns !== null ) {
			$select = $this->columns;
		}else{
			$select = "*";
		}

		$this->sql = "SELECT  $select  FROM `$this->table` ";
		if ($this->join !== null) {
			$this->sql .= $this->join;//echo $this->sql;
		}

		if ($this->where !== null) {
			$this->sql .= $this->where;
		}

		if ($this->orderBy !== null) {
			$this->sql .= $this->orderBy;
		}

		if ($this->limit !== null) {
			$this->sql .= $this->limit;
		}
	}

	public function limit($limit, $offset=null)
	{
		if ($offset ==null ) {
			$this->limit = " LIMIT {$limit}";
		}else{
			$this->limit = " LIMIT {$limit} OFFSET {$offset}";
		}

		return $this;
	}

	/**
	 * Sort result in a particular order according to a column name
	 * @param  string $field_name The column name which you want to order the result according to.
	 * @param  string $order      it determins in which order you wanna view your results whether 'ASC' or 'DESC'.
	 * @return object             it returns DB object
	 */
	public function orderBy($field_name, $order = 'ASC')
	{
		$field_name = trim($field_name);

		$order =  trim(strtoupper($order));

		// validate it's not empty and have a proper valuse
		if ($field_name !== null && ($order == 'ASC' || $order == 'DESC')) {
			if ($this->orderBy ==null ) {
				$this->orderBy = " ORDER BY $field_name $order";
			}else{
				$this->orderBy .= ", $field_name $order";
			}
			
		}

		return $this;
	}
	/**
	 * Sort result in a table for another 
	 * @param  string $table_name The table name which you want to join the result according to.
	 * @param  string $where      it determins in which column you wanna view 
	 * @return object             it returns DB object
	 */
	public function Ijoin($table_name, $where = null)
	{
		// if (count($where) === 3) {
			$table_name = trim($table_name);
			$operators = array('=', '>', '<', '>=', '<=');
			$field    = $where[0];
			$operator = $where[1];
			$value    = $where[2];
		// validate it's not empty and have a proper valuse
		if ($table_name !== null) {
			if (in_array($operator, $operators)) {
				if ($this->join ==null ) {
					$this->join = " INNER JOIN $table_name ON {$field} {$operator} {$value}";
				}else{
					$this->join .= ", INNER JOIN $table_name ON {$field} {$operator} {$value}";
				}
			}
		}

		return $this;
	}
	public function Ljoin($table_name, $where = null)
	{
		// if (count($where) === 3) {
			$table_name = trim($table_name);
			$operators = array('=', '>', '<', '>=', '<=');
			$field    = $where[0];
			$operator = $where[1];
			$value    = $where[2];
		// validate it's not empty and have a proper valuse
		if ($table_name !== null) {
			if (in_array($operator, $operators)) {
				if ($this->join ==null ) {
					$this->join = " LEFT JOIN $table_name ON {$field} {$operator} {$value}";
				}else{
					$this->join .= ", LEFT JOIN $table_name ON {$field} {$operator} {$value}";
				}
			}
		}

		return $this;
	}

	public function paginate($page = 1, $limit = 5)
	{
		// Start assemble Query
		$countSQL = "SELECT COUNT(*) FROM `$this->table`";
		if ($this->where !== null) {
			$countSQL .= $this->where;
		}
		// Start assemble Query

		$stmt = $this->_db->prepare($countSQL);
		$stmt->execute($this->bindValues);
		$totalRows = $stmt->fetch(PDO::FETCH_NUM)[0];
		// echo $totalRows;

		$offset = ($page-1)*$limit;
		// Refresh Pagination Array
		$this->pagination['currentPage'] = $page;
		$this->pagination['lastPage'] = ceil($totalRows/$limit);
		$this->pagination['nextPage'] = $page + 1;
		$this->pagination['previousPage'] = $page-1;
		$this->pagination['totalRows'] = $totalRows;
		// if last page = current page
		if ($this->pagination['lastPage'] ==  $page) {
			$this->pagination['nextPage'] = null;
		}
		if ($page == 1) {
			$this->pagination['previousPage'] = null;
		}
		if ($page > $this->pagination['lastPage']) {
			return [];
		}

		$this->assembleQuery();

		$sql = $this->sql . " LIMIT {$limit} OFFSET {$offset}";
		$this->getSQL = $sql;

		$stmt = $this->_db->prepare($sql);
		$stmt->execute($this->bindValues);
		$this->rowCount = $stmt->rowCount();


		$rows = $stmt->fetchAll(PDO::FETCH_CLASS,'MareiObj');
		$collection= [];
		$collection = new Fjt_MareiCollection;
		$x=0;
		foreach ($rows as $key => $row) {
			$collection->offsetSet($x++,$row);
		}

		return $collection;
	}

	public function count()
	{
		// Start assemble Query
		$countSQL = "SELECT COUNT(*) FROM `$this->table`";

		if ($this->where !== null) {
			$countSQL .= $this->where;
		}

		if ($this->limit !== null) {
			$countSQL .= $this->limit;
		}
		// End assemble Query

		$stmt = $this->_db->prepare($countSQL);
		$stmt->execute($this->bindValues);

		$this->getSQL = $countSQL;

		return $stmt->fetch(PDO::FETCH_NUM)[0];
	}


	public function QPaginate($page = 1, $limit = 5)
	{
		// Start assemble Query
		$countSQL = "SELECT COUNT(*) FROM `$this->table`";
		if ($this->where !== null) {
			$countSQL .= $this->where;
		}
		// Start assemble Query

		$stmt = $this->_db->prepare($countSQL);
		$stmt->execute($this->bindValues);
		$totalRows = $stmt->fetch(PDO::FETCH_NUM)[0];
		// echo $totalRows;

		$offset = ($page-1)*$limit;
		// Refresh Pagination Array
		$this->pagination['currentPage'] = $page;
		$this->pagination['lastPage'] = ceil($totalRows/$limit);
		$this->pagination['nextPage'] = $page + 1;
		$this->pagination['previousPage'] = $page-1;
		$this->pagination['totalRows'] = $totalRows;
		// if last page = current page
		if ($this->pagination['lastPage'] ==  $page) {
			$this->pagination['nextPage'] = null;
		}
		if ($page == 1) {
			$this->pagination['previousPage'] = null;
		}
		if ($page > $this->pagination['lastPage']) {
			return [];
		}

		$this->assembleQuery();

		$sql = $this->sql . " LIMIT {$limit} OFFSET {$offset}";
		$this->getSQL = $sql;

		$stmt = $this->_db->prepare($sql);
		$stmt->execute($this->bindValues);
		$this->rowCount = $stmt->rowCount();

		return $stmt->fetchAll();
	}

	public function PaginationInfo()
	{
		return $this->pagination;
	}

	public function render($style = 3)//default to use bootstrap pagination
	{
		if ($style == 4) {
  			$html = '<ul class="pagination">';
  			//previous link button
	        if($this->pagination['currentPage']>1){
	            $html.= '<li class="page-item"><a class="page-link outline" href="?page='.($this->pagination['currentPage']-1).'" aria-label="Previous"';
	            $html.= '><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
	        }
	        //center link
	        $html.='<li class="active page-item"><a class="page-link" href="?page='.$this->pagination['currentPage'].'">'.$this->pagination['currentPage'].'</a></li>';
	    	
	    	//next link button
	        if(($this->pagination['currentPage'] < $this->pagination['lastPage'])){
	            $html.= '<li class="page-item"><a class="page-link outline" href="?page='.($this->pagination['currentPage']+1).'" aria-label="Next"';
	            $html.= '><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
	        }
	        $html .= '</ul>';
	        return $html;
		}

		$html  = '<ul class="pagination pagination-sm">';
        //previous link button
        if($this->pagination['currentPage']>1){
            $html.= '<li><a href="?page='.($this->pagination['currentPage']-1).'"';
            $html.= '>Prev</a></li>';
        }
        //center link
        $html.='<li class="active"><a href="?page='.$this->pagination['currentPage'].'">'.$this->pagination['currentPage'].'</a></li>';
        //next link button
        if(($this->pagination['currentPage'] < $this->pagination['lastPage'])){
            $html.= '<li><a href="?page='.($this->pagination['currentPage']+1).'"';
            $html.= '>Next</a></li>';
        }
        $html .= '</ul>';
        return $html;
	}

	public function getSQL()
	{
		return $this->getSQL;
	}

	public function getCount()
	{
		return $this->rowCount;
	}

	public function rowCount()
	{
		return $this->rowCount;
	}


}
// End Marei DB Class

//Start Marei Object Class
class MareiObj{

    public function toJSON()
    {
        return json_encode($this, JSON_NUMERIC_CHECK);
    }

    public function toArray()
    {
        return (array) $this;
    }

    public function __toString() {
        header("Content-Type: application/json;charset=utf-8");
        return json_encode($this, JSON_NUMERIC_CHECK);
    }
    
}
// End Marei Object Class

//Start Marei collection class
class Fjt_MareiCollection implements ArrayAccess{

       public function offsetSet($offset, $value) {
               $this->$offset = $value;
       }

       public function toJSON()
       {
           return json_encode($this->toArray(), JSON_NUMERIC_CHECK);
       }

       public function toArray()
       {
        // return (array) get_object_vars($this);
        $array = [];
        foreach ($this as  $mareiObj) {
          $array[] = (array) $mareiObj;
        }
           return $array;
       }

       /*public function list($field)
       {
	       	$list = [];
	       	foreach ($this as  $item) {
	       	  $list[] = $item->{$field};
	       	}
	       	return $list;
       }*/

       public function first($offset=0)
       {
           return isset($this->$offset) ? $this->$offset : null;
       }

       public function last($offset=null)
       {
           $offset = count($this->toArray())-1;
           return isset($this->$offset) ? $this->$offset : null;
       }

       public function offsetExists($offset) {
           return isset($this->$offset);
       }

       public function offsetUnset($offset) {
           unset($this->$offset);
       }

       public function offsetGet($offset) {
           return isset($this->$offset) ? $this->$offset : null;
       }


      public function item($key) {
          return isset($this->$key) ? $this->$key : null;
      }

      public function __toString() {
          header("Content-Type: application/json;charset=utf-8");
          // return json_encode(get_object_vars($this));
          return  $this->toJSON();

      }

}
// End Marei Collection Class
?>