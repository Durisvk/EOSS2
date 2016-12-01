<?php

use EOSS\EOSS;


/**
 * Startup class.
 * Class indexEOSS
 */
class indexEOSS extends EOSS
{
    public $counter = 1;

    /**
     * Load is called when the EOSS is initialized.
     * It should contain setFile to set the view, but
     * before that it should contain parameters sent to
     * the view. Forms should be created before setFile also
     * and they should be passed as a parameter to the view.
     */
    public function load()
    {
        $this->csi->params->title = "Welcome To EOSS | EOSS2";
        $this->csi->setFile("indexView.php");
    }

    /**
     * Bind is called when the CSI(Client Side Interface)
     * is generated. It should contain all of the basic
     * bindings to the events.
     */
    public function bind()
    {

        $this->csi->txtSource->onkeypress[] = "rewrite";
        $this->csi->txtTodo->onenterpressed[] = "addTodo";
        $this->csi->buttons->onclick[] = "showNumber";
    }
    
    public function rewrite($sender, $keyCode) {
        $this->csi->lblCopy->html = "<b>" . $this->csi->txtSource->value . "</b>";
    }

    public function addTodo($sender) {
        $this->csi->lblTodos->html .= "<div><b>" . $this->counter . ".: </b>" . $this->csi->txtTodo->value . "</div>";
        $this->csi->txtTodo->value = "";
        $this->counter++;
    }

    public function showNumber($sender) {
        $this->csi->lblButtons->html = $sender->value;
    }


}