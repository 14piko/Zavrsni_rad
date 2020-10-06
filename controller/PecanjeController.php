<?php

class PecanjeController extends AutorizacijaController
{

    private $viewDir = 'privatno'
     . DIRECTORY_SEPARATOR 
     . 'pecanje' 
     . DIRECTORY_SEPARATOR;

    public function index()
    {  
        $this->view->render($this->viewDir . 'index' ,[
            'entiteti'=>Pecanje::ucitajSve()
    ]);
    }

    public function promjena()
        {
           
            if ($_SERVER['REQUEST_METHOD']==='GET'){
                $this->promjenaView('Promjenite željene podatke',
                Pecanje::ucitaj($_GET['sifra']));
                return;
            }
    
            $entitet=(object)$_POST;
            if(!$this->kontrolaClan($entitet,'promjenaView')){return;};
            if(!$this->kontrolaRiba($entitet,'promjenaView')){return;};
            if(!$this->kontrolaRijeka($entitet,'promjenaView')){return;};
            
            Pecanje::promjena($_POST);
    
            $this->index();
    
        }

    public function novo()
    {
        if ($_SERVER['REQUEST_METHOD']==='GET'){
            $entitet=new stdClass();
            $entitet->datum='';
            $entitet->clanudruge=0;
            $entitet->riba=0;
            $entitet->kolicina='';
            $entitet->tezina='';
            $entitet->rijeka=0;
            $this->novoView('Unesite tražene podatke',$entitet);
            return;
        }
        $entitet=(object)$_POST;
        if(!$this->kontrolaClan($entitet,'novoView')){return;};
        if(!$this->kontrolaRiba($entitet,'novoView')){return;};
        if(!$this->kontrolaRijeka($entitet,'novoView')){return;};
        Pecanje::dodajNovi($_POST);
        $this->index();
    }
    
        






        
        public function brisanje()
        {
            Pecanje::brisanje($_GET['sifra']);
            $this->index();
        }

        private function novoView($poruka,$entitet)
        {
           $this->view->render($this->viewDir . 'novo',[
               'poruka'=>$poruka,
               'entitet'=>$entitet,
               'ribe'=>Riba::ucitajSve(),
               'rijeke'=>Rijeka::ucitajSve(),
               'clanudruge'=>Clanudruge::ucitajSve(1,'%'),
               
              
           ]);
        }

        private function promjenaView($poruka,$entitet)
        {
            $this->view->render($this->viewDir . 'promjena',[
                'poruka'=>$poruka,
                'entitet'=>$entitet,
                'ribe'=>Riba::ucitajSve(),
               'rijeke'=>Rijeka::ucitajSve(),
               'clanudruge'=>Clanudruge::ucitajSve(1,'%'),
            ]);
        }
    
        private function kontrolaClan($entitet,$view)
        {
            if($entitet->clanudruge==0){
                $this->$view('Obavezan odabir člana!',$entitet);
                return false;
            }
            
                //na kraju uvijek vrati true
                return true;
            }


    private function kontrolaRiba($entitet,$view)
        {
            if($entitet->riba==0){
            $this->$view('Obavezan odabir ribe!',$entitet);
            return false;
            }
                
            //na kraju uvijek vrati true
            return true;
        }

    private function kontrolaRijeka($entitet,$view)
        {
            if($entitet->rijeka==0){
            $this->$view('Obavezan odabir rijeke!',$entitet);
            return false;
            }
                    
            //na kraju uvijek vrati true
            return true;
        }
    }

