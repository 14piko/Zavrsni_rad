<?php

class Clanudruge
{

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from clanudruge');
        $izraz->execute();
        return $izraz->fetchAll();

    }

    public static function dodajNovi($clan){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into clanudruge (ime,prezime,oib,brojdozvole) values (:ime,:prezime,:oib,:brojdozvole);');
        $izraz->execute($clan);

    }

}