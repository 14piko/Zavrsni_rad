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



}