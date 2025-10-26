<?php

$finder = PhpCsFixer\Finder::create()
    ->in('src')
    ->in('tests')
;

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PSR12'                 => true,
    '@Symfony'               => true,
    'binary_operator_spaces' => ['default' => 'align_single_space_minimal'],
    'concat_space'           => ['spacing' => 'one'],
    'yoda_style'             => false,
])
->setFinder($finder)
;
