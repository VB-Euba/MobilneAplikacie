<!DOCTYPE html>
<html lang="en">
<head>
<title>DBS Stránka</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
.w3-sidebar {
  z-index: 3;
  width: 250px;
  top: 43px;
  bottom: 0;
  height: inherit;
}
.hidden {
  display: none;
}
.container {
  max-width: 400px;
  margin: left;
}
label {
  display: block;
  margin: 10px 0 5px;
}
input {
  width: 100%;
  padding: 8px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
button {
  padding: 10px 15px;
  background-color: #007BFF;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
button:hover {
  background-color: #0056b3;
}
.small-text {
  font-size: 0.9em;
  text-align: left;
  margin-top: -10px;
  margin-bottom: 20px;
  color: #007BFF;
  cursor: pointer;
}
</style>
</head>
<body>

<?php
session_start();
include("config.php");

function loginUser($username, $password) {
    global $var;
    $query = "SELECT * FROM Pouzivatel WHERE Meno = ? AND Heslo = ?";
    $stmt = mysqli_prepare($var, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['username'] = $username;
        return true;
    }
    return false;
}

function registerUser($username, $password) {
    global $var;
    $checkQuery = "SELECT * FROM Pouzivatel WHERE Meno = ?";
    $stmt = mysqli_prepare($var, $checkQuery);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        return false; // Používateľ už existuje
    }

    $insertQuery = "INSERT INTO Pouzivatel (ID, Meno, Heslo) VALUES (NULL, ?, ?)";
    $stmt = mysqli_prepare($var, $insertQuery);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);

    $_SESSION['isLoggedIn'] = true;
    $_SESSION['username'] = $username;
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'login') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (loginUser($username, $password)) {
                echo "<script>alert('Úspešné prihlásenie!');</script>";
            } else {
                echo "<script>alert('Nesprávne prihlasovacie údaje!');</script>";
            }
        } elseif ($_POST['action'] === 'register') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (registerUser($username, $password)) {
                echo "<script>alert('Úspešná registrácia!');</script>";
            } else {
                echo "<script>alert('Používateľ už existuje!');</script>";
            }
        }
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    <a href="index.html" class="w3-bar-item w3-button w3-theme-l1">Úvod</a>
    <a href="databazaUkazka.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Databáza ukážka</a>
    <a href="kontakt.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Kontakt</a>
	<a href="ucet.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Účet</a>
  </div>
</div>

<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <h4 class="w3-bar-item"><b>Analýza</b></h4>
  <a class="w3-bar-item w3-button w3-hover-black" href="jednoA.php">Jednoparametrová</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="dvojA.php">Dvojparametrová</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="trojA.php">Trojparametrová</a>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Odkazy na zadania</h1>

      <!-- Prihlasovacie a registračné okno -->
      <div class="container">
          <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true): ?>
          <div id="user-panel">
              <h2>Vitajte, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
              <form method="post">
                  <button type="submit" name="logout">Odhlásiť sa</button>
              </form>
          </div>
          <?php else: ?>
          <div id="login-form">
              <h2>Prihlásenie</h2>
              <form method="post">
                  <label for="username">Prihlasovacie meno:</label>
                  <input type="text" id="username" name="username" placeholder="Zadajte meno" required>

                  <label for="password">Heslo:</label>
                  <input type="password" id="password" name="password" placeholder="Zadajte heslo" required>

                  <button type="submit" name="action" value="login">Prihlásiť sa</button>
              </form>
              <br>
              <div class="small-text" onclick="showRegisterForm()">Nemáte účet? Zaregistrujte sa.</div>
          </div>

          <div id="register-form" class="hidden">
              <h2>Registrácia</h2>
              <form method="post">
                  <label for="reg-username">Prihlasovacie meno:</label>
                  <input type="text" id="reg-username" name="username" placeholder="Zadajte meno" required>

                  <label for="reg-password">Heslo:</label>
                  <input type="password" id="reg-password" name="password" placeholder="Zadajte heslo" required>

                  <button type="submit" name="action" value="register">Registrovať</button>
              </form>
			  <br>
              <div class="small-text" onclick="showLoginForm()">Máte účet? Prihláste sa.</div>
          </div>
          <?php endif; ?>
      </div>
    </div>
  </div>

  <footer id="myFooter">
    <div class="w3-container w3-theme-l2 w3-padding-32">
      <h4>Grafické karty BLA</h4>
    </div>

    <div class="w3-container w3-theme-l1">
      <p>Vladimír Bencz, Ján Pittner, 2024/2025</p>
    </div>
  </footer>

<!-- END MAIN -->
</div>

<script>
function showRegisterForm() {
    document.getElementById('login-form').classList.add('hidden');
    document.getElementById('register-form').classList.remove('hidden');
}

function showLoginForm() {
    document.getElementById('register-form').classList.add('hidden');
    document.getElementById('login-form').classList.remove('hidden');
}
</script>

</body>
</html>
