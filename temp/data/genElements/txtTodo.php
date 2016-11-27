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
		$this->value="";
		$this->placeholder="Type here something and hit enter.";
		$this->html="";
	}

}
