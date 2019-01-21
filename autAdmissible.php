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

// peut etre une faille 

$req = $db->prepare('INSERT INTO authors(FirstName, LastName, Birthday, DateOfDeath, Bio, Field) 
        VALUES(:FirstName, :LastName, :Birthday, :DateOfDeath, :Bio, :Field)');
$req->execute(array(
   //'ID' => $numSubmitted,
   'FirstName' => $_POST['fname'],
   'LastName' => $_POST['lname'],
   'Birthday' => $_POST['birth'],
   'DateOfDeath' => $_POST['death'],
   'Bio' => $_POST['bio'],
   'Field' => $_POST['field']
));

header('Location: submit.php?error='.$error);
exit();	
?>