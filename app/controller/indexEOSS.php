<?php

use EOSS\EOSS;

class indexEOSS extends EOSS
{
    public $counter = 1;

    public function load()
    {
        $this->csi->params->title = "Welcome To EOSS | EOSS2";
        $this->csi->setFile("indexView.php");
    }

    public function bind()
    {

        $this->csi->txtSource->onkeypress[] = "rewrite";
        $this->csi->txtTodo->onkeypress[] = "addTodo";
    }

    public function rewrite() {
        $this->csi->lblCopy->html = "<b>" . $this->csi->txtSource->value . "</b>";
    }

    public function addTodo($sender, $keyCode) {
        if($keyCode == 13) {
            $this->csi->lblTodos->html .= "<div><b>" . $this->counter . ".: </b>" . $this->csi->txtTodo->value . "</div>";
            $this->csi->txtTodo->value = "";
            $this->counter++;
        }
    }

}