<?php
require_once __DIR__ . '/genElements/txtSource.php';
require_once __DIR__ . '/genElements/lblCopy.php';
require_once __DIR__ . '/genElements/lblTodos.php';
require_once __DIR__ . '/genElements/txtTodo.php';
require_once __DIR__ . '/genElements/lblButtons.php';
require_once __DIR__ . '/genElements/btn1.php';
require_once __DIR__ . '/genElements/buttons.php';
require_once __DIR__ . '/genElements/btn2.php';
require_once __DIR__ . '/genElements/btn3.php';

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
	/**
	 * @var lblButtons
	 */
	public $lblButtons;
	/**
	 * @var btn1
	 */
	public $btn1;
	/**
	 * @var buttons
	 */
	public $buttons;
	/**
	 * @var btn2
	 */
	public $btn2;
	/**
	 * @var btn3
	 */
	public $btn3;

	public function __construct($eoss) {

	parent::__construct($eoss);
		$this->eoss=$eoss;
		$this->file='/home/lchost/EOSS2/app/view/indexView.php';
		$this->txtSource=new txtSource;
		$this->lblCopy=new lblCopy;
		$this->lblTodos=new lblTodos;
		$this->txtTodo=new txtTodo;
		$this->lblButtons=new lblButtons;
		$this->btn1=new btn1;
		$this->buttons=new buttons;
		$this->btn2=new btn2;
		$this->btn3=new btn3;
	}
	public function setFile($dir) {
		$this->file=$dir;
		$this->csiAnalyze=new \EOSS\CSIAnalyze($dir, $this->eoss, $this);
		$this->eoss->loadGeneratedCSI();
	}
}
