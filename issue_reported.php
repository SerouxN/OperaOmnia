<!DOCTYPE html>
<html>
<head>
    <title>Opera Omnia</title>
    <link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8"/>
</head>
<header>
	<?php include("header.php"); ?>
</header>
<body>

<?php
if ($_POST['type'] == 'hack') {
    echo("Hoho, so funny (but if you really succeed in hacking our website, please let us know and tell us where the vulnerability was). Would be nice, kiss<3 ");
}
else {
if (isset($_POST['type']) && isset($_POST['description'])) 
{
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=operaomnia v2;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    catch(Exception $e)
    {
            die('Error : '.$e->getMessage());
    }
    $ID_pic = 0 ;
    if ($_FILES['imageSubmitted']['size'] != 0)
    {
        print_r($_FILES['imageSubmitted']);
        if ($_FILES['imageSubmitted']['error'] == 0 && pathinfo($_FILES['imageSubmitted']['name'])['extension'] == 'jpg'&& $_FILES['imageSubmitted']['size'] <= 10000000) 
        {
        $ID_pic = rand(0, 9999999999);
        move_uploaded_file($_FILES['imageSubmitted']['tmp_name'], 'issues/issue' .basename($ID_pic) .'.jpg ');
        }
        else 
        {
            
            echo "<section> 
            <h1>An error occured with the screenshot</h1>
                <p>Something goes wrong. Woops. <a href='http://localhost/opera_omnia/report_issue.php'>go back</a></p>
            </section>
            <div id='space'></div>";
        }

    }
        $req = $db->prepare('INSERT INTO issues(Type, Description, Date, ID_pic) VALUES(:Type, :Description, NOW(), :ID_pic) ');
        $req->execute(array(
            'Type' => htmlspecialchars($_POST['type']),
            'Description' => htmlspecialchars($_POST['description']),
            'ID_pic' => $ID_pic,
            ));
    
        echo "<section> 
        <h1>Thank you for reporting an issue.</h1>
            <p>You can now go back <a href='operaomnia.php'>home</a>. Or whatever, you do you...</p>
        </section>
        <div id='space'></div>";

}
else {
    echo "<section> 
    <h1>An error occured</h1>
        <p>Something goes wrong. Woops</p>
    </section>
    <div id='space'></div>";
    $ID_pic = 0 ; 
}

}
?> 
	<?php include("footer.php"); ?> 
</body>
</html>