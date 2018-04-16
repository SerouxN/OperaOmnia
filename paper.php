<!DOCTYPE html>
<html>
<head> 
    <?php
        try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(Exception $e)
        {
                die('Erreur : '.$e->getMessage());
        }
        $reponse = $bdd->query('SELECT * FROM papers WHERE ID='. $_GET['id']);
        while ($data = $reponse->fetch())
        {
            $title=$data['Title'];
        }
        $reponse->closeCursor();
    ?>
    <title>Opera Omnia - <?php echo $data['Title']?></title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    
    <?php include("header.php"); ?>
    <section>
    <h1><?php echo $title?></h1>
    <a href="papers/<?php echo $_GET['id']?>.pdf"><?php echo $title?></a>
    </section>
<?php include("footer.php"); ?>
</body>
</html>