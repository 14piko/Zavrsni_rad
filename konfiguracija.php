<?php

$dev=$_SERVER['REMOTE_ADDR'] === '127.0.0.1' ? true : false

if($dev){
    $baza=[
        'server' => 'localhost',
        'baza' => 'edunovapp21',
        'korisnik' => 'edunova',
        'lozinka' => 'edunova'
    ];
}else{
    $baza=[
        'server' => 'localhost',
        'baza' => 'polaznik_pp21',
        'korisnik' => 'polaznik_edunova',
        'lozinka' => 'edunova'
    ];  
}
    
return [
    'dev' => $dev,
    'nazivAPP' => 'Edunova APP',
    'url' => 'http://polaznik01.edunova.hr/'
    'baza' => $baza
];