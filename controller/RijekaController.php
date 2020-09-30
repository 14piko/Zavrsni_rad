<?php

class RijekaController extends AutorizacijaController
{

    private $viewDir = 'privatno'
     . DIRECTORY_SEPARATOR 
     . 'rijeka' 
     . DIRECTORY_SEPARATOR;

    public function index()
    {
        
        $rijeke= Rijeka::ucitajSve();
        $this->view->render($this->viewDir . 'index' ,[
            'rijeke'=>$rijeke
        ]);
    }

    public function novo()
    {
        if ($_SERVER['REQUEST_METHOD']==='GET'){
            $rijeke=new stdClass();
            $rijeke->naziv='';
            $rijeke->duzina='';
            $this->novoView('Unesite tražene podatke',$rijeke);
            return;
        }


        //radi se o POST i moram kontrolirati prije unosa u bazu
        // kontroler mora kontrolirati vrijednosti prije nego se ode u bazu
        $rijeke=(object)$_POST;

        if(!$this->kontrolaNaziv($rijeke,'novoView')){return;};

        Rijeka::dodajNovi($_POST);

        $this->index();

    }


    public function promjena()
    {
        if ($_SERVER['REQUEST_METHOD']==='GET'){
             $this->promjenaView('Promjenite željene podatke',
             Rijeka::ucitaj($_GET['sifra']));
             return;
         }
 
         $rijeka=(object)$_POST;
         if(!$this->kontrolaNaziv($rijeka,'promjenaView')){return;};
         
         Rijeka::promjena($_POST);
 
         $this->index();
 
 
    }

    public function brisanje()
    {
        Rijeka::brisanje($_GET['sifra']);
        $this->index();
    }

    private function novoView($poruka,$rijeka)
    {
        $this->view->render($this->viewDir . 'novo',[
            'poruka'=>$poruka,
            'rijeka' => $rijeka
        ]);
    }

    private function promjenaView($poruka,$rijeka)
    {
        $this->view->render($this->viewDir . 'promjena',[
            'poruka'=>$poruka,
            'rijeka' => $rijeka
        ]);
    }

    private function kontrolaNaziv($rijeka, $view)
    {
        if(strlen(trim($rijeka->naziv))===0){
            $this->$view('Obavezno unos naziva',$rijeka);
            return false;
        }

        if(strlen(trim($rijeka->naziv))>50){
            $this->$view('Dužina naziva prevelika',$rijeka);
            return false;
        }
        // na kraju uvijek vrati true
        return true;
    }


} 


