<header>
    <div id="titleDiv">
        <h1 id="bigTitle">OPERA OMNIA</h1>
    </div>
    <nav id="navbar" class="topnav">
        <ul style="list-style-type:none">
            <li><a href="operaomnia.php" id="home">Home</a></li>
            <li><a href="subjects.php">Subjects</a></li>
            <li><a href="authors.php">Authors</a></li>
            <li><a href="papers.php">Papers</a></li>
            <li><a href="submit.php" id="submit">Submit a Paper</a></li>
            <li class="icon"><a href="javascript:void(0);" onclick="dropdown()">&#9776;</a></li>
        </ul>
    </nav>
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
        function dropdown() {
            var x = document.getElementById("navbar");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
             x.className = "topnav";
        }
}
    </script>
</header>