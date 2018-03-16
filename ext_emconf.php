<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Simple like tool for EXT:news',
    'description' => 'Extend news with like options',
    'category' => 'fe',
    'author' => 'Georg Ringer',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.99-7.1.99',
            'news' => '6.0.0-6.9.9',
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];