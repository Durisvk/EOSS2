<?php
class txtSource { 

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
		$this->id="txtSource";
		$this->value="";
		$this->placeholder="Type here something";
		$this->html="";
	}

}
