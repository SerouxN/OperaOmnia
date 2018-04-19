<!DOCTYPE html>
<html>
<head>
    <title>Opera Omnia - Authors</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8"/>
</head>
<body> 
    <?php include("header.php"); 
    $nResults=0;
    $selected =""?>
    <section>
    <h1>Authors</h1>
    <form method="post" action="#">
    <div id="formAuthors">
    <fieldset>
        <legend>Research Parameters:</legend>
        <label for="name">Name of the author:</label>
        <input type="text" name="name" id="name"/>
        <div id="selectField">
            <p>Only show:</p>
            <input type="checkbox" name="Physics" value="Physics" <?php if(isset($_POST['order']) && $_POST['order'] == "Physics"){echo 'checked';}?>>Physicists<br>
            <input type="checkbox" name="Mathematics" value="Mathematics" <?php if(isset($_POST['order']) && $_POST['order'] == "Mathematics"){echo 'checked';}?>>Mathematicians<br>
            <input type="checkbox" name="Computer Science" value="Computer Science" <?php if(isset($_POST['order']) && $_POST['order'] == "Computer Science"){echo 'checked';}?>>Computer Scientists<br>
        </div>
        </fieldset>
        <fieldset>
        <legend>Sort by:</legend>
        <select name="sorting" size="1">
            <option value="LastName" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'LastName') {echo 'selected';} ?>>Last Name
            <option value="FirstName" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'FirstName') {echo 'selected';} ?>>First Name 
            <option value="Birthday" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'Birthday') {echo 'selected';} ?>>Birth Date
            <option value="DateOfDeath" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'DateOfDeath') {echo 'selected';} ?>>Death Date
        </select>
        <div id="order">
            <input type="radio" name="order" value=" " <?php if(isset($_POST['order']) && $_POST['order'] == " "){echo 'checked';}?> checked>Ascending<br>
            <input type="radio" name="order" value="DESC" <?php if(isset($_POST['order']) && $_POST['order'] == "DESC"){echo 'checked';}?>>Descending<br>
        </div>
        </fieldset>
        </div>
        <input id="submitButton" type="submit" value="Submit">
    </form>
    <div style="overflow-x:auto;">
        <table id="authList" width="90%">
        <tr>
            <th>Name</th>
            <th>Years</th>
            <th>Bio</th>
            <th>Field</th>
            <th>Link</th>
            </tr>
        <?php
            $chosenMethod='LastName';
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
            $query="SELECT * FROM authors";
            if(isset($_POST['Physics']) or isset($_POST['Mathematics']) or isset($_POST['Computer Science']) or isset($_POST['name']))
            {
                $query.=" WHERE ";
                if (isset($_POST['name']))
                {
                    $query.="LastName LIKE '%".strtoupper($_POST['name'])."%'";
                }
                else if(isset($_POST['Physics']) or isset($_POST['Mathematics']) or isset($_POST['Computer Science']))
                {
                    $query.="";
                }
                if(isset($_POST['Physics']) or isset($_POST['Mathematics']) or isset($_POST['Computer Science']) and isset($_POST['name']))
                {
                    echo "Hello";
                    $query.="LastName LIKE '%".strtoupper($_POST['name'])."%'";
                }
            }
            echo $query;
            if (isset($_POST['order']))
            {
                $order = $_POST['order'];
            }
            if (isset($_POST['name']))
            {
                $authorName=strtoupper($_POST['name']);
                $reponse = $bdd->query("SELECT * FROM authors WHERE LastName LIKE '%".strtoupper($_POST['name'])."%' ORDER BY ". $chosenMethod ." ". $order);
            }
            else
            {
                $reponse = $bdd->query("SELECT * FROM authors ORDER BY " . $chosenMethod ." ". $order);
            }
            $reponse = $bdd->query("SELECT * FROM authors ORDER BY " . $chosenMethod ." ". $order);
            $nResults=0;
            while ($data = $reponse->fetch())
            {
                $nResults=$nResults+1;
        ?>
            <tr>
            <td id="authName"><?php echo $data['FirstName']?> <strong><?php echo $data['LastName']; ?></strong></td>
            <td>(<?php echo date_format(date_create($data['Birthday']),"Y");?>-<?php if($data['DateOfDeath'] != NULL){echo date_format(date_create($data['DateOfDeath']),"Y");}else{echo "  ";} ?>)</td>
            <td id="bio"><?php echo substr($data['Bio'], 0, 100)?>...</td>
            <td><?php echo $data['Field']?></td>
            <td><a id="goLink" href="author.php?authid=<?php echo $data['ID']?>"><p>Go</p></a></td>
            </tr>
        <?php  
            }
            if ($nResults==0)
            {
                ?>
                    <tr>
            <td id="noResult" colspan="5">There were no results for the name "<?php echo $_POST['name']?>".</td>
            </tr>
                <?php
            }
            $reponse->closeCursor();
        ?>
        </table>
    </div>
    </section>
    <?php include("footer.php"); ?>
</body>
</html>