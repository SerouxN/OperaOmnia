<!DOCTYPE html>
<html>
<head>
    <title>Opera Omnia</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width" />
	<meta charset="utf-8"/>
</head>
<header>
	<?php include("header.php"); ?>
</header>
<body class='home'>
	<img src='background2.jpg' style='width: 100%;'/>
	<div class='titleHome'>
		Opera Omnia
	</div>
	<p style ="margin-left: 5px; margin-right:5px;"> A very small index for very great scientific papers. </p>
	<section>
	<div class="menuSubject" style="margin: auto;">
        <div class = "lastPapers"><strong>Last Paper added</strong></div>
		<?php
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');	
		}
		catch(Exception $e)
		{
				die('Erreur : '.$e->getMessage());
		}        
		$reponse = $bdd->query('SELECT Title,ID FROM papers ORDER BY ID DESC');
		echo ('<div class=\'lastPaper\'/>');
        while ($data = $reponse->fetch())
        {
            echo ('<ul> <li> <a href=paper.php?id='.$data['ID'].'>'.$data['Title'].'</a></li> </ul>');
        }
        echo '</div>'
		?>
	</div>
	</section>
<?php include("footer.php"); ?>
</body>
</html>