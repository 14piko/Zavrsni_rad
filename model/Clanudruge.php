<?php

class Clanudruge
{

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
                select a.sifra, a.ime, a.prezime, a.oib, 
                a.brojdozvole, count(b.sifra) as pecanje
                from clanudruge a left join pecanje b on
                a.sifra=b.clanudruge group by a.sifra, a.ime, 
                a.prezime, a.oib, a.brojdozvole;
                
        ');
        $izraz->execute();
        return $izraz->fetchAll();

    }

    public static function dodajNovi($clan){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into clanudruge (ime,prezime,oib,brojdozvole) values (:ime,:prezime,:oib,:brojdozvole);');
        $izraz->execute($clan);

    }

    public static function brisanje($sifra){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('delete from clanudruge where sifra=:sifra;');
        $izraz->execute(['sifra'=>$sifra]);

    }

}