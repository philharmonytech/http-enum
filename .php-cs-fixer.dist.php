<?php

$finder = PhpCsFixer\Finder::create()
    ->in('src')
    ->in('tests');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'strict_param' => true,
        'declare_strict_types' => true,
    ])
    ->setFinder($finder)
    ->setUsingCache(true)
    ->setCacheFile('.php-cs-fixer.cache');
