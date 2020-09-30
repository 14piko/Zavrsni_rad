<?php 

class Rijeka
{

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.sifra,a.naziv,a.duzina, 
        count(b.sifra) as pecanje from rijeka a left join pecanje b on a.sifra=b.rijeka
        group by a.sifra,a.naziv,a.duzina;');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
                select * from rijeka where sifra=:sifra;
        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function dodajNovi($rijeke){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into rijeka (naziv,duzina)
        values (:naziv,:duzina);');
        $izraz->execute($rijeke);
    }

    public static function promjena($rijeke){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update rijeka set 
        naziv=:naziv,
        duzina=:duzina
        where sifra=:sifra;');
        $izraz->execute($rijeke);
    }

    public static function brisanje($sifra){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('delete from rijeka where sifra=:sifra;');
        $izraz->execute(['sifra'=>$sifra]);
    }

} 