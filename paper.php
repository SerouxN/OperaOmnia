<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="jquery.js"></script>
        <?php
            $field=0; //0: maths, 1:compsci, 2:physics
            try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=operaomnia v2;charset=utf8', 'root', '');
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(Exception $e)
            {
                    die('Erreur : '.$e->getMessage());
            }
            $reponse = $bdd->query('SELECT * FROM papers WHERE ID='. $_GET['id']);
            $n=0;
            while ($data = $reponse->fetch())
            {
                $title=$data['Title'];
                $description=$data['Description'];
                $authID=$data['AuthorID'];
                $n++;
            }
            $authsID = explode("_", $authID);
            if($n==0)
            {
                function Redirect($url, $permanent = false)
                {
                    header('Location: ' . $url, true, $permanent ? 301 : 302);
                    exit();
                }
                Redirect('index.php', false);
            }

        ?>
        <title><?php echo $title;?></title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="utf-8"/>
        <script>
            jQuery(document).ready(function($) 
            {
                $(".clickable-row").click(function() 
                {
                    window.location = $(this).data("href");
                });
            });
        </script>
    </head>
    <body>   
        <?php include("header.php"); ?>
        <section style="padding-left:50px; padding-right:50px;">
            <?php $i = 0;
            foreach($authsID as $authID)
            {
                
                $reponse2 = $bdd->query('SELECT * FROM authors WHERE ID='. $authID);
                // faire boucle qui parcourt les auteurs et affiche 
                while ($data = $reponse2->fetch())
                {
                    $AuthFirstName=$data['FirstName'];
                    $AuthLastName=$data['LastName'];
                    $AuthField=$data['Fields'];
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
                if ($i == 0) {
                    $authors_title = " by ". $AuthFirstName." ".$AuthLastName ;
                }
                else {
                    $authors_title .= "and ". $AuthFirstName." ".$AuthLastName;
                }
                $i += 1 ;
            } ?>
            <h1><strong><?php echo $title ?></strong><i><?php echo$authors_title;?></i>.</h1>
            <?php 
            if(isset($description) && !empty($description))
            {?>
            <h2>&nbsp;&nbsp;&nbsp;&nbsp;Description</h2>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $description; ?></p>
            <?php
            }?>
            <h2>&nbsp;&nbsp;&nbsp;&nbsp;Versions</h2>
            <?php
                $numberOfVersions=0;
                foreach (glob("papers/". $_GET['id']."_*") as $filename) 
                {
                    $numberOfVersions=$numberOfVersions+1;
                }
                if ($numberOfVersions==0)
                {
                    echo "This paper is not available on Opera Omnia!";
                }
                else if (($numberOfVersions==1))
                {
                    echo "There is only <strong>1</strong> version of this paper available on <em>Opera Omnia</em>.";?>
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
                        </tr>
                            <?php
                                include 'PDFInfo.php';
                                foreach (glob("papers/". basename($_GET['id']."_*")) as $filename) 
                                {
                                    $homeMade=0;
                                    $paper = new PDFInfo;
                                    $paper->load($filename);
                                    $fileTitle=$title;
                                    $fileTitle=$paper->title;
                                    if($fileTitle=="Untitled" || strlen($fileTitle)==0)
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
                            <tr  class='clickable-row' data-href='<?php echo $filename?>'>
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
                                elseif ($version==2)
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
                            ?></td></tr>
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
                        </tr>
                            <?php
                                include 'PDFInfo.php';
                                foreach (glob("papers/". $_GET['id']."_*") as $filename) 
                                {
                                    $homeMade=0;
                                    $fileTitle="";
                                    $paper = new PDFInfo;
                                    $paper->load($filename);
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
                                        if(is_numeric($version)==false)
                                        {
                                            $version=substr($filename, -7, 1);
                                        }
                                    }?>
                            <tr  class='clickable-row' data-href='<?php echo $filename?>'>
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
                             </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php
            }
            ?>
            <p><br/>File names displayed in bold correspond to versions of the papers made by <em>Opera Omnia</em>.</p>
            <p>Click <a href='newVersion.php?id=<?php echo $_GET['id']?>' style="color:black;">here</a> if you want to add a version of this paper to <em>Opera Omnia</em>.</p>
        </section>
        <?php include("footer.php"); ?>
    </body>
</html>