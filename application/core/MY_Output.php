<?php

class MY_Output extends CI_Output {

	const OUTPUT_MODE_NORMAL   = 10;
	const OUTPUT_MODE_TEMPLATE = 11;
	const TEMPLATE_ROOT        = "/";

	private $_title       = "";
	private $_charset     = "utf-8";
	private $_language    = "en-us";
	private $_canonical   = "";
	private $_meta        = array("keywords" => array(), "description" => null);
	private $_rdf         = array("keywords" => array(), "description" => null);
	private $_template    = null;
	private $_mode        = self::OUTPUT_MODE_NORMAL;
	private $_messages    = array("error" => "", "info" => "", "debug" => "");
	private $_output_data = array();

	/**
	 * Set the  template that should be contain the output <br /><em><b>Note:</b> This method set the output mode to MY_Output::OUTPUT_MODE_TEMPLATE</em>
	 *
	 * @param string $template_view
	 * @return void
	 * @uses MY_Output::set_mode()
	 */
	function set_template($template_view) {
		$this->set_mode(self::OUTPUT_MODE_TEMPLATE);
		$template_view = str_replace(".php", "", $template_view);
		$this->_template = self::TEMPLATE_ROOT . $template_view;
	}

	/*     * set_mode alias
	 *
	 * Enter description here ...
	 */

	function unset_template() {
		$this->_template = null;
		$this->set_mode(self::OUTPUT_MODE_NORMAL);
	}

	public function set_common_meta($title, $description, $keywords) {
		$this->set_meta("description", $description);
		$this->set_meta("keywords", $keywords);
		$this->set_title($title);
	}

	/**
	 * Sets the way that the final output should be handled.<p>Accepts two possible values    MY_Output::OUTPUT_MODE_NORMAL for direct output
	 * or MY_Output::OUTPUT_MODE_TEMPLATE for displaying the output contained in the specified template.</p>
	 *
	 * @throws Exception when the given mode hasn't defined.
	 * @param integer $mode one of the constants MY_Output::OUTPUT_MODE_NORMAL or MY_Output::OUTPUT_MODE_TEMPLATE
	 * @return void
	 */
	function set_mode($mode) {

		switch ($mode) {
			case self::OUTPUT_MODE_NORMAL:
			case self::OUTPUT_MODE_TEMPLATE:
				$this->_mode = $mode;
				break;
			default:
				throw new Exception(get_instance()->lang->line("Unknown output mode."));
		}

		return;
	}

	/**
	 * Set the title of a page, it works only with MY_Output::OUTPUT_MODE_TEMPLATE
	 *
	 *
	 * @param string $title
	 * @return void
	 */
	function set_title($title) {
		$this->_title = $title;
	}

	/**
	 * Append the given string at the end of the current page title
	 *
	 * @param string $title
	 * @return void
	 */
	function append_title($title) {
		$this->_title .= " - {$title}";
	}

	/**
	 * Prepend the given string at the bigining of the curent title.
	 *
	 * @param string $title
	 * @return void
	 */
	function prepend_title($title) {
		$this->_title = "{$title} - {$this->_title}";
	}

	function set_message($message, $type = "error") {
		$this->_messages[$type] .= $message;
	}

	/**
	 * (non-PHPdoc)
	 * @see system/libraries/CI_Output#_display($output)
	 */
	function _display($output = '') {

		if ($output == '')
			$output = $this->get_output();

		switch ($this->_mode) {
			case self::OUTPUT_MODE_TEMPLATE:
				$output = $this->get_template_output($output);
				break;
			case self::OUTPUT_MODE_NORMAL:
			default:
				$output = $output;
				break;
		}
		parent::_display($output);
	}

	function set_output_data($varname, $value) {
		$this->_output_data[$varname] = $value;
	}

	private function get_template_output($output) {

		if (function_exists("get_instance") && class_exists("CI_Controller")) {
			$ci = get_instance();

			$inline = $ci->load->get_inline_scripting();

			if ($inline["infile"] != "") {
				$checksum = md5($inline["infile"], false);
				$ci->load->driver('cache');
				$ci->cache->memcached->save($checksum, $inline["infile"], 5 * 60);
				$ci->load->js(site_url("content/js/{$checksum}.js"), true);
			}

			if (strlen($inline['stripped'])) {
				$inline['unstripped'] .= "\r\n\r\n<script type=\"text/javascript\">{$inline['stripped']}</script>";
			}

			$data = array();

			$css_files = $ci->load->get_css_files();
			$js_files = $ci->load->get_js_files();

			if (is_array($this->_meta["keywords"])) {
				$this->_meta["keywords"] = implode(" ,", $this->_meta["keywords"]);
			}

			$data["output"] = $output;
			$data["messages"] = $this->_messages;
			$data["title"] = $this->_title;
			$data["meta"] = $this->_meta;
			$data["language"] = $this->_language;
			$data["rdf"] = $this->_rdf;
			$data["charset"] = $this->_charset;
			$data["js_files"] = $js_files;
			$data["css_files"] = $css_files;
			$data["inline_scripting"] = $inline['unstripped'];
			$data["canonical"] = $this->_canonical;
			$data["ci"] = &get_instance();

			$data = array_merge($data, $this->_output_data);

			$output = $ci->load->view($this->_template, $data, true);
		}

		return $output;
	}

	/**
	 * Adds meta tags.
	 *
	 * @access public
	 * @param string $name the name of the meta tag
	 * @param string $content the content of the meta tag
	 * @return bool
	 */
	public function set_meta($name, $content) {
		$this->_meta[$name] = $content;
		return true;
	}

	public function set_canonical($url) {
		$this->_canonical = $url;
	}

}
