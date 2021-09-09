<?php

declare(strict_types=1);

use PhpCsFixer\Finder;

return (new PhpCsFixer\Config())
    ->setRules(
        [
            '@PSR12' => true,
            'array_syntax' => ['syntax' => 'short'],
            'ordered_imports' => ['sort_algorithm' => 'alpha'],
            'no_unused_imports' => true,
            'concat_space' => ['spacing' => 'one'],
            'class_definition' => ['space_before_parenthesis' => true]
        ]
    )
    ->setFinder(
        Finder::create()
            ->in(__DIR__)
            ->exclude(['vendor'])
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
    );
