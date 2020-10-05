<?php

class Pecanje
{

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.sifra,c.naziv as riba ,d.naziv as rijeka,
        concat(b.ime,\' \',b.prezime) as clanudruge,
        a.datum,a.kolicina,a.tezina,count(a.clanudruge) as clanovi from pecanje a
        inner join clanudruge b on a.clanudruge=b.sifra
        left join riba c on a.riba=c.sifra 
        left join rijeka d on a.rijeka=d.sifra
        group by a.sifra,c.naziv ,d.naziv,
        concat(b.ime,\' \',b.prezime),
        a.datum,a.kolicina,a.tezina;');
        $izraz->execute();
        return $izraz->fetchAll();
       

    }

    public static function dodajNovi($clan)
    {
        

    }

    public static function brisanje($sifra)
    {
        
    }

    public static function ukupnoStranica($uvjet)
    {
      

    }

    public static function ucitaj($sifra)
    {
     
    }

    public static function promjena($clan)
    {
      
    }

}