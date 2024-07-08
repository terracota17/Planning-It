<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/utils.php';

$conn = es\ucm\fdi\aw\Aplicacion::getInstance()->getConexionBd();

$query = $conn->query("SELECT * FROM images WHERE idUsuario=".$_SESSION['id']);

if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        $imageURL = '../uploads/'.$row["file_name"];
?>
    <img src="<?php echo $imageURL; ?>" alt="" />
<?php 
    }
}
else
{ ?>
    <p>No image(s) found...</p>
<?php 
} 
?>