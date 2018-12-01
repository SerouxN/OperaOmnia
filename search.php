<!DOCTYPE html>
<html>
<head>
    <title>Opera Omnia</title>
    <link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8"/>
	<style>
      .topnav ul li [href='search'] {
		background-color: #d7d7d7; 
      }
    </style>
</head>
<header>
	<?php include("header.php"); ?>
</header>
<body>
	<section>
		<h1>Search</h1>
		<form method="post" action ="#">
		<fieldset>
			<legend> Are you searching a paper ? You are in the right place ! </legend>
			<label for='title'> Title : </label> <br />
            <input type='text' name='title' id ='title' <?php if(isset($_POST['title']) && !empty($_POST['title'])){echo "value=\"".$_POST['title']."\"";}?>/>
			<div id="selectField">
				<p>Only show:</p>
				<input type="radio" name="field" value="all" <?php if(!isset($_POST['field']) or $_POST['field']=='all') {echo 'checked';}?>>All <br>
				<input type="radio" name="field" value="Physics" <?php if(isset($_POST['field']) && $_POST['field']=='Physics') {echo 'checked';}?>>Physics<br>
				<input type="radio" name="field" value="Mathematics" <?php if(isset($_POST['field']) && $_POST['field']=='Mathematics'){echo 'checked';}?>>Mathematis<br>
				<input type="radio" name="field" value="Computer Science" <?php if(isset($_POST['field']) && $_POST['field'] == 'Computer Science'){echo 'checked';}?>>Computer Science<br>
            </div>
		</fieldset>
		<input id="submitButton" type="submit" value="Submit">
		</form>
		<?php 
		$query = 'SELECT * FROM papers ';
		if(!empty($_POST['title']))
		{
			$title = htmlspecialchars($_POST['title']);
			$query .=' WHERE Title LIKE \'%'.$title.'%\' ';
		}
		else if (isset($_POST['title']))
		{
			echo "<strong style= 'color: red;'> Title is empty .. like your head, it seems to be.</strong>";
		}
		if(isset($_POST['field']) && $_POST['field'] != 'all'&& !empty($_POST['field']) && !empty($_POST['title']))
		{
			$field = htmlspecialchars($_POST['field']);
			$query .= 'AND Field = \''.$field.'\'';
		}

		try
                {
                    $bdd = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
				}
		$reponse = $bdd->query($query);

		if (!(empty($_POST['title'])))
		{
		?>
		<table id="authList" width="100%" style ="margin= 6px;">
		<tr>
			<th> Title </th>
			<th> Author </th>
			<th> Date of publication </th>
			<th> Field </th>
			<th> Link </th>
		</tr>
		<?php 
			while ($data = $reponse->fetch())
			{

				echo ('<tr>');
				echo ('<td>'.$data['Title'].'</td>');
				$author = $bdd->query('SELECT LastName FROM authors WHERE ID =\''.$data['AuthorID'].'\'');
				$author = $author->fetch();
				echo ('<td>'.$author[0].'</td>');
				echo ('<td>'.$data['Year'].'</td>');
				echo ('<td>'.$data['Field'].'</td>');
				echo('<td><a id="goLink" href="paper?id='.$data['ID'].'"><p>Go</p></a></td>');
				echo ('</tr>');
			}
		}
		?>
		</table>
	</section>
	<?php include("footer.php"); ?>
</body>
</html>