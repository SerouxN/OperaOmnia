<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <title>Opera Omnia - Subjects</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width" />
    <style>
      .topnav ul li [href='subjects'] {
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
    <h1>Authors</h1>
        <form method="post" action="#">
            <div id="formAuthors">
                <fieldset>
                    <legend>Research Parameters:</legend>
                    <label for="name">Title:</label>
                    <input type="text" name="name" id="name"<?php if(isset($_POST['name'])){echo "value=\"".$_POST['name']."\"";}?>/>
                    <div id="selectField">
                        <p>Only show papers and books about:</p>
                        <input type="checkbox" name="field[]" value="Physics" <?php if(isset($_POST['field']) && in_array("Physics", $_POST['field'])){echo 'checked';}?>>Physics<br>
                        <input type="checkbox" name="field[]" value="Mathematics" <?php if(isset($_POST['field']) && in_array("Mathematics", $_POST['field'])){echo 'checked';}?>>Mathematics<br>
                        <input type="checkbox" name="field[]" value="Computer Science" <?php if(isset($_POST['field']) && in_array("Computer Science", $_POST['field'])){echo 'checked';}?>>Computer Science<br>
                    </div>
                </fieldset>
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
            </div>
            <input id="submitButton" type="submit" value="Submit">
        </form>
    <h1>Subjects</h1>
    <div style="overflow-x:auto;">
            <table id="authList" width="90%">
            <tr>
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
                    $bdd = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
                $query="SELECT * FROM papers";
                if(isset($_POST['title']) && !empty($_POST['title']))
                {
                    $query.=" WHERE Title LIKE '%".strtoupper($_POST['title'])."%' ";
                    if(isset($_POST['field']))
                    {
                        $fieldWanted=$_POST['field'];
                        if(!empty($fieldWanted))
                        {
                            $iterations=0;
                            foreach($fieldWanted as $singleField)
                            {
                                if($iterations==0)
                                {
                                    $query.=" AND Field='".$singleField."'";
                                }
                                else
                                {
                                    $query.=" OR Field='".$singleField."'";
                                }
                                $iterations=$iterations+1;
                            }
                        }
                    }
                }
                else
                {
                    if(isset($_POST['field']))
                    {
                        $fieldWanted=$_POST['field'];
                        if(!empty($fieldWanted))
                        {
                            $iterations=0;
                            foreach($fieldWanted as $singleField)
                            {
                                if($iterations==0)
                                {
                                    $query.=" WHERE Field='".$singleField."'";
                                }
                                else
                                {
                                    $query.=" OR Field='".$singleField."'";
                                }
                                $iterations=$iterations+1;
                            }
                        }
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
                    <td id="authName"><?php echo $data['Title']?></td>
                    <td><?php echo $data['Year']?></td>
                    <td><?php echo $data['Field']?></td>
                </tr>
            <?php  
                }
                if ($nResults==0)
                {
                    ?>
                        <tr>
                <td id="noResult" colspan="5">There were no results for the name "<?php echo $_POST['name']?>". You could check the spelling, or try this name in other fields.</td>
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