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

    public function novo()
    {
        if ($_SERVER['REQUEST_METHOD']==='GET'){
            $pecanje=new stdClass();
            $pecanje->datum='';
            $pecanje->clan=0;
            $pecanje->riba=0;
            $pecanje->kolicina='';
            $pecanje->tezina='';
            $pecanje->rijeka=0;
            $this->novoView('Unesite tražene podatke',$pecanje,
            Clanudruge::ucitajSve(1,'%'),
            Riba::ucitajSve(),
            Rijeka::ucitajSve()
            );
            return;
        }
        $pecanje=(object)$_POST;
        Pecanje::dodajNovi($_POST);
        $this->index();
    }
    
        






        
        public function brisanje()
        {
            Pecanje::brisanje($_GET['sifra']);
            $this->index();
        }

        private function novoView($poruka,$pecanje,$clanovi,$ribe,$rijeke)
        {
           $this->view->render($this->viewDir . 'novo',[
               'poruka'=>$poruka,
               'pecanje'=>$pecanje,
               'ribe'=>$ribe,
               'rijeke'=>$rijeke,
               'clanovi'=>$clanovi
              
           ]);
        }

        private function promjenaView($poruka,$pecanje)
        {
            $this->view->render($this->viewDir . 'promjena',[
                'poruka'=>$poruka,
                'pecanje'=>$pecanje
            ]);
        }

    }

