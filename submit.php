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
        <p>If you want to add a new version to a paper already hosted on <em>Opera Omnia</em>, go to that paper's page.</p>
        <fieldset class = "submitPaper">
        <legend> Become a cool man and submit a paper </legend>
        <form action="submitted.php" enctype="multipart/form-data" method="post">
            <div>
                    <label class = 'submitPaper_content' for='title'> <b>Title :</b> </label> <br />
                    <input size = "4"type='text' name='title' id ='title' required/>
                <br/>
                    <label for='year'> <b>Year of publication :</b> </label>
                    <select name="year" required>
                    <option selected ='selected' disabled value="" >Choose a year ...</option> 
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
                    <input type ='text' name='summary' required />
                <br />
                    <label for='Field'><b>Field :</b></label>
                    <select name="field" id = 'field' required>
                        <option selected ='selected' disabled value="" >Choose a field ...</option>
                        <option value="Physics">Physics</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="Computer Science">Computer Science</option>
                    </select>
                <br />  
                <label for='language'><b>Language :</b></label>
                    <select name="language" id = 'language' required>
                        <option selected ='selected' disabled value="" >Choose a language ...</option>
                        <option value="0">Original scan (whatever language)</option>
                        <option value="1">English</option>
                        <option value="2">German</option>
                        <option value="3">French</option>
                        <option value="4">Dutch</option>
                        <option value="5">Latin</option>
                    </select>
                <br /> 
                <label for='authorID'><b>Select the author : </b></label>
                    <select name="authorID"id = 'authorID' required>
                        <option selected ='selected' disabled value="" required>Choose an author ...</option>
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
                    </select >
                <br />
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />    
                    <label for="paper" id='labelPaper'>Paper (max: 10Mo) : <br/><strong> (must be in pdf format) </strong></label><br />
                    <input type="file" name="paperSubmitted" />
                <br />
                <?php 
                if (isset($_GET['error']))
                {
                    $e =  $_GET['error'];
                    if ($e == 1)
                    {
                        echo "<strong style='color: red';>Invalid format</strong></br>";
                    }
                    if ($e == 2)
                    {
                        echo "<strong style='color: red';>File too big</strong></br>"; 
                    }
                    if ($e == 3)
                    {
                        echo "<strong style='color: red';>There is no file or there has been an error</strong></br>";
                    }
                }
                
                
                ?>
                <input type="submit" value="Submit ! "name = 'submit' id="submitPaperButton" />
                </div>
        </form>
        </fieldset>        
    </section>
<?php include("footer.php"); ?>
</body>
</html>