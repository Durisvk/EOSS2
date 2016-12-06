<?php
require_once __DIR__ . '/genElements/buttons.php';
require_once __DIR__ . '/genElements/flashes.php';
require_once __DIR__ . '/genElements/txtSource.php';
require_once __DIR__ . '/genElements/lblCopy.php';
require_once __DIR__ . '/genElements/lblTodos.php';
require_once __DIR__ . '/genElements/txtTodo.php';
require_once __DIR__ . '/genElements/lblButtons.php';

class indexEOSSGenCSI extends \EOSS\CSI {



	/**
	 * @var buttons
	 */
	public $buttons;
	/**
	 * @var flashes
	 */
	public $flashes;
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

	public function __construct($eoss) {

	parent::__construct($eoss);
		$this->eoss=$eoss;
		$this->file='/home/lchost/EOSS2/app/view/indexView.twig.php';
		$this->buttons=new buttons;
		$this->flashes=new flashes;
		$this->txtSource=new txtSource;
		$this->lblCopy=new lblCopy;
		$this->lblTodos=new lblTodos;
		$this->txtTodo=new txtTodo;
		$this->lblButtons=new lblButtons;
	}
	public function setFile($dir) {
		$this->file=$dir;
		$this->csiAnalyze=new \EOSS\CSIAnalyze($dir, $this->eoss, $this);
		$this->eoss->loadGeneratedCSI();
	}
}
