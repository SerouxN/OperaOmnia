<!DOCTYPE html>
<html>
    <head>
        <?php
        $field=0; //0: maths, 1:compsci, 2:physics
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
                $description=$data['Description'];
                $AuthID=$data['AuthorID'];
            }
            $reponse2 = $bdd->query('SELECT * FROM authors WHERE ID='. $AuthID);
            while ($data = $reponse2->fetch())
            {
                $AuthField=$data['Field'];
                if ($AuthField=="Mathematics")
                {
                    $field=0;
                }
                elseif ($AuthField=="Physics")
                {
                    $field=2;
                }
                else
                {
                    $field=1;
                }
            }
            $reponse2->closeCursor();
        ?>
        <title>Opera Omnia - <?php echo $data['Title']?></title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="utf-8"/>
    </head>
    <body>   
        <?php include("header.php"); ?>
        <section>
            <h1><?php echo $title?></h1>
            <h2>Description</h2>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $description ?></p>
            <h2>Versions</h2>
            <table id=
            <?php 
            if ($field==0)
            {
                echo "\"versionListMaths\"";
            } 
            elseif ($field==1)
            {
                echo "\"versionListCpsci\"";
            }
            elseif ($field==2)
            {
                echo "\"versionListPhys\"";
            }?>
             width="90%">
                <tr>
                    <th>Title</th>
                    <th>Version</th>
                    <th>Link</th>
                </tr>
                <?php
                    include 'PDFInfo.php';
                    foreach (glob("papers/". $_GET['id']."_*") as $filename) {
                        $paper = new PDFInfo;
                        $paper->load($filename);
                        $fileTitle="";
                        $fileTitle=$paper->title;
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
                        elseif ($version ==4)
                        {
                            echo "Dutch";
                        } 
                        elseif ($version ==5)
                        {
                            echo "Latin";
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