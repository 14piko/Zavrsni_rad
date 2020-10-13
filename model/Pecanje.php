<?php

class Pecanje
{

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.sifra,c.naziv as riba ,d.naziv as rijeka,
        concat(b.ime,\' \',b.prezime) as clanudruge,
        a.datum,a.kolicina,a.tezina,count(b.sifra) as clanovi from pecanje a
        inner join clanudruge b on a.clanudruge=b.sifra
        inner join riba c on a.riba=c.sifra 
        inner join rijeka d on a.rijeka=d.sifra
        group by a.sifra,c.naziv ,d.naziv,
        concat(b.ime,\' \',b.prezime),
        a.datum,a.kolicina,a.tezina;');
        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function ucitaj($sifra)
    {
        {
            $veza = DB::getInstanca();
            $izraz = $veza->prepare('select * from pecanje
            where sifra=:sifra;');
            $izraz->execute(['sifra'=>$sifra]);
            return $izraz->fetch();
        }
    }


    public static function dodajNovi($entitet)
    {   
        
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into pecanje
        (datum,
        clanudruge,
        riba,
        kolicina,
        tezina,
        rijeka)
        values 
        (:datum,
        :clanudruge,
        :riba,
        :kolicina,
        :tezina,
        :rijeka);');
        $izraz->execute($entitet);
    }

     public static function promjena($entitet)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update pecanje set 
        datum =:datum,
        clanudruge =:clanudruge,
        riba =:riba,
        kolicina =:kolicina,
        tezina =:tezina,
        rijeka =:rijeka
        where sifra =:sifra;');
        
        $izraz->execute($entitet);
        
    }


    public static function brisanje($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('delete from pecanje where sifra=:sifra;');
        $izraz->execute(['sifra'=>$sifra]);
    }

    public static function vrstaRibeUPecanjuJSON()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select b.sifra,
        b.naziv as name,count(a.riba) as y from pecanje a
        left join riba b on a.riba=b.sifra
        group by b.sifra,b.naziv order by 2 desc;');
        $izraz->execute();
        return json_encode($izraz->fetchAll(),JSON_NUMERIC_CHECK );
    }


}