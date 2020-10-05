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
            $pecanje->clanovi=0;
            $pecanje->riba=0;
            $pecanje->kolicina='';
            $pecanje->tezina='';
            $pecanje->rijeka=0;
            $this->novoView('Unesite tražene podatke',$pecanje);
            return;
        }
        $pecanje=(object)$_POST;
        if(!$this->kontrolaClan($pecanje,'novoView')){return;};
        if(!$this->kontrolaRiba($pecanje,'novoView')){return;};
        if(!$this->kontrolaRijeka($pecanje,'novoView')){return;};
        Pecanje::dodajNovi($_POST);
        $this->index();
    }
    
        






        
        public function brisanje()
        {
            Pecanje::brisanje($_GET['sifra']);
            $this->index();
        }

        private function novoView($poruka,$pecanje)
        {
           $this->view->render($this->viewDir . 'novo',[
               'poruka'=>$poruka,
               'pecanje'=>$pecanje,
               'ribe'=>Riba::ucitajSve(),
               'rijeke'=>Rijeka::ucitajSve(),
               'clanovi'=>Clanudruge::ucitajSve(1,'%')
              
           ]);
        }

        private function promjenaView($poruka,$pecanje)
        {
            $this->view->render($this->viewDir . 'promjena',[
                'poruka'=>$poruka,
                'pecanje'=>$pecanje,
                'ribe'=>Riba::ucitajSve(),
               'rijeke'=>Rijeka::ucitajSve(),
               'clanovi'=>Clanudruge::ucitajSve(1,'%')
            ]);
        }
    
        private function kontrolaClan($pecanje,$view)
        {
            if($pecanje->clanovi==0){
                $this->$view('Obavezan odabir člana!',$pecanje);
                return false;
            }
            
                //na kraju uvijek vrati true
                return true;
            }


    private function kontrolaRiba($pecanje,$view)
        {
            if($pecanje->riba==0){
            $this->$view('Obavezan odabir ribe!',$pecanje);
            return false;
            }
                
            //na kraju uvijek vrati true
            return true;
        }

    private function kontrolaRijeka($pecanje,$view)
        {
            if($pecanje->rijeka==0){
            $this->$view('Obavezan odabir rijeke!',$pecanje);
            return false;
            }
                    
            //na kraju uvijek vrati true
            return true;
        }
    }

