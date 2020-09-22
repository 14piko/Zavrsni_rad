<?php

$dev=$_SERVER['REMOTE_ADDR'] === '127.0.0.1' ? true : false;

if($dev){
    $baza=[
        'server' => 'localhost',
        'baza' => 'ribickaudruga',
        'korisnik' => 'edunova',
        'lozinka' => 'edunova'
    ];
}else{
    $baza=[
        'server' => 'localhost',
        'baza' => 'polaznik_zadatak',
        'korisnik' => 'polaznik_edunova',
        'lozinka' => 'edunova'
    ];  
}
    
return [
    'dev' => $dev,
    'nazivAPP' => 'Ribička udruga',
    'url' => 'http://polaznik01.edunova.hr/',
    'baza' => $baza
];