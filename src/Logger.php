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

/**
 * Class Logger
 * @package Hopex\Simplog
 */
class Logger
{
    /**
     * @var string
     */
    private string $workDirectory;

    /**
     * @var string
     */
    private string $level;

    /**
     * @var string
     */
    private string $dateFormat;

    /**
     * @var string|null
     */
    private ?string $itemKey;

    /**
     * @var int
     */
    private int $itemsLimit;

    /**
     * @var bool
     */
    private bool $clearLevel;

    /**
     * @var int
     */
    private int $filePermissions;

    /**
     * @var int
     */
    private int $directoryPermissions;

    /**
     * @var string
     */
    private string $fileName;

    public function __construct()
    {
        $this->clearLevel = false;
        $this->setWorkDirectory('.' . DIRECTORY_SEPARATOR . 'logs');
        $this->setLevel('runtime');
        $this->setFilePermissions(0775);
        $this->setDirectoryPermissions(0775);
        $this->setItemKey(null);
        $this->setItemsLimit(1000);
        $this->setTimeZone('UTC');
        $this->setDateFormat('H:i:s');
        $this->setFileName(date('Y-m-d'));
    }

    /**
     * Specifies the root directory of the
     * hierarchy of logging levels.
     * It can take several directories
     * in turn one after the other in the
     * form of a standard path.
     *
     * @param string $workDirectory
     *
     * @return Logger
     *
     * @example setWorkDirectory('logging')
     * @example setWorkDirectory('logging/sub-folder')
     */
    public function setWorkDirectory(string $workDirectory): Logger
    {
        $this->workDirectory = $this->clearPath($workDirectory);
        return $this;
    }

    /**
     * Specifies the name of the directory
     * where you want to save the logging file.
     * It can't take several directories
     * in turn one after the other in the
     * form of a standard path.
     *
     * @param string $level
     *
     * @return Logger
     *
     * @example setLevel('requests')
     */
    public function setLevel(string $level): Logger
    {
        $this->level = $this->clearPath($level);
        return $this;
    }

    /**
     * Specifies the current timezone.
     *
     * @param string $timeZone
     *
     * @return Logger
     *
     * @example setTimeZone('UTC')
     * @example setTimeZone('Europe/Amsterdam')
     */
    public function setTimeZone(string $timeZone): Logger
    {
        date_default_timezone_set($timeZone);
        return $this;
    }

