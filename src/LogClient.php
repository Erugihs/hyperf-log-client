<?php


namespace STK\Client\Log;

use STK\Client\Log\Base\LogBase;
use STK\Client\Log\Exception\LogClientException;

class LogClient extends LogBase
{

    /**
     * @param $logData
     * @return array
     */
    public function addLog($logData)
    {
        try {
            $logData = $this->relationsAttribute($logData);
            return $this->logSvc->write($this->table, $logData);
        } catch (\Throwable $e) {
            throw new LogClientException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    /**
     * @param $where
     * @param $page
     * @param $pageSize
     * @return array
     */
    public function getLog($where, $page, $pageSize)
    {
        try {
            $pagination = [];
            $pagination['page'] = $page;
            $pagination['page_size'] = $pageSize;
            $where && $where = $this->relationsAttribute($where);
            return $this->logSvc->read($this->table, $where, $pagination);
        } catch (\Throwable $e) {
            throw new LogClientException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }
    
    
    public function register($table)
    {
        try {
            return $this->logSvc->register($table);
        } catch (\Throwable $e) {
            throw new LogClientException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    public function registryListing()
    {
        try {
            return $this->logSvc->registryListing();
        } catch (\Throwable $e) {
            throw new LogClientException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }
}
