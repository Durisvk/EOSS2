<?php
require_once __DIR__ . '/genElements/buttons.php';
require_once __DIR__ . '/genElements/flashes.php';
require_once __DIR__ . '/genElements/txtSource.php';
require_once __DIR__ . '/genElements/lblCopy.php';
require_once __DIR__ . '/genElements/lblTodos.php';
require_once __DIR__ . '/genElements/txtTodo.php';
require_once __DIR__ . '/genElements/txtRange.php';
require_once __DIR__ . '/genElements/randomText1.php';
require_once __DIR__ . '/genElements/randomText2.php';
require_once __DIR__ . '/genElements/lblButtons.php';
require_once __DIR__ . '/genElements/personsList.php';
require_once __DIR__ . '/genElements/personsSelect.php';

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
	 * @var txtRange
	 */
	public $txtRange;
	/**
	 * @var randomText1
	 */
	public $randomText1;
	/**
	 * @var randomText2
	 */
	public $randomText2;
	/**
	 * @var lblButtons
	 */
	public $lblButtons;
	/**
	 * @var personsList
	 */
	public $personsList;
	/**
	 * @var personsSelect
	 */
	public $personsSelect;

	public function __construct($eoss) {

	parent::__construct($eoss);
		$this->eoss=$eoss;
		$this->file='/home/lchost/EOSS2/libs/../app/view/indexView.latte.php';
		$this->buttons=new buttons;
		$this->flashes=new flashes;
		$this->txtSource=new txtSource;
		$this->lblCopy=new lblCopy;
		$this->lblTodos=new lblTodos;
		$this->txtTodo=new txtTodo;
		$this->txtRange=new txtRange;
		$this->randomText1=new randomText1;
		$this->randomText2=new randomText2;
		$this->lblButtons=new lblButtons;
		$this->personsList=new personsList;
		$this->personsSelect=new personsSelect;
	}
	public function setFile($dir) {
		$this->file=$dir;
		$this->csiAnalyze=new \EOSS\CSIAnalyze($dir, $this->eoss, $this);
		$this->eoss->loadGeneratedCSI();
	}
}
