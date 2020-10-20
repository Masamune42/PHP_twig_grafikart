<?php
require 'vendor/autoload.php';
require 'MonExtension.php';

// Routing 
$page = 'home';

if (isset($_GET['p'])) {
    $page = $_GET['p'];
}

// Récupère les dernires tutoriels
function tutoriels()
{
    $pdo = new PDO('mysql:dbname=grafikart_dev;host=localhost;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $tutoriels = $pdo->query('SELECT * FROM tutoriels ORDER BY id DESC LIMIT 10');
    return $tutoriels;
}

// Rendu du template
// loader -> Localise le dossier où se trouve les templates
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
// Environment -> stocke la configuration du loader
$twig = new \Twig\Environment($loader, [
    // On choisit où on va stocker en cache les templates compilés, sinon false
    // Utile pour raccourcir le temps de chargement (moteur de templates) des pages mais le cache est a supprimé si des modifications sont faites
    // En dev -> ne pas l'activer
    'cache' => false //__DIR__ . '/tmp'
]);

$twig->addExtension(new MonExtension());

// On crée une fonction qu'on pourra utiliser dans les pages twig
// $twig->addFunction(new \Twig\TwigFunction('markdown', function ($value) {
//     return \Michelf\MarkdownExtra::defaultTransform($value);
// }, ['is_safe' => ['html']]));

// // On crée un filtre qu'on pourra utiliser dans les pages twig (avec un |)
// $twig->addFilter(new \Twig\TwigFilter('markdown', function ($value) {
//     return \Michelf\MarkdownExtra::defaultTransform($value);
// }, ['is_safe' => ['html']]));

switch ($page) {
    case 'contact':
        echo $twig->render('contact.twig');
        break;

    case 'home':
        echo $twig->render('home.html.twig', [
            'tutoriels' => tutoriels()
        ]);
        break;

    default:
        header('HTTP/1.0 404 Not Found');
        echo $twig->render('404.twig');
        break;
}
