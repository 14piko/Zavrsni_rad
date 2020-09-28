<?php

class Clanudruge
{

    public static function ucitajSve($stranica,$uvjet)
    {
        $rps=APP::config('rezultataPoStranici');
        $od = $stranica * $rps - $rps;

        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
                select a.sifra, a.ime, a.prezime, a.oib, 
                a.brojdozvole, count(b.sifra) as pecanje
                from clanudruge a left join pecanje b on
                a.sifra=b.clanudruge
                where concat(a.ime, \' \', a.prezime, \' \',
                ifnull(a.oib,\'\')) like :uvjet
                group by a.sifra, a.ime, 
                a.prezime, a.oib, a.brojdozvole limit :od,:rps;
                
        ');
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->bindValue('od',$od,PDO::PARAM_INT);
        $izraz->bindValue('rps',$rps,PDO::PARAM_INT);
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

    public static function ukupnoStranica($uvjet){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select count(a.sifra) from clanudruge a left join pecanje b on a.sifra=b.clanudruge 
        where concat(a.ime, \' \', a.prezime, \' \',
        ifnull(a.oib,\'\')) like :uvjet;');
        $izraz->execute(['uvjet'=>$uvjet]);
        return $izraz->fetchColumn();

    }

    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
                select * from clanudruge where sifra=:sifra;
                
        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();

    }

    public static function promjena($clan){
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update clanudruge set
       ime=:ime,
       prezime=:prezime,
       oib=:oib,
       brojdozvole=:brojdozvole
       where sifra=:sifra;');
        $izraz->execute($clan);
    }
}