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

    public function formSubmitted(\Forms\SubmittedForm $form) {
        $this->csi->lblButtons->html = $form->username;
    }

}