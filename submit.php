<!DOCTYPE html>

<html>
<head>
    <title>Opera Omnia - Submit a paper</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta name="viewport" content="width=device-width"/>

    <style>
      .topnav ul li a [href='submit'] 
      {
        background-color: #DDDDDD;
      }
    </style>

</head>
<body>
    <?php include("header.php"); ?>
    <section class='sectionSubmit'>
        <h1>Submit a paper</h1>
        <p>If you want to add a new version to a paper already hosted on <em>Opera Omnia</em>, you can go to that paper's page.</p>
        <fieldset class = "submitPaper">
        <legend> Submit a paper </legend>
        <form action="submitted.php" enctype="multipart/form-data" method="post">
            <div>
                <label class = 'submitPaper_content' for='title' title='The original title of the paper, in its original language'><b>Title :</b> </label>
                <input size = "4" type='text' name='title' id ='title' required/>
                <br/>
                    <label for='date'> <b>Date of publication :</b> </label>
                    <!--<select name="date" required>
                    <option selected ='selected' disabled value="" >Choose a year ...</option> 
                    <?php   
                        for ($i = 2019; $i >= 0;$i --) // à changer 
                        {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select> -->     
                    <input type="date" name="date" soze = '20' >
                <br />
                    <label for='summary' title='If the title has no abstract, you may write a brief description of it.'> <b>Abstract:</b></label>
                <br />
                <textarea name='summary' rows="6" cols="60" style="resize:none;"></textarea>
                <br />
                    <label for='Field'><b>Field :</b></label>
                    <select name="field" id = 'field' required>
                        <option selected ='selected' disabled value="" >Choose a field ...</option>
                        <option value="1">Mathematics</option>
                        <option value="2">Physics</option>
                        <option value="3">Computer Science</option>
                        <option value="0">Other</option>
                    </select>
                <br />  
                <label for='type'><b>Type:</b></label>
                    <select name="type" id = 'type' required>
                        <option selected ='selected' disabled value="" >Choose the type of your file ...</option>
                        <option value="1">Original publication</option>
                        <option value="2">Later transcription</option>
                        <option value="3">Later translation</option>
                        <option value="0">Other</option>
                    </select>
                    <br />
                <label for='language'><b>Language:</b></label>
                    <select name="language" id = 'language' required>
                        <option selected ='selected' disabled value="" >Choose a language ...</option>
                        <option value="1">English</option>
                        <option value="2">German</option>
                        <option value="3">French</option>
                        <option value="4">Latin</option>
                        <option value="4">Dutch</option>
                        <option value="5">Portuguese</option>
                        <option value="0">Other language</option>
                    </select>

                <br /> 
                <label for='authorID'><b>Select the author(s) of the paper: </b></label>
                <br />
                    <select multiple name="authorID[]" style="height:100px; width:50%;" id = 'authorID' required>
                        <?php
                        try
                        {
                            $bdd = new PDO('mysql:host=localhost;dbname=operaomnia v2;charset=utf8', 'root', '');
                            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        }
                        catch(Exception $e)
                        {
                                die('Error : '.$e->getMessage());
                        }

                        $response = $bdd->query('SELECT * FROM authors ORDER BY LastName');
                        
                        while ($data = $response->fetch())
                            {
                                echo "<option value = ".$data['ID'].">".$data['FirstName']." <b>".$data['LastName']."</b></option>";
                            }
                        $response->closeCursor();
                        ?>
                        <option value="unspecified">Other</option>
                    </select >


                    <fieldset id = 'addAuthor' style='width: 50%;'>
                        <legend> If OperaOmnia does not have the author of the paper you want to submit, you may add it: </legend>
                            <label class = 'submitPaper_content' for='fname' required> <b>First Name :</b> </label> 
                            <input size f= "20" type='text' name='FirstName' id ='fname' />
                            <br />
                            <label class = 'submitPaper_content' for='lname' required> <b>Last Name :</b> </label> 
                            <input size = "20"type='text' name='LastName' id ='lname' />
                            <br />
                            <label for='authorBirth'> <b>Date of Birthday :</b> </label>
                            <input type="date" name="DateBirth" > 
                            <br />
                            <label for='authorDeath'> <b>Date of death :</b> </label>
                            <input type="date" name="DateDeath" soze = '20' >
                            <br />
                            <label class = 'submitPaper_content' for='bio'> <b>Biography : </b> </label>
                            <br/>
                            <textarea name='Bio' id="bio" rows="6" cols="60" style="resize:none;"></textarea>
                            <br />
                            <label for='Fields'><b>Fields:</b></label><br />
                            <select multiple name="Fields[]" id = 'Fields' >
                                <option selected ='selected' disabled value="" >Choose a field ...</option>
                                <option value="1">Mathematics</option>
                                <option value="2">Physics</option>
                                <option value="3">Computer Science</option>
                                <option value="0">Other</option>
                            </select multiple>
                    </fieldset>
                    <script>
                        var list = document.getElementById('authorID');
                        var addAuthor = document.getElementById('addAuthor');
                         children = addAuthor.childNodes
                        addAuthor.style.display = "none";
                        list.addEventListener('change', function() {

                            if (this.options[list.selectedIndex].value == 'unspecified')
                                {
                                    addAuthor.style.display = "block";
                                for (var i = 0, c = children.length; i < c; i++) 
                                    {
                                        if (children[i].name != 'bio' && children[i].name != 'birth' && children[i].name != 'death') {
                                            console.log(children[i].name);
                                            children[i].required = true ;
                                        }
                                    }
                                }
                            else 
                            {
                                addAuthor.style.display = "none";
                                for (var i = 0, c = addAuthor.childNodes.length; i < c; i++) 
                                    {
                                         
                                        children[i].required = false ;
                                    }
                            }
                        });
                    </script>
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
                <p> Your submission will be accepted or not by the staff.</p>
                </div>
            </form>
        </fieldset>        
    </section>
<?php include("footer.php"); ?>
</body>
</html>