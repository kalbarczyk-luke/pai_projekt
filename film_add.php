<!DOCTYPE html>
<html lang="pl">
<head>
  <!-- Theme Made By www.w3schools.com -->
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
        <!-- <li><a class="navbar-brand" href="index.html"><span class="glyphicon glyphicon-home"></span> Home</a></li> -->
        <li><a class="navbar-brand" href="galeria.html"><span class="glyphicon glyphicon-picture"></span> Galeria</a></li>  
        <li class="dropdown">
            <a class="navbar-brand" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-facetime-video"></span> Filmy<span class="carret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="film_show.php">Filmy</a></li>
                <li><a href="film_add.php">Dodaj film</a></li>
                <li><a href="film_delete.php">Usuń film</a></li>
            </ul>
        </li>
        <!-- <li><a href="#about">ABOUT</a></li>
        <li><a href="#services">SERVICES</a></li>
        <li><a href="#portfolio">PORTFOLIO</a></li>
        <li><a href="#pricing">PRICING</a></li> -->
        <li><a class="navbar-brand" href="https://tictactoe9x9-4b12b.web.app/" target="_blank"><span class="glyphicon glyphicon-th"></span> Fajna giera</a></li>  
        <li><a class="navbar-brand" href="#contact"><span class="glyphicon glyphicon-envelope"></span> Kontakt</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>Baza danych z filmami</h1>
  <h3>Dodawanie nowych filmów.</h3>
  <p>WORK IN PROGRESS</p>
</div>

<!-- Container (About Section) -->
<div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
        <h4>Dodaj film - Logowanie</h4>
        <!-- <button class="film-menu">Dodaj użytkownika</button> -->
        <h2></h2>
        <!-- <form action="film_add.php#about" method="get">
            <p>Podaj login: <input name="login" type="text"/></p>
            <p>Podaj hasło: <input name="pass" type="password"/></p>
        </form> -->
        <form action='film_add.php#about' method='post'>
            <br>
            <p>Podaj login: <input name="login" type="text"/></p>
            <p>Podaj hasło: <input name="pass" type="password"/></p>
            <p>Podaj tytuł filmu: <input name='tytul' type='text'/></p>
            <p>Podaj rok produkcji filmu: <input name='rok' type='number' min='1890' max='2050'/></p>
            <p>Jak oceniasz film (0-5): <input name='ocena' type='number' min='0' max='5'/></p>
            <input type='submit' name='add_button' value='Dodaj film' id='submit'>
        </form>
        
        <?php //isset($_GET['log_button']) &&
        if (isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['add_button']) &&  isset($_POST['rok']) && isset($_POST['tytul']) && isset($_POST['ocena'])) {
            $user = $_POST['login'];
            $pass = $_POST['pass'];
            $title = $_POST['tytul'];
            $year = $_POST['rok'];
            $rating = $_POST['ocena'];
            // echo $user . $title . $year . $rating;

            require_once('connDB.php');
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

            // "DODAWANIE FILMOW"
            if ($logged_in){
                $q = "INSERT INTO filmy (user_id, title, year, rating) VALUES (".$read_user_id.", '".$title."', ".$year.", ".$rating.")";
                $r = @mysqli_query($conn, $q);
                if ($r) {
                    echo "<h4>Pomyślnie dodano film ".$title."!</h4>";
                    echo "<p><a href='film_show.php#about'>Przejdź do wyświetlania filmów</a></p>";
                }
                else {
                    echo "Error" . mysqli_error($conn);
                }
            }
        }   
            

        
            //     // }
            //     // $q = "SELECT * FROM filmy WHERE user_id=" . $read_user_id;
            //     // $r = @mysqli_query($conn, $q);
            //     // if (mysqli_num_rows($r) > 0) {
            //     //     while($row = mysqli_fetch_array($r)) {
            //     //         echo "<br><p>";
            //     //         echo "<span class = 'filmtitle'>";
            //     //         echo $row["title"] . "<br>";
            //     //         echo "</span>";
            //     //         echo $row["year"] . "<br>";
            //     //         echo $row["rating"] . "<br>";
            //     //         echo "</p>";
            //     //     }
            //     // } else {
            //     //     echo "<p>Brak danych do wyświetlenia.</p>";
            //     // }
            //     $conn->close();
            // }
        ?> 
    <div class="col-sm-4">
    </div>
  </div>
</div>

<!-- Container (Contact Section) -->
<div id="contact" class="container-fluid bg-grey">
  <h2 class="text-center">KONTAKT</h2>
  <div class="row">
    <div class="col-sm-5">
      <p><span class="glyphicon glyphicon-map-marker"></span> Gdańsk/Gdynia/Grudziądz/Wejherowo</p>
      <p><span class="glyphicon glyphicon-envelope"></span> s185662@student.pg.edu.pl</p>
      <p><span class="glyphicon glyphicon-envelope"></span> s185801@student.pg.edu.pl</p>
    </div>
    <div class="col-sm-7 slideanim">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2608.489232726419!2d18.615800351979498!3d54.37642734153131!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46fd749704dcf0f3%3A0x53f69bae12ca3e75!2sMy%20Kebab!5e0!3m2!1spl!2spl!4v1734826888041!5m2!1spl!2spl" width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
