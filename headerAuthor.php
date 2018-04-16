<<<<<<< HEAD
<header>
    <nav id="navbar">
        <ul style="list-style-type:none">
            <li><a href="operaomnia.php" id="home">Home</a></li>
            <li><a href="subjects.php">Subjects</a></li>
            <li><a href="authors.php?sorting=Name&order=+#">Authors</a></li>
            <li><a href="papers.php">Papers</a></li>
            <li><a href="submit.php" id="submit">Submit a Paper</a></li>
        </ul>
    </nav>
    <div>
    <img id="banner" src="banners/<?php echo $_GET['authid']?>.png" onerror="if (this.src != 'banners/default.png') this.src = 'banners/default.png';">
   
    </div>
    <script>
        window.onscroll = function() {myFunction()};

        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;

        function myFunction() 
        {
            if (window.pageYOffset >= sticky) 
            {
                navbar.classList.add("sticky")
            } 
            else 
            {
                navbar.classList.remove("sticky");
            }
        }
    </script>
=======
<header>
    <nav id="navbar">
        <ul style="list-style-type:none">
            <li><a href="operaomnia.php" id="home">Home</a></li>
            <li><a href="subjects.php">Subjects</a></li>
            <li><a href="authors.php?sorting=Name&order=+#">Authors</a></li>
            <li><a href="papers.php">Papers</a></li>
            <li><a href="submit.php" id="submit">Submit a Paper</a></li>
        </ul>
    </nav>
    <div>
    <img id="banner" src="banners/<?php echo $_GET['authid']?>.png" onerror="if (this.src != 'banners/default.png') this.src = 'banners/default.png';">
   
    </div>
    <script>
        window.onscroll = function() {myFunction()};

        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;

        function myFunction() 
        {
            if (window.pageYOffset >= sticky) 
            {
                navbar.classList.add("sticky")
            } 
            else 
            {
                navbar.classList.remove("sticky");
            }
        }
    </script>
>>>>>>> 692cc8af0adc95b649212ed7af4961f6b4c1b07e
</header>