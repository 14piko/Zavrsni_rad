<?php

class ClanudrugeController extends AutorizacijaController
{

    private $viewDir = 'privatno'
     . DIRECTORY_SEPARATOR 
     . 'clanudruge' 
     . DIRECTORY_SEPARATOR;

    public function index()
    {
        if(isset($_GET['uvjet'])){
            $uvjet='%' . $_GET['uvjet'] . '%';
            $uvjetView=$_GET['uvjet'];
        }else{
            $uvjet='%';
            $uvjetView='';
        }


        if(isset($_GET['stranica'])){
            $stranica=$_GET['stranica'];
        }else{
            $stranica=1;
        }

        if($stranica==1){
            $prethodna=1;
        }else{
            $prethodna=$stranica-1;
        }

        $brojPolaznika=Clanudruge::ukupnoStranica($uvjet);
        $ukupnoStranica=ceil($brojPolaznika/APP::config('rezultataPoStranici'));


        if($stranica==$ukupnoStranica){
            $slijedeca=$ukupnoStranica;
        }else{
            $slijedeca=$stranica+1;
        }


        $this->view->render($this->viewDir . 'index',[
            'clanovi'=>Clanudruge::ucitajSve($stranica,$uvjet),
            'trenutna'=>$stranica,
            'prethodna'=>$prethodna,
            'slijedeca'=>$slijedeca,
            'uvjet'=>$uvjetView,
            'ukupnoStranica'=>$ukupnoStranica

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
            $_GET['uvjet']=$clan->prezime;
            //ovo ispod unese i prebaci te na popis svih članova
            $this->index();

        
    }

        public function promjena()
        {
            if ($_SERVER['REQUEST_METHOD']==='GET'){
                //kontrolirati je li došla šifra u $_GET['sifra']
                //echo $_GET['sifra'];
                //print_r(Clanudruge::ucitaj($_GET['sifra']));
                $_SESSION['stranicaClan']=$_GET['stranica'];
                $this->promjenaView('Promjenite podatke!',
                Clanudruge::ucitaj($_GET['sifra']));
                
                return;
            }

            $clan=(object)$_POST;
            if(!$this->kontrolaNaziv($clan,'promjenaView')){return;};
            if(!$this->kontrolaPrezime($clan,'promjenaView')){return;};
            if(!$this->kontrolaOib($clan,'promjenaView')){return;};

            Clanudruge::promjena($_POST);
            $_GET['stranica']=$_SESSION['stranicaClan'];

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
                'clanudruge'=> $clan,
                'trenutna'=>$_SESSION['stranicaClan']
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
            $oib=$clan->oib;
            if ( strlen($oib) != 11 ) {
                $this->$view('OIB mora imati 11 znamenki!',$clan);
                return false;
            }
                if ( !is_numeric($oib) ) {
                    $this->$view('OIB ne smije sadržavati druge znakove osim brojeva!',$clan);
                    return false;
            }
                
                    
                    $a = 10;
                    
                    for ($i = 0; $i < 10; $i++) {
                        
                        $a = $a + intval(substr($oib, $i, 1), 10);
                        $a = $a % 10;
                        
                        if ( $a == 0 ) { $a = 10; }
                        
                        $a *= 2;
                        $a = $a % 11;
                        
                    }
                    
                    $kontrolni = 11 - $a;
                    
                    if ( $kontrolni == 10 ) { $kontrolni = 0; }
                    $rezultat = $kontrolni == intval(substr($oib, 10, 1), 10);
                    if(!$rezultat){
                        $this->$view('OIB neispravan!',$clan);
                    }
                    return $rezultat;
            }
        }