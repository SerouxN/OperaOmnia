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

$r = $db->prepare('SELECT * FROM submits WHERE title = ?');
$r->execute(array($_POST['title']));
$oldname = $r->fetch();
$oldname = 'submits/paper'.$oldname[0].'.pdf';

if ($_POST['decision'] == 'Accept')
{
    $usedIDs = $db->query('SELECT ID FROM papers');
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
    $req = $db->prepare('INSERT INTO papers(ID,AuthorID, Title,  Year, Description,Field, Major, Format) 
     VALUES(:ID, :AuthorID, :Title, :Year,    :Description, :Field, :Major, :Format)');
     $req->execute(array(
         'ID'=>$ID,
     'AuthorID' => $_POST['authorID'],
     'Title' => $_POST['title'],
     'Year' => $_POST['year'],
     'Description' => $_POST['summary'],
     'Field' => $_POST['field'],
     'Major' => 0,
    'Format'=>0));
    $char=['b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    $newname = 'papers/'.$ID.'_'.strval($_POST['language']).'a.pdf';
    $i=0;
    while(file_exists($newname))
    {
        $newname = 'papers/'.$ID.'_'.strval($_POST['language']).(string)$char[$i].'.pdf';
        $i++;
    }
    var_dump($newname);
    rename($oldname, $newname);
    $r = $db->query("DELETE FROM submits WHERE Title = '".$_POST['title']."'");
}
else 
{
    $r = $db->query("DELETE FROM submits WHERE Title = '".$_POST['title']."'");
    unlink($oldname);
}
function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}

Redirect('admission.php', false);
?>