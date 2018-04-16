<html>
<head>
    <title>Opera Omnia - Authors</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body> 
    <?php include("header.php"); ?>
    <section>
    <h1>Authors</h1>
    <form method="get" action="#">
        <fieldset>
        <legend>Sort by:</legend>
        <select name="sorting" size="1">
            <option value="Name">Name
            <option value="FirstName">First Name 
            <option value="Birthday">Birth Date
            <option value="DateOfDeath">Death Date
        </select>
        <div id="order">
            <input type="radio" name="order" value=" " checked>Ascending<br>
            <input type="radio" name="order" value="DESC">Descending<br>
        </div>
            <input id="submitButton" type="submit" value="Submit">
        </fieldset>
    </form>
    <ul>
    <?php
        $chosenMethod='Name';
        if ($_GET['sorting'])
        {
            $chosenMethod=$_GET['sorting'];
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
        $reponse = $bdd->query('SELECT * FROM authors ORDER BY ' . $chosenMethod ." ". $_GET['order']);

        while ($data = $reponse->fetch())
        {
    ?>
        <li><a href="author.php?authid=<?php echo $data['ID']?>"><p><?php echo $data['FirstName'] ." ". $data['Name']; ?></p></a></li>
    <?php
        }
        $reponse->closeCursor();
    ?>
    </ul>
    </section>
<?php include("footer.php"); ?>
</body>
</html>