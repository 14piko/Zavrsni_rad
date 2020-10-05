<?php

class PecanjeController extends AutorizacijaController
{

    private $viewDir = 'privatno'
     . DIRECTORY_SEPARATOR 
     . 'pecanje' 
     . DIRECTORY_SEPARATOR;

    public function index()
    {  
        $pecanja=Pecanje::ucitajSve();
        $this->view->render($this->viewDir . 'index' ,[
            'pecanja'=>$pecanja
    ]);
    }

    public function promjena()
        {
    
        }

            
        






        
        public function brisanje()
        {
            
           
        }

        private function novoView($poruka,$clan)
        {
           
        }

        private function promjenaView($poruka,$clan)
        {
           
        }

    }

