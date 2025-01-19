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
      <h1 class="w3-text-teal">Trojparametrová analýza</h1>
      
      <img src="kocka_data_troj.png" alt="Trojparametrová analýza - kocka">
      <br><br>
      
<?php
include ("config.php");   
$var = mysqli_connect("$localhost","$user","$password","$db") or die ("connect error");

$sql1 = "select rok as Rok from TF3 group by rok order by rok";

$r = mysqli_query($var,$sql1) or die ("registration error");

while($row = mysqli_fetch_assoc($r)){
  $arrayFirstDim[] = $row;
}

$sql2 = "select ID_vuc as VUC from TF3 group by ID_vuc order by ID_vuc";

$r2 = mysqli_query($var,$sql2) or die ("registration error");

while($row = mysqli_fetch_assoc($r2)){
  $arraySecondDim[] = $row;
}

$sql3 = "select ID_S as ID_S from TF3 group by ID_S order by ID_S";

$r3 = mysqli_query($var,$sql3) or die ("registration error");

while($row = mysqli_fetch_assoc($r3)){
  $arrayThirdDim[] = $row;
}

$maxiSpolu = 0;
$arraySuma = array();
$i="0";

foreach($arrayThirdDim as $third){
    $maxiSpolu = 0;
    $arraySuma = array();
    echo "<b>ID skupina " . $third['ID_S'] . "</b>";
echo "<table border='1' cellpadding='0' cellspacing='150' style='border-collapse: collapse' bordercolor='#111111' width='1200'>";
    echo "<tr>";
    echo "<th width='150'bgcolor='#BCBBF2' height='32'>Roky</th>";
    foreach($arrayFirstDim as $first){
        echo "<th width='150'bgcolor='#BCBBF2' height='32'>".$first['Rok']."</th>";
    }
    echo "<th width='150'bgcolor='#BBF2E8' height='32'>Spolu</th>";

    "</tr>";
foreach($arraySecondDim as $second){
    echo "<tr>";
    $riadok = $second['VUC'];
    echo "<td width='150'bgcolor='#C9DBF2' height='32'><b> ".$riadok."</b> </b></td>";
    $spolu = 0;
    $i = 0;
    foreach($arrayFirstDim as $first){
        $sql3 = "select sum(prijem) res from TF3 where ID_S = '".$third['ID_S']."' and rok = '".$first['Rok']."' and ID_vuc = '".$second['VUC']."'";
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
echo "<br><br>";
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
