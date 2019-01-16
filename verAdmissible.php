<?php
try
{
    $db = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(Exception $e)
{
        die('Error : '.$e->getMessage());
}

$oldname = 'submits/'.basename($_POST['id']).'.pdf';

if ($_POST['decision'] == 'Accept')
{
    $r1=$db->query('SELECT * FROM papers WHERE ID='. $_POST['paperID']);
    $newname = 'papers/'.$_POST['paperID'].'_'.strval($_POST['language']).'.pdf';
    rename($oldname, $newname);
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