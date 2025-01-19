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
      <h1 class="w3-text-teal">Dvojparametrová analýza</h1>
      
<form action="/dvojA.php">
<label for="velicina">Sledovaná veličina :</label>
  <select name="velicina" id="velicina">
    <option value="prijem" <?php if ($_GET['velicina'] == "prijem") { echo ' selected="selected"'; } ?>>Príjem</option>
    <option value="naklad" <?php if ($_GET['velicina'] == "naklad") { echo ' selected="selected"'; } ?>>Náklad</option>
    <option value="Mnozstvo" <?php if ($_GET['velicina'] == "Mnozstvo") { echo ' selected="selected"'; } ?>>Množstvo</option>
  </select>
  <br><br>
  <label for="dimenzia1">Sledovaná dimenzia 1 :</label>
  <select name="dimenzia1" id="dimenzia1">
<option value="cas" <?php if ($_GET['dimenzia1'] == "cas") { echo ' selected="selected"'; } ?>>Čas</option>
    <option value="priestor" <?php if ($_GET['dimenzia1'] == "priestor") { echo ' selected="selected"'; } ?>>Priestor</option>
    <option value="produkt" <?php if ($_GET['dimenzia1'] == "produkt") { echo ' selected="selected"'; } ?>>Produkt</option>
  </select>
  <br><br>
    <label for="dimenzia2">Sledovaná dimenzia 2 :</label>
  <select name="dimenzia2" id="dimenzia2">
    <option value="cas" <?php if ($_GET['dimenzia2'] == "cas") { echo ' selected="selected"'; } ?>>Čas</option>
    <option value="priestor" <?php if ($_GET['dimenzia2'] == "priestor") { echo ' selected="selected"'; } ?>>Priestor</option>
    <option value="produkt" <?php if ($_GET['dimenzia2'] == "produkt") { echo ' selected="selected"'; } ?>>Produkt</option>
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
$dim1 =$_GET["dimenzia1"]; 
$dim2 =$_GET["dimenzia2"]; 
$vel = $_GET["velicina"]; 
$sql1 = "";

if ($dim1 == $dim2){
    echo "Dimenzie musia byť odlišné";
} else {

$ur =$_GET["uroven"]; 

if ($ur == 1){
    if ($dim1 == "cas"){
        $x1 = 'rok';
    } elseif ($dim1 == "priestor"){
        $x1 = 'ID_vuc';
    } else {
        $x1 = 'ID_S';
    }
    if ($dim2 == "cas"){
        $x2 = 'rok';
        $nazov_stlpec = "Roky - ";
    } elseif ($dim2 == "priestor"){
        $x2 = 'ID_vuc';
        $nazov_stlpec = "VUC - ";
    } else {
        $x2 = 'ID_S';
        $nazov_stlpec = "Skupina - ";
    }
} elseif ($ur == 2){
    if ($dim1 == "cas"){
        $x1 = 'mesiac';
    } elseif ($dim1 == "priestor"){
        $x1 = 'ID_okr';
    } else {
        $x1 = 'ID_T';
    }
    if ($dim2 == "cas"){
        $x2 = 'mesiac';
        $nazov_stlpec = "Mesiac - ";
    } elseif ($dim2 == "priestor"){
        $x2 = 'ID_okr';
        $nazov_stlpec = "Okres - ";
    } else {
        $x2 = 'ID_T';
        $nazov_stlpec = "Typ - ";
    }
} else {
    if ($dim1 == "cas"){
        $x1 = 'den';
    } elseif ($dim1 == "priestor"){
        $x1 = 'Mesto';
    } else {
        $x1 = 'ID_GK';
    }
    if ($dim2 == "cas"){
        $x2 = 'den';
        $nazov_stlpec = "Dni - ";
    } elseif ($dim2 == "priestor"){
        $x2 = 'Mesto';
        $nazov_stlpec = "Mesto - ";
    } else {
        $x2 = 'ID_GK';
        $nazov_stlpec = "Výrobok - ";
    }
}

$sql1 = "select $x1 as res1 from TF3 group by $x1 order by $x1";

$sql2 = "select $x2 as res2 from TF3 group by $x2 order by $x2";


if ($vel == "prijem"){
    $nazov_stlpec = $nazov_stlpec . "príjem";
} elseif ($vel == "naklad") {
    $nazov_stlpec = $nazov_stlpec . "náklad";
} else {
    $nazov_stlpec = $nazov_stlpec . "množstvo";
}

$r = mysqli_query($var,$sql1) or die ("registration error");

while($row = mysqli_fetch_assoc($r)){
  $arrayFirstDim[] = $row;
}

$r2 = mysqli_query($var,$sql2) or die ("registration error");

while($row = mysqli_fetch_assoc($r2)){
  $arraySecondDim[] = $row;
}

$maxiSpolu = 0;
$arraySuma = array();
$i="0";

echo "<table border='1' cellpadding='0' cellspacing='150' style='border-collapse: collapse' bordercolor='#111111' width='1200'>";
    echo "<tr>";
    echo "<th width='150'bgcolor='#BCBBF2' height='32'>".$nazov_stlpec."</th>";
    foreach($arrayFirstDim as $first){
        echo "<th width='150'bgcolor='#BCBBF2' height='32'>".$first['res1']."</th>";
    }
    echo "<th width='150'bgcolor='#BBF2E8' height='32'>Spolu</th>";

    "</tr>";
foreach($arraySecondDim as $second){
    echo "<tr>";
    $riadok = $second['res2'];
    echo "<td width='150'bgcolor='#C9DBF2' height='32'><b> ".$riadok."</b> </b></td>";
    $spolu = 0;
    $i = 0;
    foreach($arrayFirstDim as $first){
        $sql3 = "select sum($vel) res from TF3 where $x1 = '".$first['res1']."' and $x2 = '".$second['res2']."'";
        $r3 = mysqli_query($var,$sql3) or die ("registration error");
        echo " ";
        $temp = mysqli_fetch_array($r3)['res'];
        if ($temp == null){
            $temp = 0;
        }
        $spolu += $temp;
        echo "<td width='150'bgcolor='#F2DAD8' height='32'> ".$temp."</b></td>";
        $arraySuma[$i] = $arraySuma[$i] + $temp;
        $i += 1;
    }
    $maxiSpolu += $spolu;
    echo "<td width='150'bgcolor='#BBF2E8' height='32'>$spolu</b></td>";
    echo "</tr>";
}
echo "<td width='150'bgcolor='#BBF2E8' height='32'><b>Suma</b></b></td>";

foreach($arraySuma as $sum){
    echo "<td width='150'bgcolor='#BBF2E8' height='32'>$sum</b></td>";
}
echo "<td width='150'bgcolor='#6BD9F2' height='32'>$maxiSpolu</b></td>";

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
