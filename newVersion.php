<!DOCTYPE html>

<html>
<head>
    <title>Opera Omnia - Papers</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta name="viewport" content="width=device-width"/>

</head>
<body>
    <?php include("header.php");
    session_start();
    try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=operaomnia v2;charset=utf8', 'root', '');
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
                $description=$data['Description'];
                $AuthID=$data['AuthorID'];
            }?>
    <section class='sectionSubmit'>
        <h1>Submit a new version of <em><?php echo $title ?></em></h1>
        <?php $_SESSION['paperID'] = $_GET['id'];?>
        <fieldset class = "submitPaper">
        <form action="verSubmitted.php" enctype="multipart/form-data" method="post">
            <div>
            <label class = 'submitPaper_content' for='fileTitle' title='The title of the file you submitted'><b>Title of the file for this version:</b> </label><input size = "4" type='text' name='fileTitle' id ='fileTitle' required/><br/>
                <label for='type'><b>Type :</b></label>
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