<?php

require_once('../FPDF/fpdf.php');
require_once('../FPDF/src/autoload.php');

use \setasign\Fpdi\Fpdi;

try
{
    $db = new PDO('mysql:host=localhost;dbname=operaomnia v2;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(Exception $e)
{
        die('Error : '.$e->getMessage());
}

$oldname = '../submits/ver'.basename($_POST['id']).'.pdf';

if ($_POST['decision'] == 'Accept')
{
    $r1=$db->query('SELECT * FROM papers WHERE ID='. $_POST['paperID']);
    $char=['b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    $newname = '../papers/'.$_POST['paperID'].'_'.strval($_POST['language']).'a.pdf';
    $i=0;
    while(file_exists($newname))
    {
        $newname = '../papers/'.$_POST['paperID'].'_'.strval($_POST['language']).(string)$char[$i].'.pdf';
        $i++;
    }
    $finalFile = new FPDI();

        $pageCount = $finalFile->setSourceFile($oldname);
        for ($i = 1; $i <= $pageCount; $i++) {
            $tplIdx = $finalFile->importPage($i, '/MediaBox');
            $finalFile->AddPage();
            $finalFile->useTemplate($tplIdx);
        }
        $finalFile->SetTitle($_POST['fileTitle']);
        $finalFile->Output($newname, "F");
    //rename($oldname, $newname);
    $r = $db->query("DELETE FROM submitversion WHERE ID = '".$_POST['id']."'");
}
else 
{
    $r = $db->query("DELETE FROM submitversion WHERE ID = '".$_POST['id']."'");
    
    unlink($oldname);
}
function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}

Redirect('admission.php', false);
?>