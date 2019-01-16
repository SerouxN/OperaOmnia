<!DOCTYPE html>
<html>
<head>
    <title>Opera Omnia</title>
    <link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8"/>
</head>
<header>
	<?php include("header.php"); ?>
</header>
<body>
<?php
//Verification du fichier 
if ($_FILES['paperSubmitted']['error'] == 0)

{
	if ($_FILES['paperSubmitted']['size'] <= 10000000)
	{
		if (pathinfo($_FILES['paperSubmitted']['name'])['extension'] == 'pdf')
		{			
			try
			{
				$db = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}

			catch(Exception $e)
			{
					die('Error : '.$e->getMessage());
			}
			$numSubmitted=0;
			$reponse=$db->query('SELECT * FROM submits');
			while ($data = $reponse->fetch())
			{
				$numSubmitted=$numSubmitted+1;
			}
			$numSubmitted=$numSubmitted+1;
			 $req = $db->prepare('INSERT INTO submits(ID,AuthorID, Title, Summary, language, Year, Field) 
			 		VALUES(:ID,:AuthorID, :Title, :Summary, :Language, :Year, :Field)');
			$req->execute(array(
				'ID' => $numSubmitted,
				'AuthorID' => $_POST['authorID'],
				'Title' => $_POST['title'],
				'Summary' => $_POST['summary'],
				'Language' => $_POST['language'],
				'Year' => $_POST['year'],
				'Field' => $_POST['field']
			));

			//$last_id = $db->prepare('SELECT ID FROM submits WHERE title = ?' );
			//$last_id->execute(array($_POST['title']));
			//$last_id = $last_id -> fetch();
			
			
			move_uploaded_file($_FILES['paperSubmitted']['tmp_name'], 'submits/' .basename($numSubmitted) .'.pdf');

			echo "<section> 
					<h1>Thank you for submitting a paper</h1>
						<p>You can now go back <a href='operaomnia.php'>home</a>. Or whatever, you do you...</p>
					</section>
				<div id='space'></div>";

		}
		else
		{
			$error =  1;
		} 

	}
	else {
		$error =  2;
	}	

}
else
{
	$error =  3;
}

if (isset($error))
	{
		header('Location: submit.php?error='.$error);
		exit();	
	}
?>
	<?php include("footer.php"); ?> 
</body>
</html>