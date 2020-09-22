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
            $this->novoView('Unesite tražene podatke!',[
                'ime'=>'',
                'prezime'=>'',
                'oib'=>'',
                'brojdozvole'=>''
            ]);
            return;
        }

            //radi se o POST i moram kontrolirati prije unosa u bazu
            //kontroler mora kontrolirati vrijednosti prije nego se ode u bazu
            $clan=$_POST;

            if(strlen(trim($clan['ime']))===0){
                $this->novoView('Obavezan unos imena!',$_POST);
                return;
            }



            Clanudruge::dodajNovi($_POST);

           //ovo ispod unese i prebaci te na popis svih članova
            //$this->index();

            //ovaj unese i ostavi te sa svim podacima na trenutnoj stranici
            $this->novoView('Uneseno! Nastavite s unosom novih podataka!',$_POST);
        
    }

        public function promjena()
        {


        }

        public function brisanje()
        {


        }

        private function novoView($poruka,$clan)
        {
            $this->view->render($this->viewDir . 'novo',[
                'poruka'=>$poruka,
                'clanudruge'=> $clan
            ]);
        }
        
}