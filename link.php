<meta charset="utf-8">
<link rel="icon" type="image/png" href="../logo1/logo1_noir_decalque.png">
<?php 
if (isset($_SESSION['id']))
	$moi = new Personne ($_SESSION['id'],$bdd);

if (isset($moi) && $moi->getStyle() == 2){
?>
<link rel="stylesheet" href="IO2_style2.css">

<?php } else { ?>
<link rel="stylesheet" href="IO2_style1.css">
<?php } ?>