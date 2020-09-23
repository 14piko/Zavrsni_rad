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
            $clan=new stdClass();
            $clan->ime='';
            $clan->prezime='';
            $clan->oib='';
            $clan->brojdozvole='';
            $this->novoView('Unesite tražene podatke!', $clan);
            return;
        }

            //radi se o POST i moram kontrolirati prije unosa u bazu
            //kontroler mora kontrolirati vrijednosti prije nego se ode u bazu
            $clan=(object)$_POST;
            if(!$this->kontrolaNaziv($clan,'novoView')){return;};
            if(!$this->kontrolaPrezime($clan,'novoView')){return;};
            if(!$this->kontrolaOib($clan,'novoView')){return;};
            Clanudruge::dodajNovi($_POST);
            //ovo ispod unese i prebaci te na popis svih članova
            $this->index();

        
    }

        public function promjena()
        {
            if ($_SERVER['REQUEST_METHOD']==='GET'){
                //kontrolirati je li došla šifra u $_GET['sifra']
                //echo $_GET['sifra'];
                //print_r(Clanudruge::ucitaj($_GET['sifra']));
                $this->promjenaView('Promjenite podatke!',
                Clanudruge::ucitaj($_GET['sifra']));
                return;
            }

            $clan=(object)$_POST;
            if(!$this->kontrolaNaziv($clan,'promjenaView')){return;};
            if(!$this->kontrolaPrezime($clan,'promjenaView')){return;};
            if(!$this->kontrolaOib($clan,'promjenaView')){return;};

            Clanudruge::promjena($_POST);

            $this->index();
            

        }

        public function brisanje()
        {
            
            Clanudruge::brisanje($_GET['sifra']);
            $this->index();

        }

        private function novoView($poruka,$clan)
        {
            $this->view->render($this->viewDir . 'novo',[
                'poruka'=>$poruka,
                'clanudruge'=> $clan
            ]);
        }

        private function promjenaView($poruka,$clan)
        {
            $this->view->render($this->viewDir . 'promjena',[
                'poruka'=>$poruka,
                'clanudruge'=> $clan
            ]);
        }

        private function kontrolaNaziv($clan,$view)
        {
            if(strlen(trim($clan->ime))===0){
                $this->$view('Obavezan unos imena!',$clan);
                return false;
            }
            
            if(strlen(trim($clan->ime))>50){
                $this->$view('Dužina imena prevelika!',$clan);
                return false;
            }
                //na kraju uvijek vrati true
                return true;
            }

        private function kontrolaPrezime($clan,$view)
        {
            if(strlen(trim($clan->prezime))===0){
                $this->$view('Obavezan unos prezimena!',$clan);
                return false;
            }
            
            if(strlen(trim($clan->prezime))>50){
                $this->$view('Dužina prezimena prevelika!',$clan);
                return false;
            }
                //na kraju uvijek vrati true
                return true;
            }

        private function kontrolaOib($clan,$view)
        {
            if(strlen(trim($clan->oib))===0){
                $this->$view('Obavezan unos Oib-a!',$clan);
                return false;
            }
            
            if(strlen(trim($clan->oib))>11){
                $this->$view('Dužina Oib-a prevelika!',$clan);
                return false;
            }
                //na kraju uvijek vrati true
                return true;
            }



        }