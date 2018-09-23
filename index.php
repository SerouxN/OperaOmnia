<!DOCTYPE html>
<html>
  <head>
    <title>Opera Omnia</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width" />
    <meta charset="utf-8"/>
  </head>
  <body class='home'>
    <header>
      <?php include("header.php"); ?>
    </header>
    <div class="slideshow-container">
      <div class="mySlides fade">
        <div class="numbertext">1 / 3</div>
        <img src="images/slideshow/background.png" style="width:100%">
        <div class="text">From the greatest the History of Science</div>
      </div>
      <div class="mySlides fade">
        <div class="numbertext">2 / 3</div>
        <img src="images/slideshow/background2.png" style="width:100%">
        <div class="text">The Papers that made Physics and Mathematics</div>
      </div>
      <div class="mySlides fade">
        <div class="numbertext">3 / 3</div>
        <img src="images/slideshow/background3.png" style="width:100%">
        <div class="text">The Books that made Physics and Mathematics</div>
      </div>
      <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
      <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    <br />
    <div style="text-align:center">
      <span class="dot" onclick="currentSlide(1)"></span> 
      <span class="dot" onclick="currentSlide(2)"></span> 
      <span class="dot" onclick="currentSlide(3)"></span> 
    </div>
    <div class='titleHome'>
      Opera Omnia
    </div>
    <p style ="margin-left: 5px; margin-right:5px;"> A small index for very great scientific papers. </p>
    <section>
      <div class="menuSubject" style="margin: auto;">
        <div class = "lastPapers"><strong>Last Papers added</strong></div>
        <?php
          try
          {
            $bdd = new PDO('mysql:host=localhost;dbname=opera omnia;charset=utf8', 'root', '');	
          }
          catch(Exception $e)
          {
              die('Erreur : '.$e->getMessage());
          }        
          $reponse = $bdd->query('SELECT * FROM papers ORDER BY ID DESC');
          echo ('<div class=\'lastPaper\'/>');
          while ($data = $reponse->fetch())
          {
            $AuthID=$data['AuthorID'];
            $reponse2 = $bdd->query('SELECT * FROM authors WHERE ID= '.$AuthID);
          while ($data2 = $reponse2->fetch())
          {
            $FirstName=$data2['FirstName'];
            $LastName=$data2['LastName'];
          }
              echo ('<ul> <li class="lastPaper"> <a id="lastPaperLink" href=paper.php?id='.$data['ID'].'>'.$data['Title'].' by <strong>'.$FirstName.' '.$LastName.'</strong></a></li> </ul>');
          }
          echo '</div>'
        ?>
      </div>
    </section>
    <?php include("footer.php"); ?>
    <script>
    var slideIndex = 1;
    showSlides(slideIndex);
    function plusSlides(n) 
    {
      showSlides(slideIndex += n);
    }
    function currentSlide(n) 
    {
      showSlides(slideIndex = n);
    }
    function showSlides(n) 
    {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      if (n > slides.length) {slideIndex = 1} 
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) 
      {
          slides[i].style.display = "none"; 
      }
      for (i = 0; i < dots.length; i++) 
      {
          dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block"; 
      dots[slideIndex-1].className += " active";
    }
    </script>
  </body>
</html>