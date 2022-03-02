<header>
    <nav role="navigation">
        <ul>
            <li><a href="index.php?page=home">Accueil</a></li>
            <li><a href="index.php?page=inscription">Inscription</a></li>
            <li><a href="index.php?page=temoignage">Témoignage</a></li>

            <?php
                if(isset($_SESSION['login']) && $_SESSION['login'] === true) {
                    echo "<li><a href=\"index.php?page=logout\">Logout</a></li>";
                    
                }
                else {
                    echo "<li><a href=\"index.php?page=login\">Login</a></li>";
                    
                }
            ?>

        </ul>
    </nav>
</header>