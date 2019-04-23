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


$r = $db->prepare('SELECT * FROM submits WHERE ID = "'.$_POST['id'].'"');
$r->execute(array($_POST['originalTitle']));
$oldname = $r->fetch();
$data=$r->fetch();
var_dump($data);
$oldname = '../submits/paper'.$oldname[0].'.pdf';

if ($_POST['decision'] == 'Accept')
{
    $usedIDs = $db->query('SELECT ID FROM papers');
    $ID=sprintf('%010d', rand(0,(int)9999999999));
    while ($usedID = $usedIDs->fetch())
    {
        if ($usedID==$ID)
       	{
            $usedID = $db->query('SELECT * FROM papers');
            $ID=rand(0,9999999999);
       		$ID=sprintf('%10d', $ID);
        }
    }
    $req = $db->prepare('INSERT INTO papers(ID,AuthorID, Title,  Date, Description,Fields, Format) 
    VALUES(:ID, :AuthorID, :Title, :Date,    :Description, :Fields, :Format)');
    $req->execute(array(
        'ID'=>$ID,
        'AuthorID' => $_POST['authorID'],
        'Title' => $_POST['originalTitle'],
        'Date' => $_POST['date'],
        'Description' => $_POST['Summary'],
        'Fields' => $_POST['Fields'],
        'Format'=>0));
    $char=['b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    $newname = '../papers/'.$ID.'_'.strval($_POST['Language']).'_'.strval($_POST['Type']).'a.pdf';
    $i=0;
    while(file_exists($newname))
    {
        $newname = '../papers/'.$ID.'_'.strval($_POST['Language']).'_'.strval($_POST['Type']).'.pdf';
        $i++;
    }
    var_dump($oldname);
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
     
    $authors=array();
    $authExists="False";
                    $currentID="";
                    for($i=0;$i<=strlen($_POST['authorID']);$i++)
                    {
                        if(isset($_POST['authorID'][$i]) && $_POST['authorID'][$i]!="_")
                        {
                            $currentID.=$_POST['authorID'][$i];
                        }
                        else
                        {
                            array_push($authors,$currentID);
                            $currentID="";
                        }
                    }
                    foreach ($authors as $auth1)
                    {
                        $rauth=$db->query('SELECT * FROM authors WHERE ID='. $auth1);
                        $data=$rauth->fetch();
                        if($data)
                        {
                            $authExists="True";
                        }
                    }
    if($authExists=="False")
    {
        var_dump($data);
        $rauth=$db->query('SELECT * FROM autsubmits WHERE definitiveID='. $_POST['authorID']);
        $data=$rauth->fetch();  
        var_dump($data);
        $req = $db->prepare('INSERT INTO authors(ID, FirstName, LastName, Birthday, DateOfDeath, Bio, Fields) VALUES(:ID, :FirstName, :LastName, :Birthday, :DateOfDeath, :Bio, :Fields)');
        $req->execute(array(
            'ID' => $data['definitiveID'],
            'FirstName' => $data['FirstName'],
            'LastName' => $data['LastName'],
            'DateBirth' => $data['DateBirth'],
            'DateOfDeath' => $data['DateDeath'],
            'Bio' => $data['Bio'],
            'Fields' => $data['Fields']));
            $r = $db->query("DELETE FROM autsubmits WHERE definitiveID='".$data['definitiveID']."'");
    }
    var_dump($data);
 
   $r = $db->query("DELETE FROM submits WHERE Title = '".$_POST['originalTitle']."'");
}
else 
{
    var_dump($_POST['id']);
    $r = $db->query("DELETE FROM submits WHERE ID = '".$_POST['id']."'");    
    unlink($oldname);
}
function Redirect($url, $permanent = false)
{
   header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}

Redirect('admission.php', false);
?>