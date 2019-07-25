<?php
/**
 * User: wxxiong6@gmail.com
 * Date: 2019/7/22
 * Time: 17:16.
 */

namespace wxxiong6\yii\seaslog;

use Yii;
use yii\helpers\VarDumper;
use yii\log\Logger;
use yii\log\Target;

class Yii2SeasLog extends Target
{
    public $logFile;


    public $except = [];

    public $log;
    public $logLevel;

    public function init()
    {
        parent::init();
        if (null === $this->logFile) {
            $this->logFile = Yii::$app->getRuntimePath().'/';
        } else {
            $this->logFile = Yii::getAlias($this->logFile);
        }

        $this->log = Yii::createObject('SeasLog');
        $this->log->setBasePath($this->logFile);
        $this->log->setLogger('logs');
    }


    public function export()
    {
        foreach ($this->messages as $text) {
            $text = $this->formatMessage($text);
            $this->log->log($this->logLevel, $text);
        }
    }

    public function formatMessage($message)
    {
        list($text, $level, $category) = $message;

        $level = Logger::getLevelName($level);
        $this->logLevel = $level;

        if (!is_string($text)) {
            if ($text instanceof \Throwable || $text instanceof \Exception) {
                $text = (string) $text;
            } else {
                $text = VarDumper::export($text);
            }
        }
        $traces = [];
        if (isset($message[4])) {
            foreach ($message[4] as $trace) {
                $traces[] = "in {$trace['file']}:{$trace['line']}";
            }
        }

        $prefix = $this->getMessagePrefix($message);

        return "{$prefix}[$level][$category] $text"
            .(empty($traces) ? '' : "\n    ".implode("\n    ", $traces));
    }
}
