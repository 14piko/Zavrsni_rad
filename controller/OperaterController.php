<?php

class OperaterController extends AdminController
{

    private $viewDir = 'privatno'
     . DIRECTORY_SEPARATOR 
     . 'operater' 
     . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'entiteti'=>Operater::ucitajSve()
        ]);
    }

    public function novo()
    {
        if ($_SERVER['REQUEST_METHOD']==='GET'){
        $entitet=new stdClass();
        $entitet->email='';
        $entitet->ime='';
        $entitet->prezime='';
        $entitet->lozinka='';   
        $entitet->uloga='';
        $this->novoView('Unesite tražene podatke!', $entitet);
        return;
    }
        
        //radi se o POST i moram kontrolirati prije unosa u bazu
        //kontroler mora kontrolirati vrijednosti prije nego se ode u bazu
        $entitet=(object)$_POST;
        if(!$this->kontrolaIme($entitet,'novoView')){return;};
        if(!$this->kontrolaPrezime($entitet,'novoView')){return;};
        if(!$this->kontrolaEmail($entitet,'novoView')){return;};
        if(!$this->kontrolaLozinka($entitet,'novoView')){return;};
        if(!$this->kontrolaUloga($entitet,'novoView')){return;};
        Operater::dodajNovi($_POST);

        //ovo ispod unese i prebaci te na popis svih članova
        $this->index();
}
private function novoView($poruka,$entitet)
{
    $this->view->render($this->viewDir . 'novo',[
        'poruka'=>$poruka,
        'entitet'=>$entitet
    ]);
}

public function brisanje()
{
    
    Operater::brisanje($_GET['sifra']);
    $this->index();

}

public function promjena()
{
    if ($_SERVER['REQUEST_METHOD']==='GET'){
        //kontrolirati je li došla šifra u $_GET['sifra']
        //echo $_GET['sifra'];
        //print_r(Riba::ucitaj($_GET['sifra']));
        $this->promjenaView('Promjenite podatke!',
        Operater::ucitaj($_GET['sifra']));
        return;
    }

    $entitet=(object)$_POST;
    if(!$this->kontrolaIme($entitet,'promjenaView')){return;};
    if(!$this->kontrolaPrezime($entitet,'promjenaView')){return;};
    if(!$this->kontrolaEmail($entitet,'promjenaView')){return;};
    if(!$this->kontrolaLozinka($entitet,'promjenaView')){return;};
    if(!$this->kontrolaUloga($entitet,'promjenaView')){return;};
    Operater::promjena($_POST);

    $this->index();
}

private function promjenaView($poruka,$entitet)
        {
            $this->view->render($this->viewDir . 'promjena',[
                'poruka'=>$poruka,
                'entitet'=> $entitet
            ]);
        }


private function kontrolaIme($entitet,$view)
        {
            if(strlen(trim($entitet->ime))===0){
                $this->$view('Obavezan unos imena!',$entitet);
                return false;
            }
            
            if(strlen(trim($entitet->ime))>50){
                $this->$view('Dužina imena prevelika!',$entitet);
                return false;
            }
                //na kraju uvijek vrati true
                return true;
        }     
        
private function kontrolaPrezime($entitet,$view)
        {
            if(strlen(trim($entitet->prezime))===0){
                $this->$view('Obavezan unos prezimena!',$entitet);
                return false;
            }
            
            if(strlen(trim($entitet->prezime))>50){
                $this->$view('Dužina prezimena prevelika!',$entitet);
                return false;
            }
                //na kraju uvijek vrati true
                return true;
        } 
        
private function kontrolaEmail($entitet,$view)
        {
            if(strlen(trim($entitet->email))===0){
                $this->$view('Obavezan unos email-a!',$entitet);
                return false;
            }
            
            if(strlen(trim($entitet->email))>50){
                $this->$view('Dužina email-a prevelika!',$entitet);
                return false;
            }
                //na kraju uvijek vrati true
                return true;
        } 
        
        private function kontrolaLozinka($entitet,$view)
        {
            if(strlen(trim($entitet->lozinka))===0){
                $this->$view('Obavezan unos lozinke!',$entitet);
                return false;
            }
            
            if(strlen(trim($entitet->lozinka))>50){
                $this->$view('Dužina lozinke prevelika!',$entitet);
                return false;
            }
                //na kraju uvijek vrati true
                return true;
        }  
        
        private function kontrolaUloga($entitet,$view)
        {
            if(strlen(trim($entitet->uloga))===0){
                $this->$view('Obavezan unos uloge!',$entitet);
                return false;
            }
            
            if(strlen(trim($entitet->uloga))>50){
                $this->$view('Dužina uloge prevelika!',$entitet);
                return false;
            }
                //na kraju uvijek vrati true
                return true;
        }               


}