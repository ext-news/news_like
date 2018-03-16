<?php
defined('TYPO3_MODE') or die();

$ll = 'LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:';

/**
 * Add extra fields to the sys_category record
 */
$columns = [
    'tx_newslike_count' => [
        'label' => 'LLL:EXT:news_like/Resources/Private/Language/locallang.xlf:tx_news_domain_model_news.tx_newslike_count',
        'config' => [
            'type' => 'input',
            'size' => 3,
            'readOnly' => true
        ]
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news', $columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_news_domain_model_news', 'tx_newslike_count', '',
    'after:path_segment');
