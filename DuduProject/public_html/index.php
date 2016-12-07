<?php
require_once '../vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array('auto_reload' => true));

$page = $_GET['page'];
$subPage = $_GET['subPage'];





switch ($page){
    case user:
        $template = $twig->loadTemplate('user.html.twig');
        break;
    case forum:
        $template = $twig->loadTemplate('forum.html.twig');
        break;
    case absence:
        $template = $twig->loadTemplate('absence.html.twig');
        break;
    default:
        $template = $twig->loadTemplate('index.html.twig');
        break;
}

    echo 'vi får se';
if(isset($_POST['submit'])){
    echo "dur";
}


echo $template->render(array('page' => $page, 'subPage' => $subPage));



?>
