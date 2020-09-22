<?php

class ClanudrugeController extends AutorizacijaController
{

    private $viewDir = 'privatno'
     . DIRECTORY_SEPARATOR 
     . 'clanudruge' 
     . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'clanovi'=>Clanudruge::ucitajSve()
        ]);
    }


}