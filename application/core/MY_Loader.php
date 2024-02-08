<?php

class MY_Loader extends CI_Loader {

	private $_javascript       = array();
	private $_css              = array();
	private $_inline_scripting = array("infile" => "", "stripped" => "", "unstripped" => "");

	function __construct() {
		parent::__construct();
	}

	function css() {
		$css_files = func_get_args();

		foreach ($css_files as $css_file) {
			$css_file = substr($css_file, 0, 1) == '/' ? substr($css_file, 1) : $css_file;

			$is_external = false;
			if (is_bool($css_file))
				continue;

			$is_external = preg_match("/^https?:\/\//", trim($css_file)) > 0 ? true : false;


			if (!$is_external)
				if (!file_exists($css_file))
					show_error("Cannot locate stylesheet file: {$css_file}.");

			$css_file = $is_external == FALSE ? base_url() . $css_file : $css_file;

			if (!in_array($css_file, $this->_css))
				$this->_css[] = $css_file;
		}

		return $this;
	}

	function js() {
		$script_files = func_get_args();

		foreach ($script_files as $script_file) {
			$script_file = substr($script_file, 0, 1) == '/' ? substr($script_file, 1) : $script_file;

			if (is_bool($script_file))
				continue;

			$is_external = preg_match("/^https?:\/\//", trim($script_file)) > 0 ? true : false;

			if (!$is_external)
				if (!file_exists($script_file))
					show_error("Cannot locate javascript file: {$script_file}.");
			
			$script_file = $is_external == FALSE ? base_url() . $script_file : $script_file;

			if (!in_array($script_file, $this->_javascript))
				$this->_javascript[] = $script_file;
		}

		return $this;
	}

	function get_css_files() {
		return $this->_css;
	}

	function get_js_files() {
		return $this->_javascript;
	}


	function start_inline_scripting() {
		ob_start();
	}

	function end_inline_scripting($strip_tags = true, $append_to_file = true) {
		$source = ob_get_clean();

		if ($strip_tags) {
			$source = preg_replace("/<script.[^>]*>/", '', $source);
			$source = preg_replace("/<\/script>/", '', $source);
		}

		if ($append_to_file) {

			$this->_inline_scripting['infile'] .= $source;
		} else {

			if ($strip_tags) {
				$this->_inline_scripting['stripped'] .= $source;
			} else {
				$this->_inline_scripting['unstripped'] .= $source;
			}
		}
	}

	function get_inline_scripting() {
		return $this->_inline_scripting;
	}
}
