<!DOCTYPE html>
<html>
<head>
    <title>Opera Omnia - Subjects</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php include("header.php"); ?>
    
    <h1>Subjects</h1>
    <div id="menuSubject">
    	<div class = "subjectPhysics"><strong>Physics</strong></div>
    	<?php 
    	try {
    	 $bdd = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');
    	}
    	catch(Exception $e)
        {
           die('Erreur : '.$e->getMessage());
        }
        $reponse = 
        $reponse = $bdd->query('SELECT Title,ID FROM papers');
        while ($data = $reponse->fetch())
        {
    	echo ('<div class = "subjectsPapers"><ul> <li> <a href='.$data['ID'].'>'.$data['Title'].'</li> </ul></div>');
        }
        ?>

    </div>

<?php include("footer.php"); ?>
</body>
</html>