<?php 
session_start();
try
{
    $db = new PDO('mysql:host=localhost;dbname=operaomnia v2;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(Exception $e)
{
        die('Error : '.$e->getMessage());
}

// peut etre une faille 
if ($_POST['decision'] == 'Accept')
{
    $usedIDs = $db->query('SELECT ID FROM authors');
    $ID=sprintf('%010d', rand(0,9999999999));
    while ($usedID = $usedIDs->fetch())
    {
        if ($usedID==$ID)
       	{
            $usedID = $db->query('SELECT * FROM papers');
            $ID=rand(0,9999999999);
      		$ID=sprintf('%10d', $ID);
        }
    }
    $req = $db->prepare('INSERT INTO authors(ID, FirstName, LastName, DateBirth, DateDeath, Bio, Fields) VALUES(:ID, :FirstName, :LastName, :DateBirth, :DateDeath, :Bio, :Fields)');
    $req->execute(array(
        'ID' => $ID,
        'FirstName' => $_POST['fname'],
        'LastName' => $_POST['lname'],
        'DateBirth' => $_POST['birth'],
        'DateDeath' => $_POST['death'],
        'Bio' => $_POST['bio'],
        'Fields' => $_POST['field']));
        $r = $db->query("DELETE FROM autsubmits WHERE definitiveID='".$_POST['id']."'");
}
else 
{
    var_dump($_SESSION);
    var_dump($_POST['id']);
    $r = $db->query("DELETE FROM submits WHERE ID = '".$_POST['id']."'");    
    $r = $db->query("DELETE FROM autsubmits WHERE definitiveID='".$_POST['id']."'");
    var_dump($r);
}
function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}

Redirect('admission.php', false);
exit();	
?>