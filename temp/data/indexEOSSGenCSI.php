<?php
require_once __DIR__ . '/genElements/display.php';
require_once __DIR__ . '/genElements/b7.php';
require_once __DIR__ . '/genElements/b.php';
require_once __DIR__ . '/genElements/b8.php';
require_once __DIR__ . '/genElements/b9.php';
require_once __DIR__ . '/genElements/plus.php';
require_once __DIR__ . '/genElements/o.php';
require_once __DIR__ . '/genElements/b4.php';
require_once __DIR__ . '/genElements/b5.php';
require_once __DIR__ . '/genElements/b6.php';
require_once __DIR__ . '/genElements/minus.php';
require_once __DIR__ . '/genElements/b1.php';
require_once __DIR__ . '/genElements/b2.php';
require_once __DIR__ . '/genElements/b3.php';
require_once __DIR__ . '/genElements/multiple.php';
require_once __DIR__ . '/genElements/b0.php';
require_once __DIR__ . '/genElements/bc.php';
require_once __DIR__ . '/genElements/bce.php';
require_once __DIR__ . '/genElements/divide.php';
require_once __DIR__ . '/genElements/result.php';
require_once __DIR__ . '/genElements/negate.php';

class indexEOSSGenCSI extends \EOSS\CSI {



	/**
	 * @var display
	 */
	public $display;
	/**
	 * @var b7
	 */
	public $b7;
	/**
	 * @var b
	 */
	public $b;
	/**
	 * @var b8
	 */
	public $b8;
	/**
	 * @var b9
	 */
	public $b9;
	/**
	 * @var plus
	 */
	public $plus;
	/**
	 * @var o
	 */
	public $o;
	/**
	 * @var b4
	 */
	public $b4;
	/**
	 * @var b5
	 */
	public $b5;
	/**
	 * @var b6
	 */
	public $b6;
	/**
	 * @var minus
	 */
	public $minus;
	/**
	 * @var b1
	 */
	public $b1;
	/**
	 * @var b2
	 */
	public $b2;
	/**
	 * @var b3
	 */
	public $b3;
	/**
	 * @var multiple
	 */
	public $multiple;
	/**
	 * @var b0
	 */
	public $b0;
	/**
	 * @var bc
	 */
	public $bc;
	/**
	 * @var bce
	 */
	public $bce;
	/**
	 * @var divide
	 */
	public $divide;
	/**
	 * @var result
	 */
	public $result;
	/**
	 * @var negate
	 */
	public $negate;

	public function __construct($eoss) {

	parent::__construct($eoss);
		$this->eoss=$eoss;
		$this->file='/home/lchost/EOSS2/libs/../app/view/indexView.html';
		$this->display=new display;
		$this->b7=new b7;
		$this->b=new b;
		$this->b8=new b8;
		$this->b9=new b9;
		$this->plus=new plus;
		$this->o=new o;
		$this->b4=new b4;
		$this->b5=new b5;
		$this->b6=new b6;
		$this->minus=new minus;
		$this->b1=new b1;
		$this->b2=new b2;
		$this->b3=new b3;
		$this->multiple=new multiple;
		$this->b0=new b0;
		$this->bc=new bc;
		$this->bce=new bce;
		$this->divide=new divide;
		$this->result=new result;
		$this->negate=new negate;
	}
	public function setFile($dir) {
		$this->file=$dir;
		$this->csiAnalyze=new \EOSS\CSIAnalyze($dir, $this->eoss, $this);
		$this->eoss->loadGeneratedCSI();
	}
}
