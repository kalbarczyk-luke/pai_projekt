<!DOCTYPE html>
<html lang="pl">
<head>
  <!-- Theme Inspired By www.w3schools.com -->
  <title>PAI - PROJEKT</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="lightbox-plus-jquery.js"></script>
  <script type="text/javascript" src="main.js"></script>
  <link rel="stylesheet" href="lightbox.css" type="text/css">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="filmstyles.css">
  <link rel="icon" type="image/x-icon" href="img/kotek.gif">
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.html"><span class="glyphicon glyphicon-home"></span> Home</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a class="navbar-brand" href="galeria.html"><span class="glyphicon glyphicon-picture"></span> Galeria</a></li>  
        <li class="dropdown">
            <a class="navbar-brand" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-facetime-video"></span> Filmy<span class="carret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="film_show.php">Filmy</a></li>
                <li><a href="film_add.php">Dodaj film</a></li>
                <li><a href="film_delete.php">Usuń film</a></li>
                <li><a href="film_useradd.php">Dodaj użytkownika</a></li>
            </ul>
        </li>
        <li><a class="navbar-brand" href="post_write.php"><span class="glyphicon glyphicon-pencil"></span> Skryba</a></li>  
        <li><a class="navbar-brand" href="post_read.php"><span class="glyphicon glyphicon-book"></span> Posty</a></li>  
        <li><a class="navbar-brand" href="https://tictactoe9x9-4b12b.web.app/" target="_blank"><span class="glyphicon glyphicon-th"></span> Gra</a></li>  
        <li><a class="navbar-brand" href="#contact"><span class="glyphicon glyphicon-envelope"></span> Kontakt</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>Baza danych z filmami</h1>
  <h3>Wyświetlanie filmów dodanych przez użytkownika.</h3>
</div>

<!-- Container (About Section) -->
<div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
        <h4>Twoje filmy - Logowanie</h4>
        <h2></h2>
        <form action="film_show.php#about" method="get">
            <p>Podaj login: <input name="login" type="text"/></p>
            <p>Podaj hasło: <input name="pass" type="password"/></p> 
            <input type="submit" name="show_button" value="Zaloguj się i pokaż filmy" id="submit">
        </form>
