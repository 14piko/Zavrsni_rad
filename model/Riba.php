<?php

class Riba
{
    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
                
        select a.sifra, a.naziv, a.pocetaklovostaja, a.krajlovostaja, 
        a.opis, count(b.sifra) as pecanje
        from riba a left join pecanje b on
        a.sifra=b.riba group by a.sifra, a.naziv, 
        a.pocetaklovostaja, a.krajlovostaja, a.opis;
                
        ');
        $izraz->execute();
        return $izraz->fetchAll();

    }
}