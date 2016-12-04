<?php

use EOSS\EOSS;

class indexEOSS extends EOSS
{
    public $number = NULL;
    public $operator = NULL;
    public $newNumber = true;
    public $enterPressed = false;

    public function load()
    {
        $this->csi->setFile("indexView.html");
    }

    public function bind()
    {
        $this->csi->b->onclick[] = "writeToDisplay";
        $this->csi->bc->onclick[] = "clearAll";
        $this->csi->bce->onclick[] = "clearLast";
        $this->csi->o->onclick[] = "onOperator";
        $this->csi->result->onclick[] = "evaluate";
        $this->csi->calc->onkeydown[] = "keyDown";
        $this->csi->calc->onkeypressed[] = "keyPressed";
    }

    public function writeToDisplay($sender,$anumber=-1)
    {
        if($this->WasEnterPressed())
            return;
        if($this->newNumber || $this->csi->display->html == "0")
        {
            $this->csi->display->html = $anumber != -1 ? strval($anumber) : strval($sender->value);
            $this->newNumber = false;
        }
        else
        {
            $this->csi->display->html .=  $anumber != -1 ? strval($anumber) : strval($sender->value);
        }
    }

    public function clearAll()
    {
        if($this->WasEnterPressed())
            return;
        $this->csi->display->html = '0';
        $this->newNumber = true;
    }

    public function clearLast()
    {
        if($this->WasEnterPressed())
            return;
        if(strlen($this->csi->display->html) == 1 || ($this->csi->display->html < 0 && strlen($this->csi->display->html)==2))
            $this->clearAll();
        else
            $this->csi->display->html = substr($this->csi->display->html,0,-1);
    }

    public function onOperator($sender,$op=NULL)
    {
        if($this->WasEnterPressed())
            return;
        $op = $op? : $sender->value;
        switch($op)
        {
            case '+/-':
                $this->csi->display->html = -$this->csi->display->html;
                break;
            default:
                if($this->number!=NULL)
                    $this->evaluate();
                $this->number = $this->csi->display->html;
                $this->operator = $op;
                $this->newNumber = true;
        }
    }

    public function evaluate()
    {
        if($this->WasEnterPressed())
            return;
        switch($this->operator)
        {
            case '+':
                $this->csi->display->html += $this->number;
                break;
            case '-':
                $this->csi->display->html = $this->number - $this->csi->display->html;
                break;
            case '*':
                $this->csi->display->html *= $this->number;
                break;
            case '/':
                $this->csi->display->html = $this->number / $this->csi->display->html;
                break;
        }
        $this->newNumber = true;
        $this->number = NULL;
    }

    public function keyPressed($sender, $charCode)
    {
        if($charCode>47 && $charCode<58)
            $this->writeToDisplay(NULL,$charCode - 48);
        else
            switch($charCode)
            {
                case 46:
                    $this->writeToDisplay(NULL,"."); //chr($charCode));
                case 42:
                case 43:
                case 45:
                case 47:
                    $this->onOperator(NULL,chr($charCode));
                    break;
                case 13:
                    $this->evaluate();
                    $this->enterPressed = true;
                    break;
            }
    }

    private function WasEnterPressed()
    {
        $result = $this->enterPressed;
        $this->enterPressed = false;
        return $result;
    }

    public function keyDown($sender, $keyCode)
    {
        switch($keyCode)
        {
            case 8:
                $this->clearLast();
                break;
            case 27:
                $this->clearAll();
                break;
        }
    }
}