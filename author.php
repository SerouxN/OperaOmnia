<!DOCTYPE html>
<html>
    <head>
            <?php
            try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(Exception $e)
            {
                    die('Erreur : '.$e->getMessage());
            }
            $reponse = $bdd->query('SELECT * FROM authors WHERE ID='. $_GET['authid']);
            while ($data = $reponse->fetch())
            {
                $bio=$data['Bio'];
                $name=$data['FirstName'] . " ". $data['LastName'];
                $familyName=$data['LastName'];
                if ($data['Field']=='Physics')
                {
                    $asideColor="asidePhys";
                }
                else if ($data['Field']=='Mathematics')
                {
                    $asideColor="asideMaths";
                }
                else
                {
                    $asideColor="asidePhys";
                }
            }
            $reponse->closeCursor();
        ?>
        <title>Opera Omnia - <?php echo $familyName?></title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="utf-8"/>
    </head>
    <body>
        <?php include("headerAuthor.php");?>
        <section>
            <h1 id="nameAuthor"><?php echo $name?></h1>
            <div id="core">
                <h1>His Life</h1>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $bio?></p>
                <h1>His Works</h1>
                <h2>&nbsp;&nbsp;&nbsp;&nbsp;Papers</h2>              
                <ul id="paperList">
                    <?php
                        
                        try
                        {
                            $bdd = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');
                            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        }
                        catch(Exception $e)
                        {
                            die('Erreur : '.$e->getMessage());
                        }
                        $reponse = $bdd->query('SELECT * FROM papers WHERE AuthorID='.$_GET['authid'].' AND  Format=0 ORDER BY Year, ID');
                        $numberOfPapers=0;
                        while ($data = $reponse->fetch())
                        {
                            $numberOfPapers=$numberOfPapers+1;
                            ?>
                        <li><a title="<?php echo $data['Title']?> (<?php echo $data['Year']?>)" href="paper.php?id=<?php echo $data['ID'];?>"><img width="232" height="300" src="papers/thumb_<?php echo $data['ID'];?>.png" /></a></li>
                        <?php
                        }
                        $reponse->closeCursor();
                        if ($numberOfPapers==0)
                        {
                            echo "No paper by ".$name." is available on <em>Opera Omnia</em>.";
                        }?>
                </ul>
                <h2>&nbsp;&nbsp;&nbsp;&nbsp;Books</h2>
                <ul id="paperList">
                    <?php
                        
                        try
                        {
                            $bdd = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');
                            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        }
                        catch(Exception $e)
                        {
                            die('Erreur : '.$e->getMessage());
                        }
                        $reponse = $bdd->query('SELECT * FROM papers WHERE AuthorID='.$_GET['authid'].' AND  Format=1 ORDER BY Year, ID');
                        $numberOfPapers=0;
                        while ($data = $reponse->fetch())
                        {
                            $numberOfPapers=$numberOfPapers+1;
                            ?>
                        <li><a title="<?php echo $data['Title']?> (<?php echo $data['Year']?>)" href="paper.php?id=<?php echo $data['ID'];?>"><img width="203" height="300" src="papers/thumb_<?php echo $data['ID'];?>.png" /></a></li>
                        <?php
                        }
                        $reponse->closeCursor();
                        if ($numberOfPapers==0)
                        {
                            echo "No book by ".$name." is available on <em>Opera Omnia</em>.";
                        }?>
                </ul>
            </div>    
        </section>
        <?php include("footer.php"); ?>
    </body>
</html>