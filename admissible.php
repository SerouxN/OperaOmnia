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

$r = $db->prepare('SELECT ID FROM submits WHERE title = ?');
$r->execute(array($_POST['title']));
$oldname = $r->fetch();
$oldname = 'submits/'.$oldname[0].'.pdf';

if ($_POST['decision'] == 'accept')
{
    // $req = $db->prepare('INSERT INTO papers(AuthorID, Title,  Year, Description, Language,Field, Major) 
    // VALUES(:AuthorID, :Title, :Year,    :Description, :Language, :Field, :Major)');
    // $req->execute(array(
    // 'AuthorID' => $_POST['authorID'],
    // 'Title' => $_POST['title'],
    // 'Year' => $_POST['year'],
    // 'Description' => $_POST['summary'],
    // 'Language' => $_POST['language'],
    // 'Field' => $_POST['field'],
    // 'Major' => 0));
    $newId = $db->query('SELECT max(ID) FROM papers');
    $newId = $newId->fetch();
    $newname = 'papers/'.strval($newId[0] + 1).'_'.strval($_POST['language']).'.pdf';
    rename($oldname, $newname);
    $r = $db->query("DELETE FROM submits WHERE Title = '".$_POST['title']."'");
}
else 
{
    $r = $db->query("DELETE FROM submits WHERE Title = '".$_POST['title']."'");
    unlink($oldname);
}
?>