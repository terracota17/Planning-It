<?php
    use es\ucm\fdi\aw\Imagen as Imagen;

    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/utils.php';

    $conn = es\ucm\fdi\aw\Aplicacion::getInstance()->getConexionBd();

    $idEvento = filter_input(INPUT_POST,'idEv',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $statusMsg = '';
    $targetDir = "../uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
        $allowTypes = array('JPG', 'jpg', 'png','jpeg','gif','pdf');
        if(in_array($fileType, $allowTypes)) {
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                Imagen::insertarImagenEvento($idEvento, $fileName);

            }
        }
    }

    header("Location: listarEventos.php");
    exit();
?>
