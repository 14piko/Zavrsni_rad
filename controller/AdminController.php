<?php

class AdminController extends AutorizacijaController
{
    private $viewDir = 'privatno'
    . DIRECTORY_SEPARATOR 
    . 'operater' 
    . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index' , [
               'entiteti'=>Operater::ucitajSve()
            
           ]);
       }


    public function __construct()
    {
        parent::__construct();
        if($_SESSION['autoriziran']->uloga!=='admin'){
            unset($_SESSION['autoriziran']);
            session_destroy();
            $this->view->render('login',[
                'email'=> '',
                'poruka'=> 'Prvo se autorizirajte s operaterom koji ima ulogu s traženim ovlastima!'
            ]);
            exit;
        }
   
    }
}