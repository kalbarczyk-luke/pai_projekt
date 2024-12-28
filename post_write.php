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
  <h1>Napisz post</h1>
  <h3>Elementy CMS - dodawanie postów (zdjęcie+tekst).</h3>
</div>

<div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
        <h4>Dodawanie posta</h4>

        <h2></h2>
        <form action="post_write.php#about" method="post" enctype="multipart/form-data">
            <p>Podaj login: <input name="login" type="text"/></p>
            <p>Podaj hasło: <input name="pass" type="password"/></p>

            <input type="file" name="fileIMG" id="fileIMG" accept="image/jpeg, image/png, image/jpg" />
            <!-- <input type="text" name="userText" id="userText" /><br> -->
            <textarea id="userText" name="userText" maxlength="65535" rows="4" cols="50"></textarea>
            <button type="submit" name="upload" id="submitIMG">Dodaj</button>
        </form>
        <h2></h2>
        <?php
        if (isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['upload'])) {
            $user = $_POST['login'];
            $pass = $_POST['pass'];
            if ($user == "admin") {
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
                      echo "<p id='error'>Podano błędne hasło!</p>";
                      $logged_in = false;
                  }
              } else {
                  echo "<p id='error'>Uzytkownik o podanej nazwie nie istnieje!</p>";
                  $logged_in = false;
              }
            } else {
              echo "<p id='error'>Tylko admin może dodawać posty!</p>";
              $logged_in = false;
            }

            // JEŚLI ZALOGOWANY
            if ($logged_in == true) {
                // Sprawdzanie, czy plik został przesłany
                if (isset($_FILES['fileIMG']) && $_FILES['fileIMG']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'img/uploads/'; // Katalog docelowy
                    $uploadFile = $uploadDir . basename($_FILES['fileIMG']['name']);

                    // Sprawdzanie, czy plik jest obrazem
                    $fileType = mime_content_type($_FILES['fileIMG']['tmp_name']);
                    if (in_array($fileType, ['image/jpeg', 'image/png', 'image/jpg'])) {
                        // Przeniesienie pliku do docelowego katalogu
                        if (move_uploaded_file($_FILES['fileIMG']['tmp_name'], $uploadFile)) {
                            echo "<div class='google-maps'>";
                            echo "<a href='".$uploadFile."' data-lightbox='mygallery' data-title='Nowy obrazek'><img src='".$uploadFile."' alt='kotek' class='thumbnail'></a>";
                            echo "</div>";
                            $title = "post_".date('Y-m-d_H:i:s');
                            $userText = trim($_POST['userText']); // Usuń białe znaki z początku i końca
                            if (!empty($userText)) {
                                // Zabezpieczenie przed atakami XSS, konwertując znaki (np. <, >, &) na ich odpowiedniki HTML.
                                $safeText = htmlspecialchars($userText, ENT_QUOTES, 'UTF-8');
                                echo "<p>$safeText</p>";
                            } else {
                                echo "<p>Proszę wpisać jakiś tekst.</p>";
                            }
                            $q = "INSERT INTO posty (user_id, nazwa, img_dir, tekst) VALUES (".$read_user_id.", '".$title."', '".$uploadFile."', '".$safeText."')";
                            $r = @mysqli_query($conn, $q);
                            if ($r) {
                                echo "<h4>Pomyślnie dodano ".$title."!</h4>";
                            }
                            else {
                                echo "Error" . mysqli_error($conn);
                            }
                        } else {
                            echo "<p id='error'>[BŁĄD] Wystąpił problem podczas przesyłania pliku.</p>";
                        }
                    } else {
                        echo "<p id='error'>[BŁĄD] Nieprawidłowy format pliku. Wybierz plik JPG lub PNG.</p>";
                    }
                } else {
                    echo "<p id='error'>[BŁĄD] Nie wybrano pliku lub wystąpił błąd.</p>";
                }
            }
        }
        ?>
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
