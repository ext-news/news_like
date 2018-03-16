<?php

class Tx_Newslike_Domain_Model_News extends \GeorgRinger\News\Domain\Model\News
{

    /** @var int */
    protected $txNewslikeCount = 0;

    /**
     * @return int
     */
    public function getTxNewslikeCount(): int
    {
        return $this->txNewslikeCount;
    }

    /**
     * @param int $txNewslikeCount
     */
    public function setTxNewslikeCount(int $txNewslikeCount)
    {
        $this->txNewslikeCount = $txNewslikeCount;
    }

    public function getTxNewslikeHash()
    {
        return \GeorgRinger\NewsLike\Service\HashService::getHash($this->getUid());
    }
}
