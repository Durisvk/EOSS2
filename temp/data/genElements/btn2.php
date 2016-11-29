<?php
class btn2 { 

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
	public $data_group;

	/**
	 * @var string
	 */
	public $value;

	/**
	 * @var string
	 */
	public $html;

	/**
	 * @var array
	 */
	public $onclick = array();

	/**
	 * @var array
	 */
	public $onhover = array();

	/**
	 * @var array
	 */
	public $onchange = array();

	/**
	 * @var array
	 */
	public $onfocus = array();

	/**
	 * @var array
	 */
	public $onfocusin = array();

	/**
	 * @var array
	 */
	public $onfocusout = array();

	/**
	 * @var array
	 */
	public $onload = array();

	/**
	 * @var array
	 */
	public $onmousedown = array();

	/**
	 * @var array
	 */
	public $onkeypress = array();


	public function __construct() { 
		$this->type="button";
		$this->id="btn2";
		$this->data_group="buttons";
		$this->value="2";
		$this->html="";
	}

}
