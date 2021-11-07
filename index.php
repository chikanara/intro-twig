<?php
require "vendor/autoload.php";
use Michelf\MarkdownExtra;

//routing
// $page = "home";
if (isset($_GET["p"])) {
    # code...
    $page = $_GET["p"];
}
// GET ITEMS 
function tuto(){
    $pdo = new PDO('mysql:host=localhost;dbname=tuto;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $tutoriels = $pdo->query('SELECT * FROM tutoriels ORDER BY id DESC LIMIT 10');
    return $tutoriels;
}
// Render twig files
$loader = new \Twig\Loader\FilesystemLoader('./src/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
    'debug' => true
    // 'cache' => './tmp',
]);


//add customized function
// require_once Michelf\MarkdownExtra;
$function = new \Twig\TwigFunction('markdown', function ($var) {

    // return 'Salut' . $var;
    // $my_html =  MarkdownExtra::defaultTransform($var) ;
    return $var;
});
$twig->addFunction($function,['is_safe' => ['html']]);
// $twig->addFunction(new Twig_add)

$twig->addGlobal('current_page',$page);
// $twig->addExtension();

switch ($page) {
    case 'home':
        # code...
        echo $twig->render("home.twig",["tutoriels" => tuto()]);
        break;
    case 'contact':
        # code...
        echo $twig->render("contact.twig",['person' => [
                    'name' => 'Wassim',
                    'email' =>  "wassim@gmail.com"
                ]]);
        break;
    default:
        # code.
        header('HTTP/1.0 404 Not Found');
        echo $twig->render("404.twig");
        break;
}

// if ($page === "home") {
//     // require "home.php"
//     // echo $twig->render("home.twig",['title' => 'home']);
//     echo $twig->render("home.twig", ['person' => [
//         'name' => 'Wassim',
//         'age' =>  82
//     ]]);
// }
