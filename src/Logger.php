<?php

/******************************************************************************
 * Copyright 2022, Hopex LP. All Rights Reserved                              *
 *                                                                            *
 * GitHub: https://github.com/H0pex                                           *
 *                                                                            *
 * @author      Schizo                                                        *
 * @site        https://vk.com/id244036703                                    *
 ******************************************************************************/

namespace Hopex\Simplog;

use Throwable;

class Logger
{
    /**
     * @var string
     */
    private string $workDirectory = '.' . DIRECTORY_SEPARATOR . 'logs';

    /**
     * @var string
     */
    private string $level = 'runtime';

    /**
     * @var string
     */
    private string $timeZone = 'UTC';

    /**
     * @var string
     */
    private string $dateFormat = 'd-m-Y H:i:s';

    /**
     * @var bool
     */
    private bool $clearLevel = false;

    /**
     * @param string $workDirectory
     * @return Logger
     */
    public function setWorkDirectory(string $workDirectory): Logger
    {
        $this->workDirectory = $workDirectory;
        return $this;
    }

    /**
     * @param string $level
     * @return Logger
     */
    public function setLevel(string $level): Logger
    {
        $this->level = strtolower($level);
        return $this;
    }

    /**
     * @param string $timeZone
     * @return Logger
     */
    public function setTimeZone(string $timeZone): Logger
    {
        $this->timeZone = $timeZone;
        return $this;
    }

    /**
     * @param string $dateFormat
     * @return Logger
     */
    public function setDateFormat(string $dateFormat): Logger
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }

    /**
     * @return Logger
     */
    public function clearLevel(): Logger
    {
        $this->clearLevel = true;
        return $this;
    }

    /**
     * @param $data
     * @param string|null $fileName
     * @return void
     */
    public function putData($data, string $fileName)
    {
        date_default_timezone_set($this->timeZone);

        $above = [];
        $nowTime = date($this->dateFormat);
        $directoryLog = $this->workDirectory . (empty($this->level) ? '' : DIRECTORY_SEPARATOR . $this->level);
        $fileLog = $directoryLog . DIRECTORY_SEPARATOR . $fileName . '.log';

        if (!file_exists($directoryLog)) {
            mkdir($directoryLog, 0755, true);
        }

        if ($this->clearLevel) {
            foreach (glob($directoryLog . DIRECTORY_SEPARATOR . '*.log') as $file) {
                if (is_file($file) && basename($file) != $fileName) {
                    unlink($file);
                }
            }
        }

        if (file_exists($fileLog)) {
            $above = json_decode(file_get_contents($fileLog) ?? '{}', true) ?? [];
        }

        file_put_contents(
            $fileLog,
            json_encode(array_merge([
                $nowTime => $data
            ], $above), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );
    }

    /**
     * @param Throwable $throwable
     * @param string $fileName
     * @param bool $withTrace
     * @return void
     */
    public function putException(
        Throwable $throwable,
        string $fileName,
        bool $withTrace = false
    ) {
        $this->putData(array_merge([
            'message' => $throwable->getMessage(),
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
        ], $withTrace ? [
            'trace' => $throwable->getTraceAsString()
        ] : []), $fileName);
    }
}
