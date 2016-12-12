<?php

use EOSS\EOSS;


/**
 * Startup class.
 * Class indexEOSS
 */
class indexEOSS extends EOSS
{
    public $counter = 1;

    public $model;

    /**
     * @var array|\Binding\BindableCollection
     */
    public $collection = [["id" => 0, "name" => "Andrew Perkins", "age" => 25],
                            ["id" => 1, "name" => "John Doe", "age" => 43],
                            ["id" => 2, "name" => "Some Person", "age" => 32]];

    public function __construct(ExampleModel $model) {
        parent::__construct();

        $this->model = $model;
    }


/*    public function injectExampleModel(ExampleModel $model) {
        $this->model = $model;
    }*/

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
        $this->csi->setFile("indexView.latte.php");
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
        $this->csi->deletePerson->onclick[] = "deleteThePerson";
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
        $this->flashMessage("You've successfully clicked on " . $sender->value . " button.", "success");
        $sender->value += 1;
    }

    public function deleteThePerson($sender) {
        $this->collection->removeWhere("id", $sender->data_id);
    }


}