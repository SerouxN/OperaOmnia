<!DOCTYPE html>

<html>
<head>
    <title>Opera Omnia - Report an issue</title>
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
    <h1>Contact us ! </h1>
    <p> This website has been coded by two young non-professional programmer, and thereforce contains surely many bugs and improvement axis. <p>  
    <fieldset class = "submitPaper">
      <div>
        <form method="post" action="issue_reported.php" enctype="multipart/form-data">
            <label for='type'  required> <b>Object  : </b> </label>
            <select name="type" required >
            <option selected='selected' disabled value="" >Select an object ... </option>
            <option value="bug" <?php if  (isset($_GET['selected']) && $_GET['selected'] == 'bug') {echo("selected=''");}?> >I saw a bug </option>
            <option value="suggestion" >I've a suggestion ! </option>
            <option value="hack">I succeed in hacking into your site, can I get a reward ? </option>
            <option value="other">Other ..</option>
            </select>
            <br />
            <label for='description' required> <b>Describe here </b></label> 
            <br/> 
            <textarea name="description" rows="6" cols="60" style="resize:none;" required></textarea>
            <br/>
            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />    
            <label for="paper" id='labelPaper'>Add a Screenshot (optional) (max: 10Mo) : </label><br />
            <input type="file" name="imageSubmitted" accept="image/png, image/jpeg" />
            <br/>
            <input type="submit" value="Submit ! "name = 'submit' id="submitPaperButton" />

        </form>
        </div>
    </fieldset>        
    </section>
<?php include("footer.php"); ?>
</body>
</html>