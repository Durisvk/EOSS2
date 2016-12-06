<?php

namespace EOSS;


/**
 * CSI - stands for Client Side Interface
 * It's a class that contains all of the information
 * about the DOM structure of view.
 * Class CSI
 * @package EOSS
 */
class CSI
{
    /**
     * @var CSIAnalyze
     */
    protected $csiAnalyze;

    /**
     * @var EOSS
     */
    public $eoss;

    /**
     * @var string
     */
    protected $file;

    /**
     * Params that are sent to view.
     * @var null|Parameters
     */
    public $params = NULL;

    /**
     * @var array
     */
    public $bindings = [];

    /**
     * @var array
     */
    public $intervals = [];

    /**
     * CSI constructor.
     * @param EOSS $eoss
     */
    public function __construct(EOSS $eoss)
    {
        $this->params = new Parameters();
        $this->eoss = $eoss;
    }

    /**
     * Sets the view file and generates the backend for it.
     * @param string $dir
     */
    public function setFile($dir)
    {
        $this->file = $dir;
        //$obj = new \ReflectionClass($this->eoss);
        //$eossFile = $obj->getFileName();
        $this->csiAnalyze = new CSIAnalyze($this->file, get_class($this->eoss), $this);
        $this->eoss->loadGeneratedCSI();
    }

    /**
     * Returns the view file path.
     * @return string
     */
    public function getFile() {
        return $this->file;
    }

}