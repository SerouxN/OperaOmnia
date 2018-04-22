<!DOCTYPE html>

<html>
<head>
    <title>Opera Omnia - Papers</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <?php include("header.php"); ?>
    <section>
        <h1>Submit</h1>
        
        <fieldset class = "submitPaper">
        <legend> Become a cool man and submit a paper </legend>
        <form method="post">
            <p>
                <label for='title'> Titre : </label> <br />
                <input type='text' name='title' id ='title' />
            <br/>
                <label for='year'> Year of publication : </label>
            <br />
                <select name="year">
                <?php
                    for ($i = -1000; $i <= 2018;$i ++)
                    {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                    ?>
                </select>            
            <br />
                <label for='description'> Small Description </label>
            <br />
                <input type ='text' name='description'/>
            <br />
                <label for='Field'> Field : </label>
            <br />
                <select name="field">
                    <option value="" selected ='selected'></option>
                    <option value="Physics">Physics</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="Computer Science">Computer Science</option>
                </select>
            <br />
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />    
                <label for="paper">Paper (max: 1Mo) : <strong> (must be in pdf format) </strong></label><br />
                <input type="file" name="paper" /><br />
            <br />
            <div class="g-recaptcha" data-sitekey="6Ld4wlQUAAAAACkUoU2969gtylxLnEvshqlbGK8x"></div><br />
            <?php
            require('recaptcha/autoload.php');
                if(isset($_POST['g-recaptcha-response']))
                {
                    $recaptcha = new \ReCaptcha\ReCaptcha('6Ld4wlQUAAAAAIIvYwnYNZAdTSgRmRL9NsrMNshR');
                    $resp = $recaptcha->verify($_POST['g-recaptcha-response']);
                    if ($resp->isSuccess()) {
                        $url='submitted.php';
                        echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';                    } 
                    else {
                        $errors = $resp->getErrorCodes();
                        $errorString=implode("|",$errors);
                        if($errorString=='missing-input-response')
                        {
                            echo "You forgot to validate the captcha!";?><br /><br /><?php
                        }
                    }
                }
            ?>
            <input name="submit" type="submit" value="Submit ! " class="submitPaperButton" />
            </p>
        </form>
        </fieldset>        
    </section>
<?php include("footer.php"); ?>
</body>
</html>