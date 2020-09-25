<?php

class Riba
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
                
        select * from riba;
                
        ');
        $izraz->execute();
        return $izraz->fetchAll();

    }
}