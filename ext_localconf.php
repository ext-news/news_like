<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

call_user_func(
    function ($extKey) {
        $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['tx_newslike'] =
            'EXT:news_like/Classes/Ajax/Eid.php';

        $GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['classes']['Domain/Model/News'][] = $extKey;
    },
    $_EXTKEY
);
