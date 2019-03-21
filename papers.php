<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <title>Opera Omnia - Papers</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width" />
    <style>
      .topnav ul li [href='papers'] {
        background-color: #d7d7d7; 
      }
    </style>
    <script>
        jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
    </script>
</head>
<body>
    <?php include("header.php"); ?>
    <section>
    <h1>Papers : </h1>
        <form method="post" action="#">
            <div id="formAuthors">
            <fieldset>
            <legend><b>Search a paper :</b></legend>
                    <legend><b></b></legend>
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="name"<?php if(isset($_POST['title'])){echo "value=\"".$_POST['title']."\"";}?>/>
                    <div id="selectField">
                        <p>Only show papers and books about:</p>
                        <input type="checkbox" name="field[]" value="Physics" <?php if(isset($_POST['field']) && in_array("Physics", $_POST['field'])){echo 'checked';}?>>Physics<br>
                        <input type="checkbox" name="field[]" value="Mathematics" <?php if(isset($_POST['field']) && in_array("Mathematics", $_POST['field'])){echo 'checked';}?>>Mathematics<br>
                        <input type="checkbox" name="field[]" value="Computer Science" <?php if(isset($_POST['field']) && in_array("Computer Science", $_POST['field'])){echo 'checked';}?>>Computer Science<br>
                    </div>
                <fieldset>
                    <legend>Sort by:</legend>
                    <select name="sorting" size="1">
                        <option value="Title" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'Title') {echo 'selected';} ?>>Title</option>
                        <option value="Year" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'Year') {echo 'selected';} ?>>Year Published</option>
                        <option value="Field" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'Field') {echo 'selected';} ?>>Field</option>
                    </select>
                    <div id="order">
                        <input type="radio" name="order" value=" " <?php if(isset($_POST['order']) && $_POST['order'] == " "){echo 'checked';}?> checked>Ascending<br>
                        <input type="radio" name="order" value="DESC" <?php if(isset($_POST['order']) && $_POST['order'] == "DESC"){echo 'checked';}?>>Descending<br>
                    </div>
                </fieldset>
            </fieldset>
            </div>
            <input id="submitButton" type="submit" value="Submit">
        </form>
    <div style="overflow-x:auto;">
            <table id="authList" width="90%">
            <tr>
                <th>Authors</th>
                <th>Title</th>
                <th>Year</th>
                <th>Field</th>
            </tr>
            <?php
                $chosenMethod='Title';
                $order = " ";
                if (isset($_POST['sorting']))
                {
                    $chosenMethod = $_POST['sorting'];
                    $selected = $_POST['sorting'];
                }
                try
                {
                    $bdd = new PDO('mysql:host=localhost;dbname=operaomnia v2;charset=utf8', 'root', '');
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
                $query="SELECT * FROM papers";
                if(!empty($_POST['title']) && isset($_POST['title']))
                {
                    $title = htmlspecialchars($_POST['title']);
                    $query .=' WHERE Title LIKE \'%'.$title.'%\' ';
                }
                if(isset($_POST['field']))
                {
                    $field = $_POST['field'];
                    if(!empty($_POST['title']) && isset($_POST['title']))
                    {
                    $query .='AND Field IN(\'';
                    foreach($field as $individualField)
                    {
                    $query .= $individualField."','";
                    }
                    $query .="placeholder')";
                }
                else
                {
                    $query .=' WHERE Field IN(\'';
                    foreach($field as $individualField)
                    {
                    $query .= $individualField."','";
                    }
                    $query .="placeholder')";
                }
            }
                if (isset($_POST['order']))
                {
                    $order = $_POST['order'];
                }
                $query.=" ORDER BY ". $chosenMethod ." ". $order;
    

                $reponse=$bdd->query($query);
                $nResults=0;
                while ($data = $reponse->fetch())
                {
                    $nResults=$nResults+1;
            ?>
                <tr class='clickable-row' data-href='paper.php?id=<?php echo $data['ID']?>'>
                    <?php
                    if($data['Fields']==0)
                    {
                        $paperField='Other';
                    }
                    elseif ($data['Fields']==1) {
                        $paperField='Mathematics';
                    }
                    elseif ($data['Fields']==2) {
                        $paperField='Physics';
                    }
                    elseif ($data['Fields']==3) {
                        $paperField='Computer Science';
                    }
                    $authList="";
                    $authors=array();
                    $currentID="";
                    for($i=0;$i<=strlen($data['AuthorID']);$i++)
                    {
                        if(isset($data['AuthorID'][$i]) && $data['AuthorID'][$i]!="_")
                        {
                            $currentID.=$data['AuthorID'][$i];
                        }
                        else
                        {
                            array_push($authors,$currentID);
                            $currentID="";
                        }
                    }
                    foreach ($authors as $auth1)
                    {
                        $query2="SELECT * FROM authors WHERE ID=".$auth1;
                        $reponse1=$bdd->query($query2);
                        $dataAuthor=$reponse1->fetch();
                        $authName=$dataAuthor['FirstName']." <strong>".$dataAuthor['LastName']."</strong>";
                        $authList.=$authName.", ";
                    }
                    $authList=substr($authList, 0, -2);
                    ?>
                    <td><?php echo $authList;?></td>
                    <td id="authName"><?php echo $data['Title']?></td>
                    <td><?php echo date_format(date_create($data['Date']),"Y");?></td>
                    <td><?php echo $paperField?></td>
                </tr>
            <?php
            }
                if ($nResults==0)
                {
                    if(isset($_POST['title']))
                    {
                    ?>
                        <tr>
                <td id="noResult" colspan="5">There were no results for the title "<?php echo $_POST['title']?>". You could check the spelling, or try this name in other fields.</td>
                </tr>
                    <?php
                }
                else
                {
                    ?>
                        <tr>
                <td id="noResult" colspan="5">No paper was found.</td>
                </tr>
                    <?php
                }
            }
                $reponse->closeCursor();
            ?>
            </table>
        </div>          
    </section>
    
<?php include("footer.php"); ?>
</body>
</html>
