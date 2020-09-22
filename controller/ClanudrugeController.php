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

        public function novo()
        {
            if ($_SERVER['REQUEST_METHOD']==='GET'){
            $this->view->render($this->viewDir . 'novo',[
                'poruka'=>'Unesite tražene podatke!'
            ]);
            return;
        }

            //radi se o POST i moram kontrolirati prije unosa u bazu
            //kontroler mora kontrolirati vrijednosti prije nego se ode u bazu
        
            Clanudruge::dodajNovi($_POST);

            $this->index();
        
    }

        public function promjena()
        {


        }

        public function brisanje()
        {


        }
        
}