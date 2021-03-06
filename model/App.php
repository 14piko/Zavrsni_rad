<?php

class App 
{
    public static function start()
    {
        $ruta = Request::getRuta();

        $djelovi=explode('/',$ruta);

        $klasa='';
        if(!isset($djelovi[1]) || $djelovi[1]===''){
            $klasa='Index';
        }else{
            $klasa=ucfirst($djelovi[1]);
        }

        $klasa .='Controller';

        $funkcija='';
        if(!isset($djelovi[2]) || $djelovi[2]===''){
            $funkcija='index';
        }else{
            $funkcija=$djelovi[2];
        }

        if(class_exists($klasa) && method_exists($klasa,$funkcija)){
            $instanca = new $klasa();
            $instanca->$funkcija();
        }else{
            // integrirati u view
            $ic= new IndexController();
            $ic->notfound('Kreirati funkciju unutar klase ' . $klasa . '-&gt;' . $funkcija);
            //echo 'Kreirati funkciju unutar klase ' . $klasa . '-&gt;' . $funkcija;
        }
        
    }

    public static function config($kljuc)
    {
        $datoteka = BP . 'konfiguracija.php';
        $konfiguracija = include $datoteka;

        if(array_key_exists($kljuc,$konfiguracija)){
            return $konfiguracija[$kljuc];
        }else if ($konfiguracija['dev']){
            return 'Ključ ' . $kljuc . ' ne postoji u ' . $datoteka;
        }else{
            return 'Ključ ' . $kljuc . ' ne postoji';
        }
    }
}