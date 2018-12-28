<!DOCTYPE html>

<html>
<head>
    <title>Opera Omnia - Papers</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta name="viewport" content="width=device-width"/>
    <style>
      .topnav ul li a[href='submit'] {
        background-color: #BDBDBD;
      }
    </style>
</head>
<body>
    <?php include("header.php"); ?>
    <section class='sectionSubmit'>
        <h1>Submit a paper</h1>
        
        <fieldset class = "submitPaper">
        <legend> Become a cool man and submit a paper </legend>
        <form action="submitted.php" enctype="multipart/form-data" method="post">
            <div>
                    <label class = 'submitPaper_content' for='title'> <b>Title :</b> </label> <br />
                    <input size = "4"type='text' name='title' id ='title' />
                <br/>
                    <label for='year'> <b>Year of publication :</b> </label>
                    <select name="year"> 
                    <?php   
                        for ($i = 2018; $i >= 0;$i --) // à changer 
                        {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>            
                <br />
                    <label for='summary'> <b>Small Description :</b></label>
                <br />
                    <input type ='text' name='summary'/>
                <br />
                    <label for='Field'><b>Field :</b></label>
                    <select name="field">
                        <option selected ='selected' disabled value="" >Choose a field ...</option>
                        <option value="Physics">Physics</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="Computer Science">Computer Science</option>
                    </select>
                <br />  
                <label for='authorID'><b>Select the author : </b></label>
                    <select name="authorID">
                        <option selected ='selected' disabled value="" >Choose an author ...</option>
                        <?php
                        try
                        {
                            $bdd = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');
                            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        }
                        catch(Exception $e)
                        {
                                die('Error : '.$e->getMessage());
                        }

                        $response = $bdd->query('SELECT * FROM authors ORDER BY LastName');
                        while ($data = $response->fetch())
                            {
                                echo "<option value = ".$data['ID'].">".$data['FirstName']." ".$data['LastName']."</option>";
                            }
                        $response->closeCursor();
                        ?>
                        <option value="unspecified">Other</option>
                        <!-- TODO : faire jaavscript qui affiche un menu ouy mettre m'auteur -->
                    </select>
                <br />
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />    
                    <label for="paper" id='labelPaper'>Paper (max: 1Mo) : <br/><strong> (must be in pdf format) </strong></label><br />
                    <input type="file" name="paperSubmitted" />
                <br />
                <?php 
                if (isset($_GET['error']))
                {
                    $e =  $_GET['error'];
                    if ($e == 1)
                    {
                        echo "<strong style='color: red';>Invalid format</strong>";
                    }
                    if ($e == 2)
                    {
                        echo "<strong style='color: red';>File too big</strong></br>"; 
                    }
                }
                
                
                ?>
                <input type="submit" value="Submit ! "name = 'submit' class="submitPaperButton" />
                </div>
        </form>
        </fieldset>        
    </section>
<?php include("footer.php"); ?>
</body>
</html>