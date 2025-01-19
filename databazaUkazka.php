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
      <h1 class="w3-text-teal">Databáza ukážka</h1>
      
      
     <form action="/databazaUkazka.php">
<label for="entita">Entita :</label>
<select name="entita" id="entita">
    <option value="GK" <?php if ($_GET['entita'] == "GK") { echo ' selected="selected"'; } ?>>Grafické karty</option>
    <option value="Komponent" <?php if ($_GET['entita'] == "Komponent") { echo ' selected="selected"'; } ?>>Komponenty</option>
</select>
<br><br>
<label for="parameter">Parameter :</label>
<select name="parameter" id="parameter">
    <option value="Mnozstvo" <?php if ($_GET['parameter'] == "Mnozstvo") { echo ' selected="selected"'; } ?>>Mnozstvo</option>
    <option value="Cena_Kus" <?php if ($_GET['parameter'] == "Cena_Kus") { echo ' selected="selected"'; } ?>>Cena za kus</option>
</select>
<br><br>
Min: 
<input type="number" id="min" name="min" min="0" value="<?php if ($_GET['min'] != null){ echo $_GET['min']; } else { echo 0;}?>">
Max: 
<input type="number" id="max" name="max" min="0" value="<?php if ($_GET['max'] != null){ echo $_GET['max']; } else { echo 1;}?>">
<br><br>
  <input type="submit" value="Vypíš údaje">
</form>
<br>

<?php
$ent =$_GET["entita"]; 
if ($ent != null){

$p = $_GET["parameter"];
$min = $_GET["min"];
$max = $_GET["max"];

include ("config.php");  
$var = mysqli_connect("$localhost","$user","$password","$db") or die ("connect error");
$sql = "select ID, Nazov, $p from $ent where $p >= $min and $p <= $max";
$res = mysqli_query($var,$sql) or die ("registration error");

if (mysqli_num_rows($res) == 0) {
    echo "0 výsledkov";
} else {

$i="0";
echo "<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='700'>";
    echo "<tr>";
    echo "<th width='150'bgcolor='#BCBBF2' height='32'>".'ID'."</th>";
    echo "<th width='150'bgcolor='#BCBBF2' height='32'>".'Nazov'."</th>";
    echo "<th width='150'bgcolor='#BCBBF2' height='32'>".$p."</th>";
    echo "</tr>";
while($row = mysqli_fetch_assoc($res))
{ 
	$prvy = $row['ID'];
    $druhy = $row['Nazov'];
    $treti = $row[$p];
	  echo "<tr>
    <td width='100'bgcolor='#6BD9F2' height='32'> ".$prvy."</b></td>
    <td width='100'bgcolor='#C9DBF2' height='32'> ".$druhy." </b></td>
    <td width='100'bgcolor='#BBF2E8' height='32'> ".$treti." </b></td>
   </tr>    
  <tr>
    <td width='100'bgcolor='#000000' height='2'></td>
    <td width='100'bgcolor='#000000' height='2'></td> 
    <td width='100'bgcolor='#000000' height='2'></td> 
    </tr>";
  }
   echo "</table>";
}
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
