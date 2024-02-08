<?php

/**
 * @author Mauro Flores <maurosoft>
 * @email mauroflores8193@gmail.com
 */
class Datatabledb {

	private $columnaId;
	private $sqlSelect;
	private $sqlFrom;
	private $sqlWhere;
	private $sqlGroupBy;
	private $sqlHaving;
	private $sqlOrderBy;
	private $params;
	private $conection = 'default';

	public function setColumnaId($columnaId) {
		$this->columnaId = $columnaId;
	}

	public function setConection($conection) {
		$this->conection = $conection;
	}

	public function setSelect($sql) {
		$this->sqlSelect = $sql;
	}

	public function setFrom($sql) {
		$this->sqlFrom = $sql;
	}

	public function setWhere($sql) {
		$this->sqlWhere = $sql;
	}

	public function setGroupBy($sql) {
		$this->sqlGroupBy = $sql;
	}

	public function setHaving($sql) {
		$this->sqlHaving = $sql;
	}

	public function setOrder($sql) {
		$this->sqlOrderBy = $sql;
	}

	public function setParams($params) {
		$this->params = $params;
	}

	public function getJson() {
		$CI = &get_instance();
		$db = $CI->load->database($this->conection, TRUE);
		$params = $this->params;
		$draw = $params['draw'];
		$columns = $params['columns'];
		$start = $params['start'];
		$length = $params['length'];
		$search = $params['search']['value'];

		$where_and = array();
		if (strlen(trim($this->sqlWhere)) > 0) {
			$where_and[] = $this->sqlWhere;
		}
		$where_or = array();
		foreach ($columns as $column) {
			if ($column['searchable'] == "true" && $column['name'] != '') {
				if (isset($column['search']['value']) && $column['search']['value'] != '') {
					switch ($db->dbdriver) {
						case 'mysqli':
							$where_and[] = " CONVERT({$column['name']}, CHAR) LIKE '%{$column['search']['value']}%' ";
							break;
						case 'sqlsrv':
							$where_and[] = " CONVERT(text, {$column['name']}) LIKE '%{$column['search']['value']}%' ";
							break;
					}
				} elseif ($search != '') {
					switch ($db->dbdriver) {
						case 'mysqli':
							$where_or[] = " CONVERT({$column['name']}, CHAR) LIKE '%$search%' ";
							break;
						case 'sqlsrv':
							$where_or[] = " CONVERT(text, {$column['name']}) LIKE '%$search%' ";
							break;
					}
				}
			}
		}
		if (count($where_or) > 0) {
			$where_and[] = '(' . implode(' or ', $where_or) . ')';
		}
		$where = '';
		if (count($where_and) > 0) {
			$where = " WHERE " . implode(' and ', $where_and);
		}

		$groupby = "";
		if (strlen(trim($this->sqlGroupBy)) > 0) {
			$groupby = " GROUP BY " . $this->sqlGroupBy;
		}

		$having = "";
		if (strlen(trim($this->sqlHaving)) > 0) {
			$having = " HAVING " . $this->sqlHaving;
		}

		$orderby = array();
		if (strlen(trim($this->sqlOrderBy)) > 0) {
			$orderby[] = $this->sqlOrderBy;
		}
		if (isset($params['order'])) {
			foreach ($params['order'] as $order) {
				if ($columns[$order['column']]['name'] != "") {
					$orderby[] = $columns[$order['column']]['name'] . ' ' . $order['dir'];
				}
			}
		}
		$orderby = (count($orderby) > 0) ? " ORDER BY " . implode(',', $orderby) : '';

		$sqlCount = "SELECT count($this->columnaId) as cantidad FROM {$this->sqlFrom} $where";

		switch ($db->dbdriver) {
			case 'sqlsrv':
				$sql = "SELECT {$this->columnaId} as pk, {$this->sqlSelect} FROM {$this->sqlFrom} $where $groupby $having $orderby";
				if ($length != -1) {
					$desde = $start + 1;
					$hasta = $start + $length;
					$sql = "select * from (select TOP 100 PERCENT {$this->columnaId} as pk, {$this->sqlSelect}, row_number() over (order by (select 0)) as row_num FROM {$this->sqlFrom} $where $groupby $having $orderby) as temp_table where row_num between $desde and $hasta";
				}
				break;
			case 'mysqli':
				$limit_offset = '';
				if ($length != -1) {
					$limit_offset = "LIMIT $length OFFSET $start";
				}
				$sql = "SELECT {$this->columnaId} as pk, {$this->sqlSelect} FROM {$this->sqlFrom} $where $groupby $having $orderby $limit_offset";
				break;
		}


		$error = '';
		$return = array();
		try {
//            throw new Exception($sqlCount);
//          throw new Exception($sql);
			$recordsTotal = $db->query($sqlCount)->row_array();
			$recordsTotal = $recordsTotal['cantidad'];

			$return['draw'] = $draw;
			$return['recordsTotal'] = $recordsTotal;
			$return['recordsFiltered'] = $recordsTotal;
			$data = array();
			$item = $start;
			$resultados = $db->query($sql)->result_array();
			foreach ($resultados as $i => $resultado) {
				$item++;
				$DT_RowId = array_shift($resultado);
				$data[$i] = $resultado;
				$data[$i]['item'] = $item;
				$data[$i]['DT_RowId'] = $DT_RowId;
			}
			$return['data'] = $data;
		} catch (Exception $ex) {
			$return['error'] = $ex->getMessage();
		}
		echo json_encode($return);
	}

}
