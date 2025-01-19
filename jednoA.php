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
</style>
</head>
<body>

<?php include('prihlasenieCheck.php'); ?>

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
      <h1 class="w3-text-teal">Jednoparametrová analýza</h1>
      
<form action="/jednoA.php">
    <label for="velicina">Sledovaná veličina :</label>
  <select name="velicina" id="velicina">
    <option value="prijem" <?php if ($_GET['velicina'] == "prijem") { echo ' selected="selected"'; } ?>>Príjem</option>
    <option value="naklad" <?php if ($_GET['velicina'] == "naklad") { echo ' selected="selected"'; } ?>>Náklad</option>
    <option value="Mnozstvo" <?php if ($_GET['velicina'] == "Mnozstvo") { echo ' selected="selected"'; } ?>>Množstvo</option>
  </select>
  <br><br>
  <label for="dimenzia">Sledovaná dimenzia :</label>
  <select name="dimenzia" id="dimenzia">
<option value="cas" <?php if ($_GET['dimenzia'] == "cas") { echo ' selected="selected"'; } ?>>Čas</option>
    <option value="priestor" <?php if ($_GET['dimenzia'] == "priestor") { echo ' selected="selected"'; } ?>>Priestor</option>
    <option value="produkt" <?php if ($_GET['dimenzia'] == "produkt") { echo ' selected="selected"'; } ?>>Produkt</option>
  </select>
  <br><br>
<label for="uroven">Sledovaná úroveň :</label>
  <select name="uroven" id="uroven">
    <option value="1" <?php if ($_GET['uroven'] == 1) { echo ' selected="selected"'; } ?>>1</option>
    <option value="2" <?php if ($_GET['uroven'] == 2) { echo ' selected="selected"'; } ?>>2</option>
    <option value="3" <?php if ($_GET['uroven'] == 3) { echo ' selected="selected"'; } ?>>3</option>
</select>
  <br><br>
  <input type="submit" value="Spustit analyzu">
</form>
<br>

<?php
include ("config.php");   
$var = mysqli_connect("$localhost","$user","$password","$db") or die ("connect error");

$dim =$_GET["dimenzia"]; 
$ur =$_GET["uroven"]; 
$vel = $_GET["velicina"]; 
$druhy_stlpec = "";

if ($dim != null){

if ($ur == 1){
    if ($dim == "cas"){
        $x = 'rok';
        $druhy_stlpec = "Rok - ";
    } elseif ($dim == "priestor"){
        $x = 'ID_vuc';
        $druhy_stlpec = "VUC - ";
    } else {
        $x = 'ID_S';
        $druhy_stlpec = "Skupina - ";
    }
} elseif ($ur == 2){
    if ($dim == "cas"){
        $x = 'mesiac';
        $druhy_stlpec = "Mesiac - ";

    } elseif ($dim == "priestor"){
        $x = 'ID_okr';
        $druhy_stlpec = "Okres - ";
    } else {
        $x = 'ID_T';
        $druhy_stlpec = "Typ - ";
    }
} else {
    if ($dim == "cas"){
        $x = 'den';
        $druhy_stlpec = "Dni - ";
    } elseif ($dim == "priestor"){
        $x = 'Mesto';
        $druhy_stlpec = "Mesto - ";
    } else {
        $x = 'ID_GK';
        $druhy_stlpec = "Výrobok - ";
    }
}

if ($vel == "prijem"){
    $druhy_stlpec = $druhy_stlpec . "príjem";
} elseif ($vel == "naklad") {
    $druhy_stlpec = $druhy_stlpec . "náklad";
} else {
    $druhy_stlpec = $druhy_stlpec . "množstvo";
}

$sql = "select $x,sum($vel) result from TF3 group by $x order by $x";


$res = mysqli_query($var,$sql) or die ("registration error");

echo "<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='700'>";
    echo "<tr>";
    echo "<th width='150'bgcolor='#BCBBF2' height='32'>".$x."</th>";
    echo "<th width='150'bgcolor='#BCBBF2' height='32'>".$druhy_stlpec."</th>";
    echo "</tr>";
while($row = mysqli_fetch_assoc($res))
{ 
    $prvy = $row[$x];
    $druhy = $row['result'];
    echo "<tr>
    <td width='100'bgcolor='#BBF2E8' height='32'> ".$prvy."</b></td>
    <td width='100'bgcolor='#C9DBF2' height='32'> ".$druhy." </b></td>
   </tr>";
  }
   echo "</table>";
}
?>
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
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>

</body>
</html>
