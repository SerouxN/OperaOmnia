<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <title>Opera Omnia - Authors</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8"/>
    <style>
      .topnav ul li [href='authors'] {
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
    <?php include("header.php"); 
    $nResults=0;
    $selected =""?>
    <section>
        <h1>Authors</h1>
        <form method="post" action="#">
            <div id="formAuthors">
            <fieldset>
            <legend><b> Search an author :</b></legend>
                    <label for="name">Name of the author:</label>
                    <input type="text" name="name" id="name"<?php if(isset($_POST['name'])){echo "value=\"".$_POST['name']."\"";}?>/>
                    <div id="selectField">
                        <p>Only show:</p>
                        <input type="checkbox" name="field[]" value="Physics" <?php if(isset($_POST['field']) && in_array("Physics", $_POST['field'])){echo 'checked';}?>>Physicists<br>
                        <input type="checkbox" name="field[]" value="Mathematics" <?php if(isset($_POST['field']) && in_array("Mathematics", $_POST['field'])){echo 'checked';}?>>Mathematicians<br>
                        <input type="checkbox" name="field[]" value="Computer Science" <?php if(isset($_POST['field']) && in_array("Computer Science", $_POST['field'])){echo 'checked';}?>>Computer Scientists<br>
                    </div>
                <fieldset>
                    <legend>Sort by:</legend>
                    <select name="sorting" size="1">
                        <option value="LastName" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'LastName') {echo 'selected';} ?>>Last Name</option>
                        <option value="FirstName" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'FirstName') {echo 'selected';} ?>>First Name </option>
                        <option value="Birthday" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'Birthday') {echo 'selected';} ?>>Birth Date</option>
                        <option value="DateOfDeath" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'DateOfDeath') {echo 'selected';} ?>>Death Date</option>
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
            <tr id="tableAuthorList">
                <th>Name</th>
                <th>Years</th>
                <th class="biography">Bio</th>
                <th>Fields</th>
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
                    $bdd = new PDO('mysql:host=localhost;dbname=operaomnia v2;charset=utf8', 'root', '');
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
                $query="SELECT * FROM authors";
                if(isset($_POST['name']) && !empty($_POST['name']))
                {
                    $query.=" WHERE LastName LIKE '%".strtoupper($_POST['name'])."%' ";
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
                    $fieldList="";
                    $temp="";
                    for($i=0; $i<strlen($data['Fields']); $i++) 
                    {
                       // var_dump($data['Fields']);
                        if($data['Fields'][$i]!='_')
                        {
                            $temp.=$data['Fields'][$i];
                        }
                        if($data['Fields'][$i]=='_' or $i==strlen($data['Fields'])-1)
                        {
                            if($temp==0)
                            {
                                $fieldList="Other";
                            }
                            else
                            {
                                if($temp==1)
                                {
                                    $fieldList.="Mathematics, ";
                                }
                                if($temp==2)
                                {
                                    $fieldList.="Physics, ";
                                }
                                if($temp==3)
                                {
                                    $fieldList.="Computer Science, ";
                                }
                                
                            }
                            $temp="";
                        }
                    }
                    $fieldList=substr($fieldList, 0, -2);
                    $nResults=$nResults+1;
            ?>
                <tr class='clickable-row' data-href='author.php?authid=<?php echo $data['ID']?>'>
                <td id="authName"><?php echo $data['FirstName']; ?> <strong><?php echo $data['LastName']; ?></strong></td>
                <td>(<?php echo date_format(date_create($data['DateBirth']),"Y");?>-<?php if($data['DateDeath'] != NULL){echo date_format(date_create($data['DateDeath']),"Y");}else{echo "  ";} ?>)</td>
                <td id="bio"><?php echo substr($data['Bio'], 0, 100)?>...</td>
                <td><?php echo $fieldList?></td>
                </tr>
            <?php  
                }
                if ($nResults==0)
                {
                    if(isset($_POST['title']))
                    {
                    ?>
                        <tr>
                        <td id="noResult" colspan="5">There were no results for the name "<?php echo $_POST['name']?>". You could check the spelling, or try this name in other fields.</td>
                </tr>
                    <?php
                }
                else
                {
                    ?>
                        <tr>
                <td id="noResult" colspan="5">No author was found.</td>
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
