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
  <h3>Dodawanie nowych użytkowników.</h3>
</div>

<!-- Container (About Section) -->
<div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
        <h4>Dodaj użytkownika</h4>
        <h2></h2>
        <form action='film_useradd.php#about' method='post'>
            <br>
            <p>Podaj nowy login: <input name="login" type="text"/></p>
            <p>Podaj nowe hasło: <input name="pass" type="password"/></p>
            <input type='submit' name='add_button' value='Dodaj użytkownika' id='submit'>
        </form>
        
        <?php //isset($_GET['log_button']) &&
        if (isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['add_button'])) {
            $new_user = $_POST['login'];
            $new_pass = $_POST['pass'];

            require_once('connectBD.php');
            // Check connection
            if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
            }

            // "DODAWANIE UZYTKOWNIKA"
            if (true){
                $q = "INSERT INTO uzytkownicy (nazwa, pass) VALUES ('".$new_user."', '".$new_pass."')";
                $r = @mysqli_query($conn, $q);
                if ($r) {
                    echo "<h4>Pomyślnie dodano użytkownika ".$new_user."!</h4>";
                    echo "<p><a href='film_show.php#about'>Przejdź do wyświetlania filmów</a></p>";
                }
                else {
                    echo "Error" . mysqli_error($conn);
                }
            }
        }   
        ?> 
    <div class="col-sm-4">
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
