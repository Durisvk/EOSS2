<?php
class txtTodo { 

	/**
	 * @var string
	 */
	public $type;
	/**
	 * @var string
	 */
	public $id;
	/**
	 * @var string
	 */
	public $data_test;
	/**
	 * @var string
	 */
	public $value;
	/**
	 * @var string
	 */
	public $placeholder;
	/**
	 * @var string
	 */
	public $html;

	public function __construct() { 
		$this->type="text";
		$this->id="txtTodo";
		$this->data_test="asdf";
		$this->value="";
		$this->placeholder="Type here something and hit enter.";
		$this->html="";
	}

}
