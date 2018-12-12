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
        <form method="post">
            <div>
                    <label class = 'submitPaper_content' for='title'> <b>Title :</b> </label> <br />
                    <input size = "4"type='text' name='title' id ='title' />
                <br/>
                    <label for='year'> <b>Year of publication :</b> </label>
                <br />
                    <select name="year"> 
                    <?php   
                        for ($i = 2018; $i >= 0;$i --) // à changer 
                        {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>            
                <br />
                    <label for='description'> <b>Small Description :</b></label>
                <br />
                    <input type ='text' name='description'/>
                <br />
                    <label for='Field'><b>Field :</     b></label>
                <br />
                    <select name="field">
                        <option selected ='selected' disabled value="" >Choose an option ...</option>
                        <option value="Physics">Physics</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="Computer Science">Computer Science</option>
                    </select>
                <br />
                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />    
                    <label for="paper" id='labelPaper'>Paper (max: 1Mo) : <br/><strong> (must be in pdf format) </strong></label><br />
                    <input type="file" name="paper" /><br />
                <br />
                    <div style = 'display: inline-block;' class="g-recaptcha" data-sitekey="6Ld4wlQUAAAAACkUoU2969gtylxLnEvshqlbGK8x" data-size="compact"></div>
                <br />
                <?php
                require('recaptcha/autoload.php');
                    if(isset($_POST['g-recaptcha-response']))
                    {
                        $recaptcha = new \ReCaptcha\ReCaptcha('6Ld4wlQUAAAAAIIvYwnYNZAdTSgRmRL9NsrMNshR');
                        $resp = $recaptcha->verify($_POST['g-recaptcha-response']);
                        if ($resp->isSuccess()) {
                            $url='submitted';
                            echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';                    
                        } 
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
                </div>
        </form>
        </fieldset>        
    </section>
<?php include("footer.php"); ?>
</body>
</html>