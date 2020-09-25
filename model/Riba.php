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

    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
                
        select a.sifra, a.naziv, a.pocetaklovostaja, a.krajlovostaja, 
        a.opis, count(b.sifra) as pecanje
        from riba a left join pecanje b on
        a.sifra=b.riba  where a.sifra=:sifra
        group by a.sifra, a.naziv, 
        a.pocetaklovostaja, a.krajlovostaja, a.opis;
                
        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();

    }


    public static function dodajNovi($riba){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into riba (naziv,pocetaklovostaja,krajlovostaja,opis) values (:naziv,:pocetaklovostaja,:krajlovostaja,:opis);');
        $izraz->execute($riba);

    }

    public static function promjena($riba){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update riba set 
        naziv=:naziv,
        pocetaklovostaja=:pocetaklovostaja,
        krajlovostaja=:krajlovostaja,
        opis=:opis
        where sifra=:sifra;');
        $izraz->execute($riba);

    }

    public static function brisanje($sifra){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('delete from riba where sifra=:sifra;');
        $izraz->execute(['sifra'=>$sifra]);

    }

}


