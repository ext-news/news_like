<?php

namespace GeorgRinger\NewsLike\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class HashService
{

    const KEY = 'news_like';

    public static function getHash(int $newsId): string
    {
        return GeneralUtility::hmac($newsId, self::getSecret());
    }

    public static function validateHash(int $newsId, string $hash): bool
    {
        if ($newsId === 0 || empty($hash)) {
            return false;
        }

        return self::getHash($newsId) === $hash;
    }

    private static function getSecret(): string
    {
        return self::KEY . '_' . date('d.m.Y');
    }
}