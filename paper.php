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
        $reponse = $bdd->query('SELECT * FROM papers WHERE ID='. $_GET['id']);
        while ($data = $reponse->fetch())
        {
            $title=$data['Title'];
        }
        $reponse->closeCursor();
    ?>
    <title>Opera Omnia - <?php echo $data['Title']?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8"/>
</head>
<body>   
    <?php include("header.php"); ?>
    <section>
    <h1><?php echo $title?></h1>
    <h2>Versions</h2>
    <table id="authList" width="90%">
        <tr>
            <th>Title</th>
            <th>Version</th>
            <th>Link</th>
        </tr>
        <?php
        foreach (glob("papers/". $_GET['id']."_*") as $filename) {
            $sourcefile = $filename;
            $stringedPDF = file_get_contents($sourcefile, true);
            preg_match('/(?<=Title )\S(?:(?<=\().+?(?=\))|(?<=\[).+?(?=\]))./', $stringedPDF, $title);
            preg_match('#\((.*?)\)#', $title[0], $match);
            $fileTitle = utf8_encode($match[1]);
            $version=substr($filename, -5, 1);
        ?>
        <tr>
            <td id="paperTitle"><?php echo $fileTitle ?></td>
            <td id="version"><?php 
                if ($version ==0)
                {
                    echo "Original Scan";
                }   
                elseif ($version ==1)
                {
                    echo "English";
                }    
                elseif ($version ==2)
                {
                    echo "German";
                } 
                elseif ($version ==3)
                {
                    echo "French";
                } 
            ?></td>
            <td><a  id="goLink" href=<?php echo $filename?>>Go</a></td>
        </tr>
        <?php 
        }
        ?>
        </table>
    </section>
    <?php include("footer.php"); ?>
</body>
</html>