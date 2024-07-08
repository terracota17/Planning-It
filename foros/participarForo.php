<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/utils.php';

$idForo= filter_input(INPUT_POST,'idForo',FILTER_SANITIZE_NUMBER_INT);
es\ucm\fdi\aw\Participantes::participar($idForo, $_SESSION['id']);
header('Location: listarForos.php');

