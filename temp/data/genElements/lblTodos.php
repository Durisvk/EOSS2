<?php
class lblTodos { 

	/**
	 * @var string
	 */
	public $id;

	/**
	 * @var string
	 */
	public $type;

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

	/**
	 * @var array
	 */
	public $onenterpressed = array();


	public function __construct() { 
		$this->id="lblTodos";
		$this->type="div";
		$this->html="<b>TODOS:</b>";
	}

}
