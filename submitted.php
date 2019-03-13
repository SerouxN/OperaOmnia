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
				$db = new PDO('mysql:host=localhost;dbname=operaomnia v2;charset=utf8', 'root', '');
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}

			catch(Exception $e)
			{
					die('Error : '.$e->getMessage());
			}
			
			if ($_POST['authorID'] == 'unspecified')
			{
				$usedIDs = $db->query('SELECT ID FROM authors');
  				$definitiveID=sprintf('%010d', rand(0,9999999999));
    			while ($usedID = $usedIDs->fetch())
    			{
        			if ($usedID==$definitiveID)
       		 		{
                		$usedID = $db->query('SELECT * FROM papers');
                		$definitiveID=rand(0,9999999999);
           		 		$definitiveID=sprintf('%10d', $ID);
        			}
				}
				$fields="";
				foreach ($_POST['authorField'] as $field)
				{
					$fields.=(string)$field;
					$fields.="_";
				}
				$fields=substr($fields, 0, -1);
				var_dump($fields);
				$req = $db->prepare('INSERT INTO autsubmits(FirstName, LastName, DateBirth, DateDeath, Bio, Fields, definitiveID) 
				VALUES(:FirstName, :LastName, :DateBirth, :DateDeath, :Bio, :Fields, :definitiveID)');
	   			$req->execute(array(
				'FirstName' => $_POST['authorFname'],
				'LastName' => $_POST['authorLname'],
				'DateBirth' => $_POST['authorBirth'],
				'DateDeath' => $_POST['authorDeath'],
				'Bio' => $_POST['authorBio'],
				'Fields' => $fields,
				'definitiveID' => $definitiveID));

				$numSubmitted=0;
				$reponse=$db->query('SELECT * FROM submits');
				
				while ($data = $reponse->fetch())
				{
					if($data['ID']>$numSubmitted)
					{
						$numSubmitted=$data['ID'];
					}
				}
				$numSubmitted=$numSubmitted+1;
			 	$req = $db->prepare('INSERT INTO submits(ID,AuthorID, Title, Summary, Language, Year, Field) VALUES(:ID,:AuthorID, :Title, :Summary, :Language, :Year, :Field)');
				$req->execute(array(
				'ID' => $numSubmitted,
				'AuthorID' => $definitiveID,
				'Title' => $_POST['title'],
				'Summary' => $_POST['summary'],
				'Language' => $_POST['language'],
				'Year' => $_POST['year'],
				'Field' => $_POST['field']));
			}
			else
			{
				$numSubmitted=0;
				$reponse=$db->query('SELECT * FROM submits');
				while ($data = $reponse->fetch())
				{
					if($data['ID']>$numSubmitted)
					{
						$numSubmitted=$data['ID'];
					}
				}
				$numSubmitted=$numSubmitted+1;
			 	$req = $db->prepare('INSERT INTO submits(ID,AuthorID, Title, Summary, Language, Year, Field) VALUES(:ID,:AuthorID, :Title, :Summary, :Language, :Year, :Field)');
				$req->execute(array(
				'ID' => $numSubmitted,
				'AuthorID' => $_POST['authorID'],
				'Title' => $_POST['title'],
				'Summary' => $_POST['summary'],
				'Language' => $_POST['language'],
				'Year' => $_POST['year'],
				'Field' => $_POST['field']));
			}
			move_uploaded_file($_FILES['paperSubmitted']['tmp_name'], 'submits/paper' .basename($numSubmitted) .'.pdf');

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