    /**
     * Sets the time format in the main key of
     * one log element in the logging file.
     * Will not be used if V is specified.
     *
     * @param string $dateFormat
     *
     * @return Logger
     *
     * @example setDateFormat('H:i:s')
     * @example setDateFormat('(Y) H:i:s')
     */
    public function setDateFormat(string $dateFormat): Logger
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }

    /**
     * Sets the primary key of one log element in
     * the logging file.
     * In this case, the current time will not
     * be indicated.
     *
     * @param string|null $itemKey
     *
     * @return Logger
     *
     * @example setItemKey('custom-key')
     */
    public function setItemKey(?string $itemKey): Logger
    {
        $this->itemKey = $itemKey;
        return $this;
    }

    /**
     * The requirement to clear the directory
     * where the logging file should be
     * saved from other files.
     *
     * @return Logger
     *
     * @example clearLevel()
     */
    public function clearLevel(): Logger
    {
        $this->clearLevel = true;
        return $this;
    }

    /**
     * Sets the maximum number of elements in a
     * single logging file.
     * The value must be greater than zero.
     * By default, 1000 keys.
     *
     * @param int $itemsLimit
     *
     * @return Logger
     *
     * @example setItemsLimit(10)
     * @example setItemsLimit(5000)
     */
    public function setItemsLimit(int $itemsLimit): Logger
    {
        if ($itemsLimit > 0) {
            $this->itemsLimit = $itemsLimit;
        }

        return $this;
    }

    /**
     * Sets access rights to the logging file.
     *
     * @param int $rights
     *
     * @return Logger
     *
     * @example setFilePermissions(0755)
     * @example setFilePermissions(664)
     */
    public function setFilePermissions(int $rights): Logger
    {
        $this->filePermissions = $rights;
        return $this;
    }

    /**
     * Sets access rights to the directory logging.
     *
     * @param int $rights
     *
     * @return Logger
     *
     * @example setFilePermissions(0755)
     * @example setFilePermissions(664)
     */
    public function setDirectoryPermissions(int $rights): Logger
    {
        $this->directoryPermissions = $rights;
        return $this;
    }

    /**
     * Sets the name of the logging file.
     *
     * @param string $fileName
     *
     * @return Logger
     *
     * @example setFileName('my-requests-logs')
     */
    public function setFileName(string $fileName): Logger
    {
        $this->fileName = $this->clearFileName($fileName);
        return $this;
    }

    /**
     * Removes forbidden characters from file name.
     *
     * @param string $path
     *
     * @return string
     */
    private function clearFileName(string $path): string
    {
        return preg_replace(
            '~(\||<|>|\*|\?|\\|\/|#|^CON$|^PRN$|^AUX$|^NUL$|^COM1$|^COM2$|^COM3$|^COM4$|^COM5$|^COM6$|^COM7$|^COM8$|^COM9$|^LPT1$|^LPT2$|^LPT3$|^LPT4$|^LPT5$|^LPT6$|^LPT7$|^LPT8$|^LPT9$)~',
            '-', $path
        );
    }

    /**
     * Removes forbidden characters from paths.
     *
     * @param string $path
     *
     * @return string
     */
    private function clearPath(string $path): string
    {
        return trim(preg_replace(
            '~(\||<|>|\*|\?|#)~',
            '',
            preg_replace('~(\\{2,}|\/{2,})~', DIRECTORY_SEPARATOR, $path)
        ), '-');
    }

    /**
     * Logging any object as an error message.
     *
     * @param $data
     *
     * @return void
     */
    public function error($data): void
    {
        $this->loggingType($data, 'error');
    }

    /**
     * Logging any object as a warning.
     *
     * @param $data
     *
     * @return void
     */
    public function warning($data): void
    {
        $this->loggingType($data, 'warning');
    }

    /**
     * Logging of any object as an
     * informational message.
     *
     * @param $data
     *
     * @return void
     */
    public function info($data): void
    {
        $this->loggingType($data, 'info');
    }

    /**
     * Dynamic change of logging type.
     *
     * @param $data
     * @param string $type
     *
     * @return void
     */
    private function loggingType($data, string $type): void
    {
        $this
            ->setLevel($this->level . DIRECTORY_SEPARATOR . $type . 's')
            ->setFileName(sprintf("$type-%s", date('Y-m-d')))
            ->setItemKey(date('H:i:s'))
            ->custom($data);
    }

    /**
     * Logging of any object.
     *
     * @param $data
     *
     * @return void
     *
     * @example custom(new SomeClass()
     * @example custom('Some message')
     * @example custom(['key' => 'value'])
     */
    public function custom($data)
    {
        $fileName = preg_replace('~^(.*)\.log$~', "$1", $this->fileName);

        $above = [];
        $nowTime = date($this->dateFormat);
        $directoryLog = $this->workDirectory . (empty($this->level) ? '' : DIRECTORY_SEPARATOR . $this->level);
        $fileLog = $directoryLog . DIRECTORY_SEPARATOR . $fileName . '.log';

        if (!file_exists($directoryLog)) {
            mkdir($directoryLog, $this->directoryPermissions, true);
        }

        if ($this->clearLevel) {
            foreach (glob($directoryLog . DIRECTORY_SEPARATOR . '*.log') as $file) {
                if (is_file($file) && basename($file) != $fileName) {
                    unlink($file);
                }
            }
        }

        if (file_exists($fileLog)) {
            $above = array_slice(
                json_decode(file_get_contents($fileLog) ?? '{}', true) ?? [],
                0,
                $this->itemsLimit - 1
            );
        }

        file_put_contents(
            $fileLog,
            json_encode(array_merge([
                sprintf(
                    ($this->itemKey ?? $nowTime) . " (%s)",
                    substr(hash("md5", mt_rand(0, 10000)), 0 ,8)
                )  => $data
            ], $above), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );

        chmod($fileLog, $this->filePermissions);
    }

    /**
     * Logging of the exception object with
     * the possibility of adding additional keys.
     *
     * @param Throwable $throwable
     * @param bool $withTrace
     * @param array $payload
     *
     * @return void
     *
     * @example exception(new \Exceptions())
     * @example exception(new \Exceptions(), true)
     * @example exception(new \Exceptions(), false, ['key' => 'value'])
     */
    public function exception(Throwable $throwable, bool $withTrace = false, array $payload = [])
    {
        $this->custom(array_merge($payload, [
            'message' => $throwable->getMessage(),
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
        ], $withTrace ? [
            'trace' => $throwable->getTraceAsString()
        ] : []));
    }
}
