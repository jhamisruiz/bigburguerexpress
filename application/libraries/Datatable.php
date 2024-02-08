<?php

/**
 * @author Mauro Flores <maurosoft>
 * @email mauroflores8193@gmail.com
 */
class Datatable {

	protected $attribs       = array();
	protected $columns       = array();
	protected $fndblclick    = '';
	protected $tabla;
	protected $item          = false;
	protected $paramsNroItem = array();
	protected $selectedtr    = true;
	protected $multiselect   = false;

	public function setAttrib($attrib, $value) {
		$this->attribs[$attrib] = $value;
	}

	public function setFnDblclick($fndblclick) {
		$this->fndblclick = $fndblclick;
	}

	public function setMultiselect($multiselect) {
		$this->multiselect = $multiselect;
	}

	public function setNroItem($item, $paramsNroItem = array()) {
		$this->item = $item;
		$this->paramsNroItem = $paramsNroItem;
	}

	public function setSelectedTr($selectedtr) {
		$this->selectedtr = $selectedtr;
	}

	public function setTabla($tabla) {
		$this->tabla = $tabla;
	}

	public function getJsGrid() {
		$attribs = $this->attribs;
		$attribs['columns'] = isset($attribs['columns']) ? $attribs['columns'] : $this->columns;
		if ($this->item) {
			$field_item = array('title' => '&nbsp;', 'data' => 'item', 'width' => '2%', 'searchable' => false, 'orderable' => false);
			foreach ($this->paramsNroItem as $key => $paramNroItem) {
				$field_item[$key] = $paramNroItem;
			}
			$columnas = $attribs['columns'];
			$columns = array();
			$columns[] = $field_item;
			foreach ($columnas as $columna) {
				$columns[] = $columna;
			}
			$attribs['columns'] = $columns;
		}

		if (!isset($attribs['dom'])) {
			$attribs['dom'] = "<'top'<'col-sm-12'<'pull-left'f><'pull-right visible-md visible-lg'l>>>t<'bottom'><'col-sm-12'<'pull-left visible-md visible-lg'i><'pull-right'p>><'clear'>";
		}
		if (!isset($attribs['lengthMenu'])) {
			$attribs['lengthMenu'] = [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]];
		}

		$attribs = json_encode($attribs);
		$attribs = str_replace(array('"#!!', '!!#"'), '', $attribs);

		$grilla = array();
		$grilla[] = "var $this->tabla;";
		$grilla[] = "$(document).ready(function () {";
		$grilla[] = "   $this->tabla = $('#$this->tabla').DataTable($attribs);";
		$grilla[] = "   $this->tabla.columns().every( function () {
                            var that = this;
                            $( 'input:text, select', this.header() )
                                .on( 'keyup change', function (e) {
                                    var _this = this;
                                    if (e.keyCode == 13 && that.search() !== _this.value ) {
                                        that.search( _this.value ).draw();
                                    }
                                })
                                .on( 'click', function (e) {
                                    e.stopPropagation();
                                })
                                .on( 'keypress', function (e) {
                                    if (e.which == 13)
                                        e.stopPropagation();
                                });
                        });";
		if ($this->fndblclick != '') {
			$grilla[] = "$('.dataTable tbody').on('dblclick', 'tr', $this->fndblclick);";
		}
		$grilla[] = "});";
		return implode("\n", $grilla);
	}

}
