<!DOCTYPE html>
<html>
<head>
    <title>Opera Omnia - Papers</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php include("header.php"); ?>
    <section>
        <h1>Submit</h1>
        <fieldset class = "submitPaper">
        <legend> Become a cool man and submit a paper </legend>
        <form action ="submited.php">
            <p>
                <label for='title'> Titre : </label> <br>
                <input type='text' name='title' id ='title' />
            <br/>
                <label for='year'> Year of publication : </label>
            <br>
                <select name="year">
                <?php
                    for ($i = -1000; $i <= 2018;$i ++)
                    {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                    ?>
                </select>            
            <br>
                <label for='description'> Small Description </label>
            <br>
                <input type ='text' name='description'/>
            <br>
                <label for='Field'> Field : </label>
            <br>
                <select name="field">
                    <option value="" selected ='selected'></option>
                    <option value="Physics">Physics</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="Computer Science">Computer Science</option>
                </select>
            <br>
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />    
                <label for="paper">Paper (max: 1Mo) : <strong> (must be in pdf format) </strong></label><br />
                <input type="file" name="paper" /><br />
            <br>
            <input type="submit" value="Submit ! " class="submitPaperButton" />
            </p>
        </form>
        </fieldset>        
    </section>
<?php include("footer.php"); ?>
</body>
</html>