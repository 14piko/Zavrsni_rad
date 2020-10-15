<?php
class IndexController extends Controller
{
    public function index()
    {
        $this->view->render('pocetna',[
            'kljuc1' => 'Vrijednost1',
            'kljuc2' => [1,2,7,9]
        ]);
    }
    public function oribolovu()
    {
        $this->view->render('oribolovu');
    }

    public function era()
    {
        $this->view->render('era');
    }


    public function notfound($poruka)
    {
        $this->view->render('notfound',['poruka'=>$poruka]);
    }

    public function login()
    {


        if($this->kontrolaLogiran()){
            return;
        }
        


        $this->loginView('', 'Popunite tražene podatke!');
        }

    public function logout(){
        unset($_SESSION['autoriziran']);
        session_destroy();
        $this->index();
    }        

    public function autorizacija()
    {
        if($this->kontrolaLogiran()){
            return;
        }
        
        
        if(!isset($_POST['email']) || !isset($_POST['lozinka'])){
            $this->login();
            return; // short curcuiting
            }

        if(strlen(trim($_POST['email']))===0){       
            $this->loginView(
                trim($_POST['email']),
                'Obavezan unos email-a!'
            );
            return;
            }


        if(strlen(trim($_POST['lozinka']))===0){
            $this->loginView(
                trim($_POST['email']),
                'Obavezan unos lozinke!'
            );
            return;
            }

            //100% siguran da imaš email i lozinku
            $veza = DB::getInstanca();

            $izraz = $veza->prepare('select * from operater where email=:email');
            $izraz->execute(['email'=>$_POST['email']]);
            $rezultat=$izraz->fetch();

            if($rezultat==null){
                $this->loginView(
                    trim($_POST['email']),
                    'Unesena email adresa ne postoji u sustavu!'
                );
                return;
            }


            if(!password_verify($_POST['lozinka'],$rezultat->lozinka)){
                $this->loginView(
                    trim($_POST['email']),
                    'Za uneseni email nije ispravna lozinka!'
                );
                return;
            }


            // ovdje sam autoriziran
            unset($rezultat->lozinka);
            $_SESSION['autoriziran']=$rezultat;
            $np = new NadzornaplocaController();
            $np->index();

        }  
     
    private function loginView($email, $poruka){
        $this->view->render('login',[
            'email' => $email,
            'poruka' => $poruka
        ]);   
        }    
        
        private function kontrolaLogiran()
        {
            if(isset($_SESSION['autoriziran'])){
                $np = new NadzornaplocaController();
                $np->index();
                return true;
            }

            return false;
        }

        
     public function test(){
         echo password_hash("o", PASSWORD_BCRYPT);

      /*   $veza = DB::getInstanca();
         for($i=0;$i<500;$i++){
             $izraz = $veza->prepare('insert into clanudruge (ime,prezime,oib,brojdozvole) values (:ime,:prezime,:oib,:brojdozvole);');
             $izraz->execute([
                 'ime'=>'Generirani',
                 'prezime'=>'Polaznik' . $i,
                 'oib'=>'',
                 'brojdozvole'=>''
             ]);
             echo 'Gotov' . $i . '<br/>';
            }  
*/
     }

     public function pdf()
     {
        //============================================================+
// File name   : example_009.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 009 for TCPDF class
//               Test Image
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Test Image
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 009');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// -------------------------------------------------------------------

// add a page
$pdf->AddPage();

// set JPEG quality
$pdf->setJPEGQuality(75);

// Image method signature:
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Example of Image from data stream ('PHP rules')
$imgdata = base64_decode('iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABlBMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDrEX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==');

// The '@' character is used to indicate that follows an image data stream and not an image file name
$pdf->Image('@'.$imgdata);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Image example with resizing
$pdf->Image('public/img/riba/1.png', 15, 140, 75, 113, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// test fitbox with all alignment combinations

$horizontal_alignments = array('L', 'C', 'R');
$vertical_alignments = array('T', 'M', 'B');

$x = 15;
$y = 35;
$w = 30;
$h = 30;
// test all combinations of alignments
for ($i = 0; $i < 3; ++$i) {
    $fitbox = $horizontal_alignments[$i].' ';
    $x = 15;
    for ($j = 0; $j < 3; ++$j) {
        $fitbox[1] = $vertical_alignments[$j];
        $pdf->Rect($x, $y, $w, $h, 'F', array(), array(128,255,128));
        $pdf->Image('public/img/riba/1.png', $x, $y, $w, $h, 'PNG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);
        $x += 32; // new column
    }
    $y += 32; // new row
}

$x = 115;
$y = 35;
$w = 25;
$h = 50;
for ($i = 0; $i < 3; ++$i) {
    $fitbox = $horizontal_alignments[$i].' ';
    $x = 115;
    for ($j = 0; $j < 3; ++$j) {
        $fitbox[1] = $vertical_alignments[$j];
        $pdf->Rect($x, $y, $w, $h, 'F', array(), array(128,255,255));
        $pdf->Image('public/img/riba/1.png', $x, $y, $w, $h, 'PNG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);
        $x += 27; // new column
    }
    $y += 52; // new row
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Stretching, position and alignment example

$pdf->SetXY(110, 200);
$pdf->Image('public/img/riba/1.png', '', '', 40, 40, '', '', 'T', false, 300, '', false, false, 1, false, false, false);
$pdf->Image('public/img/riba/1.png', '', '', 40, 40, '', '', '', false, 300, '', false, false, 1, false, false, false);

// -------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_009.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+


     }
}


