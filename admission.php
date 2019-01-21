<!DOCTYPE html>
<html>
<head>
    <title>Opera Omnia - admission</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8"/>
</head>
<body>
    <?php include("header.php"); ?>
    <section>
        <h1>Admissons (staff only)</h1>
        <h3> New papers </h3>
        <table id = 'authList'> 
            <tr>
                <th> Author (ID) </th>
                <th> Title </th>
                <th> Summary </th>
                <th> Language </th>
                <th> Year </th>
                <th> Field </th>
                <th> Decision </th>
            </tr>
            
        <?php       
        // ATTENTION, potentielle faille injection à corriger
        // TODO : Permttre la modification des champs
        try
        {
            $db = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(Exception $e)
        {
                die('Error : '.$e->getMessage());
        } 
        $resp = $db->query('SELECT * FROM submits');
        while ($data = $resp->fetch() )
        {
            $r = $db->query("SELECT LastName FROM authors WHERE ID =".$data['AuthorID']."");
            $autName = $r->fetch();
            echo "<tr><td>".$data['AuthorID']." (".$autName[0].")</td><td>".$data['Title']."</td><td>".$data['Summary']."</td><td>"
            .$data['language']."</td><td>".$data['Year']."</td><td>".$data['Field']."</td>";
            //bricolage puissance 189
            echo "<td> 
            <form action = 'papAdmissible.php' method='post'>
            <input type='hidden' name='authorID' value = '".$data['AuthorID']."'/>
            <input type='hidden' name='title' value = '".$data['Title']."'/>
            <input type='hidden' name='summary' value = '".$data['Summary']."'/>
            <input type='hidden' name='language' value = '".$data['language']."'/>
            <input type='hidden' name='year' value = '".$data['Year']."'/>
            <input type='hidden' name='field' value = '".$data['Field']."'/>
            <input type='submit' value= 'Accept' name = 'decision'  />
            <input type='submit' value= 'Decline' name = 'decision'  />
            </form>
            </td></tr>";

        }

        ?>         
        </table>
        </section>
        <section>  
        </br> <h3>New versions of existing papers :</h3>
        <table id = 'authList'> 
            <tr>
                <th> Language </th>
                <th>Paper</th>
                <th>Decision</th>
            </tr>
            
        <?php       
        //ATTENTION, potentielle faille injection à corriger
        //TODO : Permttre la modification des champs
        $resp2 = $db->query('SELECT * FROM submitversion');
        while ($data = $resp2->fetch())
        {
            $resp3=$db->query('SELECT Title FROM papers WHERE ID='. $data['paperID']);
            echo "<tr><td>".$data['Language']."</td><td>".$resp3->fetch()[0]."</td>";
            //bricolage puissance 189
            echo "<td> 
            <form action = 'verAdmissible.php' method='post'>
            <input type='hidden' name='id' value = '".$data['ID']."'/>
            <input type='hidden' name='paperID' value = '".$data['paperID']."'/>
            <input type='hidden' name='language' value = '".$data['Language']."'/>
            <input type='submit' value= 'Accept' name = 'decision'  />
            <input type='submit' value= 'Decline' name = 'decision'  />
            </form>
            </td></tr>";

        }

        ?>         
        </table>
    </section> 
    <section>
        <h3> Add an author : </h3> 
        <form action="autAdmissible.php"  method="post">
        <div style='padding: 14px; '>
            <label class = 'submitPaper_content' for='fname'> <b>First Name :</b> </label> 
            <input size = "20"type='text' name='fname' id ='fname' required/>
            </br>
            <label class = 'submitPaper_content' for='lname'> <b>Last Name :</b> </label> 
            <input size = "20"type='text' name='lname' id ='lname' required/>
            </br>
            <label for='birth'> <b>Date of Birthday :</b> </label>
            <input type="date" name="birth" required> 
            </br>
            <label for='death'> <b>Date of death :</b> </label>
            <input type="date" name="death" required>
            </br>
            <label class = 'submitPaper_content' for='bio'> <b>Biography : </b> </label> 
            <input size = "50 "type='text' name='bio' id ='bio' required/>
            </br>
            <label for='field'><b>Field :</b></label>
            <select name="field" id = 'field' required>
                <option selected ='selected' disabled value="" >Choose a field ...</option>
                <option value="Physics">Physics</option>
                <option value="Mathematics">Mathematics</option>
                <option value="Computer Science">Computer Science</option>
            </select>
            </br>
            <input type="submit" value="Submit ! "name = 'submit' />

            <table id='authList'>
            <tr>
                <th> ID </th>
                <th> FirstName </th>
                <th> Last Name </th>
                <th> Birthday </th>
                <th> Death </th>
                <th> Bio </th>
                <th> Field </th>
            </tr>
            <?php
        $resp = $db->query('SELECT * FROM autsubmits');
        while ($data = $resp->fetch() )
        {

            echo "<tr><td>".$data['firstName']."</td><td>".$data['lastName']."</td><td>".$data['birthday']."</td><td>"
            .$data['dateOfDeath']."</td><td>".$data['Bio']."</td><td>".$data['Field']."</td>";
            //bricolage puissance 189
            echo "<td> 
            <form action = 'autAdmissible.php' method='post'>
            <input type='hidden' name='fname' value = '".$data['firstName']."'/>
            <input type='hidden' name='lname' value = '".$data['lastName']."'/>
            <input type='hidden' name='birth' value = '".$data['birthday']."'/>
            <input type='hidden' name='death' value = '".$data['dateOfDeath']."'/>
            <input type='hidden' name='bio' value = '".$data['Bio']."'/>
            <input type='hidden' name='field' value = '".$data['Field']."'/>
            <input type='submit' value= 'Accept' name = 'decision'  />
            <input type='submit' value= 'Decline' name = 'decision'  />
            </form>
            </td></tr>";

        }
        ?> </table>
   </section>
    <?php include("footer.php"); ?>
</body>
</html>