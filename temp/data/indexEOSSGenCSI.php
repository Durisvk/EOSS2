<?php
require_once __DIR__ . '/genElements/txtSource.php';
require_once __DIR__ . '/genElements/lblCopy.php';
require_once __DIR__ . '/genElements/lblTodos.php';
require_once __DIR__ . '/genElements/txtTodo.php';

class indexEOSSGenCSI extends \EOSS\CSI {



	/**
	 * @var txtSource
	 */
	public $txtSource;
	/**
	 * @var lblCopy
	 */
	public $lblCopy;
	/**
	 * @var lblTodos
	 */
	public $lblTodos;
	/**
	 * @var txtTodo
	 */
	public $txtTodo;

	public function __construct($eoss) {

	parent::__construct($eoss);
		$this->eoss=$eoss;
		$this->file='/home/lchost/EOSS2/app/view/indexView.php';
		$this->txtSource=new txtSource;
		$this->lblCopy=new lblCopy;
		$this->lblTodos=new lblTodos;
		$this->txtTodo=new txtTodo;
	}
	public function setFile($dir) {
		$this->file=$dir;
		$this->csiAnalyze=new \EOSS\CSIAnalyze($dir, $this->eoss, $this);
		$this->eoss->loadGeneratedCSI();
	}
}
