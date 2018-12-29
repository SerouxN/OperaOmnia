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
        <h1>Admissons (only staff)</h1>
        <table id = 'authList'> 
            <tr>
                <th> ID </th>
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
            echo "<tr><td>".$data['ID']."</td><td>".$data['AuthorID']." (".$autName[0].")</td><td>".$data['Title']."</td><td>".$data['Summary']."</td><td>"
            .$data['language']."</td><td>".$data['Year']."</td><td>".$data['Field']."</td>";
            //bricolage puissance 189
            echo "<td> 
            <form action = 'admissible.php' method='post'>
            <input type='hidden' name='authorID' value = '".$data['AuthorID']."'/>
            <input type='hidden' name='title' value = '".$data['Title']."'/>
            <input type='hidden' name='summary' value = '".$data['Summary']."'/>
            <input type='hidden' name='language' value = '".$data['language']."'/>
            <input type='hidden' name='year' value = '".$data['Year']."'/>
            <input type='hidden' name='field' value = '".$data['Field']."'/>
            <input type='submit' value= 'accept' name = 'decision'  />
            <input type='submit' value= 'decline' name = 'decision'  />
            </form>
            </td></tr>";
            
        }

        ?>         
        </table>
   </section>
    <?php include("footer.php"); ?>
</body>
</html>