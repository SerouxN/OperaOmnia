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
</head>
<body>
    <?php include("headerAuthor.php"); ?>
    <section>
    <h1 id="nameAuthor"><?php echo $name?></h1>
    <div id="core">
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
            $reponse = $bdd->query('SELECT * FROM papers WHERE AuthorID='.$_GET['authid'].' AND Major=1 ORDER BY Year, ID');
            $num_rows=$reponse->fetchColumn();
            if ($num_rows > 0)
            {?>
    <aside id=<?php echo $asideColor;?>>
        <h1>His Major Publications</h1>
        <ul>
        <?php
            while ($data = $reponse->fetch())
            {
        ?>
        <li><a href="paper.php?id=<?php echo $data['ID'];?>"><?php echo $data['Title']?></a></li>
        <?php
            }}
            $reponse->closeCursor();
        ?>
        </ul>
    </aside>
    <h1>His Life</h1>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $bio?></p>
    <h1>Papers by <?php echo $name?></h1>   
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
            $reponse = $bdd->query('SELECT * FROM papers WHERE AuthorID='.$_GET['authid'].' ORDER BY Year, ID');
            while ($data = $reponse->fetch())
            {
        ?>
        <li><a href="paper.php?id=<?php echo $data['ID'];?>"><?php echo $data['Title']?> (<?php echo $data['Year']?>)</a></li>
        <?php
            }
            $reponse->closeCursor();
        ?>
    </ul>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consequat vel purus eu gravida. Duis fringilla arcu et tortor malesuada cursus nec et metus. Aenean quis lacinia lorem. Proin vel venenatis sapien. Integer feugiat nulla orci, quis hendrerit magna suscipit quis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent pharetra sapien ac feugiat rutrum. Fusce ultrices nisl a felis pulvinar, in blandit neque consequat. Quisque euismod ac risus nec fringilla. Nullam non porta nulla. Sed porttitor aliquet rhoncus.

Mauris et urna dui. Integer imperdiet sodales nisl, at ultrices lorem volutpat ac. Proin augue arcu, convallis ut dignissim posuere, gravida non est. Duis molestie, neque vel sodales ultricies, enim diam molestie tortor, vehicula pretium quam purus et orci. Maecenas tempor nisi eget ex consequat interdum. Quisque pretium, ligula non dictum vestibulum, sapien mauris ultricies justo, ac fermentum ipsum purus quis eros. Vestibulum eleifend interdum augue, sit amet vestibulum magna egestas sed. Aenean ac erat nisi. Etiam hendrerit semper orci et pulvinar. Etiam venenatis posuere sem vitae dignissim. Duis pharetra faucibus hendrerit.

Pellentesque odio arcu, tincidunt eget est ut, sodales viverra massa. Nulla non lacus ante. Suspendisse tristique libero orci, venenatis dapibus ex pretium eu. Donec pharetra erat tristique, sodales erat vel, sagittis mi. Integer vestibulum eu lorem sit amet malesuada. Fusce condimentum condimentum augue, ut convallis justo sagittis quis. Ut efficitur nunc id porttitor consequat.

Mauris id mauris tincidunt, euismod orci sed, consequat diam. Nullam a lacus orci. In ac justo consectetur, bibendum nulla sed, maximus sem. Aliquam scelerisque nulla viverra dui dignissim, sit amet congue nisl tincidunt. Cras ac lacus vel tortor aliquam auctor quis in tellus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam vulputate sed eros vel sagittis. Suspendisse potenti. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos.
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consequat vel purus eu gravida. Duis fringilla arcu et tortor malesuada cursus nec et metus. Aenean quis lacinia lorem. Proin vel venenatis sapien. Integer feugiat nulla orci, quis hendrerit magna suscipit quis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent pharetra sapien ac feugiat rutrum. Fusce ultrices nisl a felis pulvinar, in blandit neque consequat. Quisque euismod ac risus nec fringilla. Nullam non porta nulla. Sed porttitor aliquet rhoncus.

Mauris et urna dui. Integer imperdiet sodales nisl, at ultrices lorem volutpat ac. Proin augue arcu, convallis ut dignissim posuere, gravida non est. Duis molestie, neque vel sodales ultricies, enim diam molestie tortor, vehicula pretium quam purus et orci. Maecenas tempor nisi eget ex consequat interdum. Quisque pretium, ligula non dictum vestibulum, sapien mauris ultricies justo, ac fermentum ipsum purus quis eros. Vestibulum eleifend interdum augue, sit amet vestibulum magna egestas sed. Aenean ac erat nisi. Etiam hendrerit semper orci et pulvinar. Etiam venenatis posuere sem vitae dignissim. Duis pharetra faucibus hendrerit.

Pellentesque odio arcu, tincidunt eget est ut, sodales viverra massa. Nulla non lacus ante. Suspendisse tristique libero orci, venenatis dapibus ex pretium eu. Donec pharetra erat tristique, sodales erat vel, sagittis mi. Integer vestibulum eu lorem sit amet malesuada. Fusce condimentum condimentum augue, ut convallis justo sagittis quis. Ut efficitur nunc id porttitor consequat.

Mauris id mauris tincidunt, euismod orci sed, consequat diam. Nullam a lacus orci. In ac justo consectetur, bibendum nulla sed, maximus sem. Aliquam scelerisque nulla viverra dui dignissim, sit amet congue nisl tincidunt. Cras ac lacus vel tortor aliquam auctor quis in tellus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nam vulputate sed eros vel sagittis. Suspendisse potenti. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos.</p>
        </div>    
</section>
</body>
<?php include("footer.php"); ?>
</html>