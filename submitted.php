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
if (isset($_POST['submit']))

{
	if ($_FILES['paperSubmitted']['size'] <= 1000000)
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
			
			$last_id = $db->query('SELECT max(ID) FROM submits');
			$last_id = $last_id -> fetch();
			echo $last_id[0] ;
			move_uploaded_file($_FILES['paperSubmitted']['tmp_name'], 'submits/' . basename($last_id[0] + 1));
			 $req = $db->prepare('INSERT INTO submits( AuthorID, Title, Summary, Year, Field) 
			 		VALUES(:AuthorID, :Title, :Summary, :Year, :Field)');
			$req->execute(array(
				'AuthorID' => $_POST['authorID'],
				'Title' => $_POST['title'],
				'Summary' => $_POST['summary'],
				'Year' => $_POST['year'],
				'Field' => $_POST['field']
			));

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
	echo 'test2';
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