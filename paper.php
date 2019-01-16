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
                $AuthFirstName=$data['FirstName'];
                $AuthLastName=$data['LastName'];
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
            <h1><strong><?php echo $title ?></strong><?php echo" by ". $AuthFirstName." ".$AuthLastName;?></h1>
            <h2>&nbsp;&nbsp;&nbsp;&nbsp;Description</h2>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $description ?></p>
            <h2>&nbsp;&nbsp;&nbsp;&nbsp;Versions</h2>
            <?php
                $numberOfVersions=0;
                foreach (glob("papers/". $_GET['id']."_*") as $filename) 
                {
                    $numberOfVersions=$numberOfVersions +1;
                }
                if ($numberOfVersions==0)
                {
                    echo "This paper is not available on Opera Omnia!";
                }
                else if (($numberOfVersions==1))
                {
                    echo "There is only <strong>".$numberOfVersions."</strong> version of this paper available on <em>Opera Omnia</em>.";
                    ?>
                    <table width="90%" id=
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
                        }
                    ?>>
                        <tr>
                            <th>Title</th>
                            <th>Version</th>
                            <th>Link</th>
                        </tr>
                            <?php
                                include 'PDFInfo.php';
                                foreach (glob("papers/". $_GET['id']."_*") as $filename) 
                                {
                                    $homeMade=0;
                                    $paper = new PDFInfo;
                                    $paper->load($filename);
                                    $fileTitle="";
                                    $fileTitle=$paper->title;
                                    if($fileTitle=="Untitled")
                                    {
                                        $fileTitle=$title;
                                    }
                                    $version=substr($filename, -5, 1);
                                    if(is_numeric($version)==false)
                                    {
                                        if($version == "!")
                                        {
                                            $homeMade=1;
                                        }
                                        else
                                        {
                                            $homeMade=0;
                                        }
                                        $version=substr($filename, -6, 1);
                                    }?>
                            <tr>
                                    <?php 
                                    if ($homeMade==1)
                                    {?>
                                        <td id="paperTitle"><strong><?php echo $fileTitle ?></strong></td>
                                    <?php
                                    }
                                    else
                                    {?>
                                        <td id="paperTitle"><?php echo $fileTitle ?></td>
                                    <?php
                                    }?>
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
                                elseif ($version ==6)
                                {
                                    echo "Portuguese";
                                } 
                            ?></td>
                            <td><a  id="goLink" href=<?php echo $filename?>>Go</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php
            }
                else
                {
                    echo "There are <strong>".$numberOfVersions."</strong> different versions of this paper available on <em>Opera Omnia</em>.";
                    ?>
                    <table width="90%" id=
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
                        }
                    ?>>
                        <tr>
                            <th>Title</th>
                            <th>Version</th>
                            <th>Link</th>
                        </tr>
                            <?php
                                include 'PDFInfo.php';
                                foreach (glob("papers/". $_GET['id']."_*") as $filename) 
                                {
                                    $homeMade=0;
                                    $paper = new PDFInfo;
                                    $paper->load($filename);
                                    $fileTitle="";
                                    $fileTitle=$paper->title;
                                    if($fileTitle=="Untitled")
                                    {
                                        $fileTitle=$title;
                                    }
                                    $version=substr($filename, -5, 1);
                                    if(is_numeric($version)==false)
                                    {
                                        if($version == "!")
                                        {
                                            $homeMade=1;
                                        }
                                        else
                                        {
                                            $homeMade=0;
                                        }
                                        $version=substr($filename, -6, 1);
                                    }?>
                            <tr>
                                    <?php 
                                    if ($homeMade==1)
                                    {?>
                                        <td id="paperTitle"><strong><?php echo $fileTitle ?></strong></td>
                                    <?php
                                    }
                                    else
                                    {?>
                                        <td id="paperTitle"><?php echo $fileTitle ?></td>
                                    <?php
                                    }?>
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
                                elseif ($version ==6)
                                {
                                    echo "Portuguese";
                                }  
                            ?></td>
                            <td><a  id="goLink" href=<?php echo $filename?>>Go</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php
            }
            ?>
            <p><br/>File names displayed in bold correspond to versions of the papers made by <em>Opera Omnia</em>.</p>
            <p>Click <a href='newVersion.php?id=<?php echo $_GET['id']?>'>here</a> if you want to add a version of this paper to <em>Opera Omnia</em>.</p>
        </section>
        <?php include("footer.php"); ?>
    </body>
</html>