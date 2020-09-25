<?php

class RibaController extends AutorizacijaController
{

    private $viewDir = 'privatno'
     . DIRECTORY_SEPARATOR 
     . 'riba' 
     . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index' , [
            'ribe'=>Riba::ucitajSve()
        ]);
    }

    public function novo()
    {
        if ($_SERVER['REQUEST_METHOD']==='GET'){
        $riba=new stdClass();
        $riba->naziv='';
        $riba->pocetaklovostaja='';
        $riba->krajlovostaja='';
        $riba->opis='';
        $this->novoView('Unesite tražene podatke!', $riba);
        return;
    }
        
        //radi se o POST i moram kontrolirati prije unosa u bazu
        //kontroler mora kontrolirati vrijednosti prije nego se ode u bazu
        $riba=(object)$_POST;
        if(!$this->kontrolaNaziv($riba,'novoView')){return;};
        Riba::dodajNovi($_POST);
        //ovo ispod unese i prebaci te na popis svih članova
        $this->index();


    
}

public function promjena()
{
    if ($_SERVER['REQUEST_METHOD']==='GET'){
        //kontrolirati je li došla šifra u $_GET['sifra']
        //echo $_GET['sifra'];
        //print_r(Riba::ucitaj($_GET['sifra']));
        $this->promjenaView('Promjenite podatke!',
        Riba::ucitaj($_GET['sifra']));
        return;
    }

    $riba=(object)$_POST;
    if(!$this->kontrolaNaziv($riba,'promjenaView')){return;};
   
    Riba::promjena($_POST);

    $this->index();
}

public function brisanje()
{
    
    Riba::brisanje($_GET['sifra']);
    $this->index();

}



private function novoView($poruka,$riba)
{
    $this->view->render($this->viewDir . 'novo',[
        'poruka'=>$poruka,
        'ribe'=>$riba
    ]);
}

private function promjenaView($poruka,$riba)
        {
            $this->view->render($this->viewDir . 'promjena',[
                'poruka'=>$poruka,
                'ribe'=> $riba
            ]);
        }

private function kontrolaNaziv($riba,$view)
        {
            if(strlen(trim($riba->naziv))===0){
                $this->$view('Obavezan unos naziva!',$riba);
                return false;
            }
            
            if(strlen(trim($riba->naziv))>50){
                $this->$view('Dužina naziva prevelika!',$riba);
                return false;
            }
                //na kraju uvijek vrati true
                return true;
            }



}

