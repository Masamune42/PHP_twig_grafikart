<?php

/**
 * Classe qui étend de \Twig\Extension\AbstractExtension qui permet de définir différentes fonctions
 */
class MonExtension extends \Twig\Extension\AbstractExtension
{

    // 
    public function getFilters()
    {
        return [
            // 2e param : 1. Dans cet objet, 2. nom de la fonction
            // 3e paramètre : on prend en compte les balise HTML
            new \Twig\TwigFilter('markdown', [$this, 'markdownParse'], ['is_safe' => ['html']])
        ];
    }

    // Fonction qui prend en compte le markdown
    public function markdownParse($value)
    {
        return \Michelf\MarkdownExtra::defaultTransform($value);
    }
}