</div>  
<div class="col-sm-8">  
        <?php
        if (isset($_GET['show_button']) && isset($_GET['login']) && isset($_GET['pass'])) { 
            $user = $_GET['login'];
            $pass = $_GET['pass'];

            require_once('connectBD.php');
            // Check connection
            if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
            }
            // "LOGOWANIE"
            $q = "SELECT * FROM uzytkownicy WHERE nazwa='" . $user . "'";
            $r = @mysqli_query($conn, $q);
            if (mysqli_num_rows($r) > 0) {
                while($row = mysqli_fetch_array($r)) {
                    $read_pass = $row['pass'];
                    $read_user_id = $row['id'];
                }
                if ($pass == $read_pass){
                    echo "<h4>Zalogowano jako ".$user."</h4>";
                    $logged_in = true;
                } else {
                    echo "<h4>Podano błędne hasło!</h4>";
                    $logged_in = false;
                }
            } else {
                echo "<h4>Uzytkownik o podanej nazwie nie istnieje!</h4>";
                $logged_in = false;
            }

            // "WYSWIETLANIE FILMOW" (ADMIN)
            if ($logged_in){
              if ($user == 'admin') { 
                $menu = array();
                $users = array();
                $q1 = "SELECT DISTINCT nazwa FROM uzytkownicy WHERE id!=4";
                $q2 = "SELECT u.nazwa, f.title, f.year, f.rating FROM filmy f JOIN uzytkownicy u ON f.user_id=u.id WHERE user_id!=4 ORDER BY f.rating DESC";
                $q3 = "SELECT title, AVG(rating) AS srednia FROM filmy ORDER BY srednia DESC";
                $r1 = @mysqli_query($conn, $q1);
                $r2 = @mysqli_query($conn, $q2);
                if (mysqli_num_rows($r1) > 0) {
                  echo "<span class = 'filmdetails'>";
                  echo "<p>Dostępni użytkownicy:";
                  echo "<br><ul class='db-users'>";  
                  while($row = mysqli_fetch_array($r1)) { 
                    echo "<li>" . $row["nazwa"] . "</li>"; 
                    array_push($users, $row['nazwa']);
                  }
                  echo "</ul></p><br>";
                  echo "</span>";
                }
                if (mysqli_num_rows($r2) > 0) {
                  echo "<span class = 'filmdetails'>";
                  echo "<p>Dane wszystkich użytkowników:</p>";
                  echo "</span>";
                    while($row = mysqli_fetch_array($r2)) {
                        echo "<p>";
                        echo "<span class = 'filmtitle'>";
                        echo $row["title"] . "<br>";
                        echo "</span>";
                        echo "<span class = 'filmdetails'>";
                        echo $row["year"] . "<br>";
                        for ($x = 1; $x <= $row["rating"]; $x++) {
                          echo "<span class='glyphicon glyphicon-star gold'></span>  ";
                        }
                        echo $row["rating"] . "/5<br>";
                        echo "Użytkownik: ".$row["nazwa"];  
                        echo "</span>";
                        echo "</p><br>";
                        $linkto = "https://www.google.com/search?ie=UTF-8&q=".$row['title'];
                        $menu[$linkto] = $row['title']; // dane do dynamicznego menu link+film
                    }
                    echo "<span class = 'filmdetails'>";
                    echo "<p>Więcej o filmach użytkowników</p>";
                    echo "<ul class='details'>";
                    echo "<li class='dropdown'><a class='dropdown-toggle' data-toggle='dropdown' href='#' id='filmy'>Filmy <span class='carret'></span></a>";
                    echo "<ul class='dropdown-menu'>";
                    foreach ($menu as $key => $value):
                    echo "<li><a target=_blank href='".$key."'>".$value."</a></li>";
                    endforeach;
                    echo "</ul></li>";

                    echo "<li class='dropdown'><a class='dropdown-toggle' data-toggle='dropdown' href='#' id='users'>Dostępni użytkownicy<span class='carret'></span></a>";
                    echo "<ul class='dropdown-menu'>"; 
                    foreach ($users as $value):
                    echo "<li><p>".$value."</p></li>";
                    endforeach;
                    echo "</ul></li>";
                    echo "</ul><br><br>";
                    echo "</span>";
                } else {
                    echo "<p>Brak danych do wyświetlenia.</p>";
                }
              } else { // DISPLAY USER DATA (JESLI ZALOGOWANO JAKO nieADMIN)
                $q = "SELECT * FROM filmy WHERE user_id=" . $read_user_id;
                $r = @mysqli_query($conn, $q);
                if (mysqli_num_rows($r) > 0) {
                    echo "<br><h2>TWOJE FILMY</h2>";
                    while($row = mysqli_fetch_array($r)) {
                        echo "<br><p>";
                        echo "<span class = 'filmtitle'>";
                        echo $row["title"] . "<br>";
                        echo "</span>";
                        echo "<span class = 'filmdetails'>";
                        echo $row["year"] . "<br>";
                        for ($x = 1; $x <= $row["rating"]; $x++) {
                            echo "<span class='glyphicon glyphicon-star gold'></span>  ";
                        }
                        echo $row["rating"] . "/5<br>";
                        $linkto = "https://www.google.com/search?ie=UTF-8&q=".str_replace(' ', '+', $row['title']);
                        echo "<a target=_blank href=".$linkto.">Więcej</a>";
                        echo "</span>";
                        echo "</p>";
                    }
                } else {
                    echo "<p>Brak danych do wyświetlenia.</p>";
                }

              }
              
            }
        }
        ?> 
      </div>
      <div class="col-sm-4">
        <?php
            require_once('connectBD.php');
            // Check connection
            if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
            }
            $qq = "SELECT title, AVG(rating) AS srednia FROM filmy GROUP BY title ORDER BY srednia DESC";
            $rr = @mysqli_query($conn, $qq);
            if (mysqli_num_rows($rr) > 0) {
              echo "<br><br><br><br><h2>RANKING FILMÓW UŻYTKOWNIKÓW</h2>";
              $rank = 1 ;
              while($rrow = mysqli_fetch_array($rr)) {
                  echo "<p>";
                  echo "<span class = 'filmtitle'>";
                  echo "#". $rank . " - ". $rrow["title"] ."<br>";
                  echo "</span>";
                  echo "<span class = 'filmdetails'>";
                  echo "<p>Średnia ocen użytkowników:<br>";
                  for ($x = 1; $x <= $rrow["srednia"]; $x++) {
                      echo "<span class='glyphicon glyphicon-star gold'></span>  ";
                  }
                  if (floor( $rrow["srednia"]) != $rrow["srednia"]) {
                    echo "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' fill='gold' class='bi bi-star-half' viewBox='0 0 16 16'>
                    <path d='M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z'/>
                    </svg>";
                  }

                  echo " ".round($rrow["srednia"], 2) . "/5";
                  $linkto = "https://www.google.com/search?ie=UTF-8&q=".str_replace(' ', '+', $rrow['title']);
                  echo "<br><a target=_blank href=".$linkto.">Więcej</a></p>";
                  echo "</span>";
                  echo "</p><br>";
                  $rank = $rank + 1;
              }
          } else {
              echo "<p>Brak danych do wyświetlenia.</p>";
          }
          $conn->close();
        ?>
      </div>
  </div>
</div>

<div id="contact" class="container-fluid bg-grey">
  <h2 class="text-center">KONTAKT</h2>
  <div class="row">
    <div class="col-sm-5">
      <p><span class="glyphicon glyphicon-map-marker"></span> Gdańsk/Gdynia/Grudziądz/Wejherowo</p>
      <p><span class="glyphicon glyphicon-envelope"></span> s185662@student.pg.edu.pl</p>
      <p><span class="glyphicon glyphicon-envelope"></span> s185801@student.pg.edu.pl</p>
    </div>
    <div class="col-sm-7 slideanim">
      <div class="google-maps">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2608.489232726419!2d18.615800351979498!3d54.37642734153131!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46fd749704dcf0f3%3A0x53f69bae12ca3e75!2sMy%20Kebab!5e0!3m2!1spl!2spl!4v1734826888041!5m2!1spl!2spl" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div> 
  </div>
</div>

<footer class="container-fluid text-center footer">
  <a href="#myPage" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
  <p><b>Projekt PAI by 185662 & 185801</b></p>
  <p>Website Template Inspired By <a href="https://www.w3schools.com" title="Visit w3schools">www.w3schools.com</a></p>
</footer>

</body>
</html>
