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
        session_start();   
        // ATTENTION, potentielle faille injection à corriger
        // TODO : Permttre la modification des champs
        try
        {
            $db = new PDO('mysql:host=localhost;dbname=operaomnia v2;charset=utf8', 'root', '');
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
            .$data['Language']."</td><td>".$data['Year']."</td><td>".$data['Field']."</td>";
            //bricolage puissance 189
            echo "<td> 
            <form action = 'papAdmissible.php' method='post'>
            <input type='hidden' name='id' value = '".$data['ID']."'/>
            <input type='hidden' name='authorID' value = '".$data['AuthorID']."'/>
            <input type='hidden' name='title' value = '".$data['Title']."'/>
            <input type='hidden' name='summary' value = '".$data['Summary']."'/>
            <input type='hidden' name='Language' value = '".$data['Language']."'/>
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
        <br /> <h3>New versions of existing papers :</h3>
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
            <input type='hidden' name='Language' value = '".$data['Language']."'/>
            <input type='submit' value= 'Accept' name = 'decision'  />
            <input type='submit' value= 'Decline' name = 'decision'  />
            </form>
            </td></tr>";

        }

        ?>         
        </table>
    </section> 
    <section>
        <h3> New authors: </h3>

            <table id='authList'>
            <tr>
                <th> ID </th>
                <th> FirstName </th>
                <th> Last Name </th>
                <th> Birthday </th>
                <th> Death </th>
                <th> Bio </th>
                <th> Field </th>
                <th> Decision </th>
            </tr>
            <?php
        $resp = $db->query('SELECT * FROM autsubmits');
        while ($data = $resp->fetch() )
        {

            echo "<tr><td>".$data['definitiveID']."</td><td>".$data['FirstName']."</td><td>".$data['LastName']."</td><td>".$data['DateBirth']."</td><td>"
            .$data['DateDeath']."</td><td>".$data['Bio']."</td><td>".$data['Fields']."</td>";
            //bricolage puissance 189
            echo "<td> 
            <form action = 'autAdmissible.php' method='post'>
            <input type='hidden' name='id' value = '".$data['definitiveID']."'/>
            <input type='hidden' name='fname' value = '".$data['FirstName']."'/>
            <input type='hidden' name='lname' value = '".$data['LastName']."'/>
            <input type='hidden' name='birth' value = '".$data['DateBirth']."'/>
            <input type='hidden' name='death' value = '".$data['DateDeath']."'/>
            <input type='hidden' name='bio' value = '".$data['Bio']."'/>
            <input type='hidden' name='field' value = '".$data['Fields']."'/>
            <input type='submit' value= 'Accept' name = 'decision'  />
            <input type='submit' value= 'Decline' name = 'decision'  />
            </form>
            </td></tr>";

        }
        $_SESSION['definitiveID']=$data['definitiveID'];
        $_SESSION['paperID']=$data['id'];
        ?> </table>
   </section>
    <?php include("footer.php"); ?>
</body>
</html>