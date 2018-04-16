<!DOCTYPE html>
<html>
<head>
    <title>Opera Omnia - Authors</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body> 
    <?php include("header.php"); 
    $selected =""?>
    <section>
    <h1>Authors</h1>
    <form method="post" action="#">
        <fieldset>
        <legend>Sort by:</legend>
        <select name="sorting" size="1">
            <option value="Name" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'Name') {echo 'selected';} ?>>Name
            <option value="FirstName" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'FirstName') {echo 'selected';} ?>>First Name 
            <option value="Birthday" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'Birthday') {echo 'selected';} ?>>Birth Date
            <option value="DateOfDeath" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'DateOfDeath') {echo 'selected';} ?>>Death Date
        </select>
        <div id="order">
            <input type="radio" name="order" value=" " <?php if(isset($_POST['order']) && $_POST['order'] == " "){echo 'checked';}?> checked>Ascending<br>
            <input type="radio" name="order" value="DESC" <?php if(isset($_POST['order']) && $_POST['order'] == "DESC"){echo 'checked';}?>>Descending<br>
        </div>
            <input id="submitButton" type="submit" value="Submit">
        </fieldset>
    </form>
    <table id="authList">
    <tr>
        <th>Name</th>
        <th>Years</th>
        <th>Bio</th>
        <th>Field</th>
        <th>Link</th>
        </tr>
    <?php
        $chosenMethod='Name';
        $order = " ";
        if (isset($_POST['sorting']))
        {
            $chosenMethod = $_POST['sorting'];
            $selected = $_POST['sorting'];
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
        if (isset($_POST['order']))
        {
            $order = $_POST['order'];
        }
        $reponse = $bdd->query('SELECT * FROM authors ORDER BY ' . $chosenMethod ." ". $order);
        while ($data = $reponse->fetch())
        {
    ?>
        <tr>
        <td id="authName"><?php echo $data['FirstName']?> <strong><?php echo $data['Name']; ?></strong></td>
        <td>(<?php echo date_format(date_create($data['Birthday']),"Y");?>-<?php echo date_format(date_create($data['DateOfDeath']),"Y"); ?>)</td>
        <td id="bio"><?php echo substr($data['Bio'], 0, 100)?>...</td>
        <td><?php echo $data['Field']?></td>
        <td><a id="goLink" href="author.php?authid=<?php echo $data['ID']?>"><p>Go</p></a></td>
        </tr>
    <?php

        }
        $reponse->closeCursor();
    ?>
    </table>
    </section>
<?php include("footer.php"); ?>
</body>
</html>