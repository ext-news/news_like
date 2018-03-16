<?php

namespace GeorgRinger\NewsLike\Ajax;

use GeorgRinger\NewsLike\Service\HashService;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Eid
{
    const LOG_TABLE = 'tx_newslike_log';

    /** @var array */
    protected $configuration = [];

    /** @var int */
    protected $newsId;

    public function __construct()
    {
        $this->newsId = (int)GeneralUtility::_POST('news');
        $this->configuration = (array)unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['news_like']);
    }

    public function run()
    {
        if ($this->newsId === 0) {
            throw new \UnexpectedValueException('No news set');
        }

        if (!HashService::validateHash($this->newsId, (string)GeneralUtility::_POST('hash'))) {
            throw new \UnexpectedValueException('Invalid hash');
        }

        switch (GeneralUtility::_POST('action')) {
            case 'count':
                $this->count();
                $this->getData();
                break;
            case 'data':
                $this->getData();
                break;
            default:
                throw new \UnexpectedValueException('No action set');
        }
    }

    public function getData()
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_news_domain_model_news');
        $row = $queryBuilder->select('uid', 'tx_newslike_count')
            ->from('tx_news_domain_model_news')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($this->newsId, \PDO::PARAM_INT))
            )
            ->execute()
            ->fetch();

        $data = [
            'count' => $row['tx_newslike_count']
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function count()
    {
        $ip = GeneralUtility::getIndpEnv('REMOTE_ADDR');

        $count = null;
        if ((int)$this->configuration['daysForNextVoting'] === 0) {
            $count = 0;
        } else {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable(self::LOG_TABLE);
            $count = $queryBuilder->count('*')
                ->from(self::LOG_TABLE)
                ->where(
                    $queryBuilder->expr()->eq('news', $queryBuilder->createNamedParameter($this->newsId, \PDO::PARAM_INT)),
                    $queryBuilder->expr()->eq('ip', $queryBuilder->createNamedParameter($ip, \PDO::PARAM_STR)),
                    $queryBuilder->expr()->gte('log_date', $queryBuilder->createNamedParameter($this->getAllowedTimeFrame(), \PDO::PARAM_INT))
                )
                ->execute()
                ->fetchColumn(0);
        }

        if ($count === 0) {
            $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable(self::LOG_TABLE);
            $connection->insert(
                self::LOG_TABLE,
                [
                    'ip' => $ip,
                    'news' => $this->newsId,
                    'log_date' => $this->getCurrentDate()
                ]
            );

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('tx_news_domain_model_news');
            $queryBuilder
                ->update('tx_news_domain_model_news')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($this->newsId, \PDO::PARAM_INT))
                )
                ->set('tx_newslike_count', $queryBuilder->quoteIdentifier('tx_newslike_count') . '+1', false)
                ->execute();
        }
    }

    /**
     * Get current date
     *
     * @return string Formatted date
     */
    protected function getCurrentDate()
    {
        return date('Y-m-d', $GLOBALS['EXEC_TIME']);
    }

    /**
     * @return string Formatted date
     */
    protected function getAllowedTimeFrame()
    {
        $time = 86400 * (int)$this->configuration['daysForNextVoting'];
        return date('Y-m-d', $GLOBALS['EXEC_TIME'] - $time);
    }
}

$instance = GeneralUtility::makeInstance(Eid::class);
$instance->run();
