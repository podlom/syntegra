<?php

namespace common\components;

use Yii;
use yii\base\ErrorException;
use yii\db\Connection;
use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\helpers\VarDumper;

class ErrorLog extends \yii\log\Target
{
    /**
     * @var Connection|array|string the DB connection object or the application component ID of the DB connection.
     * After the DbTarget object is created, if you want to change this property, you should only assign it
     * with a DB connection object.
     * Starting from version 2.0.2, this can also be a configuration array for creating the object.
     */
    public $db = 'db';
    /**
     * @var string name of the DB table to store cache content. Defaults to "log".
     */
    public $logTable = '{{%errors_log}}';

    /**
     * @var array list of skiping error levels
     */
    public $skipErrorLevel = [4];

    /**
     * @var integer how many messages should be accumulated before they are exported.
     * Defaults to 1000. Note that messages will always be exported when the application terminates.
     * Set this property to be 0 if you don't want to export messages until the application terminates.
     */
    public $exportInterval = 1000;

    /**
     * Initializes the DbTarget component.
     * This method will initialize the [[db]] property to make sure it refers to a valid DB connection.
     * @throws InvalidConfigException if [[db]] is invalid.
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
    }

    /**
     * Get table name
     * @return string
     */
    public function getTableName() {
        return $this->db->quoteTableName($this->logTable);
    }

    /**
     * Stores log messages to DB.
     */
    public function export()
    {
        $sql = 'INSERT IGNORE INTO ' .$this->getTableName(). ' SET

                  [[time]]=:time, [[error_hash_id]]=:error_hash_id, [[snapshot_id]]=:snapshot_id,
                  [[category]]=:category, [[error_no]]=:error_no,[[error_message]]=:error_message,
                  [[error_file]]=:error_file, [[error_line]]=:error_line, [[uname]]=:uname,
                  [[host]]=:host,[[request_uri]]=:request_uri, [[remote_ip]]=:remote_ip,
                  [[http_referer]]=:http_referer, [[user_agent]]=:user_agent,[[user_id]]=:user_id,
                  [[backtrace]]=:backtrace, [[platform]]=:platform, [[repeated]] = :repeated

                ON DUPLICATE KEY UPDATE
                repeated = repeated + :repeated
        ';

        foreach ($this->messages as $message) {
            try {
                $command = $this->db->createCommand($sql);
                $data = [];

                list($data['text'], $data['level'], $data['category'], $data['timestamp']) = $message;

                if (in_array($data['level'], $this->skipErrorLevel)) {
                    continue;
                }

                //Set default value
                $data['file_name'] = '-';
                $data['file_line'] = 0;
                $data['backtrace'] = '';

                if (!is_string($data['text'])) {
                    // exceptions may not be serializable if in the call stack somewhere is a Closure
                    if ($data['text'] instanceof \Exception) {
                        $exception = $data['text'];
                        if ($exception !== null) {
                            $data['text'] = $exception->getMessage();

                            if (property_exists($exception, 'file') && property_exists($exception, 'line')) {
                                $data['file_name'] = (string)$exception->getFile();
                                $data['file_line'] = (int)$exception->getLine();
                            }
                            $data['backtrace'] = $exception->getTrace();
                        }

                    } else {
                        $data['text'] = VarDumper::export($data['text']);
                    }
                }

                if ($data['backtrace'] == '' && !empty($message[4])) {
                    $data['backtrace'] = $message[4];
                }

                //Prepare backtrace
                if (!empty($data['backtrace'])) {
                    $backtrace = array();
                    if (is_array($data['backtrace'])) {
                        $max_backtrace_depth = 20;
                        foreach ($data['backtrace'] as $trace) {
                            if (!$max_backtrace_depth--) break;

                            $args_str = array();
                            if (isset($trace['args'])) {
                                if (!is_array($trace['args'])) $trace['args'] = array();
                                foreach ($trace['args'] as $arg) {
                                    $type = gettype($arg);
                                    $arg_str = '';
                                    if (is_null($arg)) $arg_str = 'NULL';
                                    elseif ($type == 'string') {
                                        $arg_str = '"' . substr($arg, 0, 30) . (strlen($arg) > 30 ? "..." : "") . '"';
                                    } elseif (in_array($type, array('integer', 'float'))) $arg_str = $arg;
                                    elseif ($type == 'boolean') $arg_str = $arg ? 'TRUE' : 'FALSE';
                                    elseif (is_array($arg)) $arg_str = "array[" . count($arg) . "]";
                                    elseif ($type == 'object') {
                                        $class = get_class($arg);
                                        if (!empty($arg->__PHP_Incomplete_Class_Name)) {
                                            $class = $arg->__PHP_Incomplete_Class_Name;
                                        }
                                        $arg_str = "object<$class>";
                                    } else $arg_str = "<" . $type . ">";

                                    $args_str[] = $arg_str;
                                }
                            }
                            $traceFile = '';
                            if (isset($trace['file'])) {
                                $traceFile = $trace['file'];
                            }
                            $traceLine = 0;
                            if (isset($trace['line'])) {
                                $traceLine = $trace['line'];
                            }
                            $backtrace[] = array(
                                'file' => $traceFile,
                                'line' => $traceLine,
                                'function' => (isset($trace['class']) ? $trace['class'] . $trace['type'] : '') . $trace['function'],
                                'args' => '(' . join(', ', $args_str) . ')',
                            );
                        }
                    }
                    $data['backtrace'] = serialize($backtrace);
                }

                $data['uname'] = php_uname('a');
                $data['host'] = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '-';
                $data['request_uri'] = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '-';
                $data['http_referer'] = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '-';
                $data['user_id'] = !empty($_SESSION['__id']) ? $_SESSION['__id'] : 0;
                $data['remote_ip'] = !empty($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : 0;

                //Get user agent & platform
                $data['user_agent'] = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '-';
                $data['platform'] = !empty($_SERVER['HTTP_USER_AGENT']) ? Yii::$app->detectplatform->getPlatform() : 0;

                //If empty message
                if (empty($data['text'])) {
                    $data['text'] = 'UNKNOWN';
                }

                $command->bindValues([
                    ':time' => $data['timestamp'],
                    ':error_hash_id' => md5($this->cutCDATATag($data['text']) . $data['category']),
                    ':snapshot_id' => time(),
                    ':category' => $data['category'],
                    ':error_no' => $data['level'],
                    ':error_message' => $data['text'],
                    ':error_file' => $data['file_name'],
                    ':error_line' => $data['file_line'],
                    ':uname' => $data['uname'],
                    ':host' => $data['host'],
                    ':request_uri' => $data['request_uri'],
                    ':remote_ip' => $data['remote_ip'],
                    ':http_referer' => $data['http_referer'],
                    ':user_agent' => $data['user_agent'],
                    ':user_id' => $data['user_id'],
                    ':backtrace' => $data['backtrace'],
                    ':platform' => $data['platform'],
                    ':repeated' => 1
                ])->execute();
            } catch(\Exception $e) {
                Yii::error('Error log write error: ' . $e->getMessage(), 'yii\db\error_log');
            }
        }
    }

    /*
     * Cut message and add cut prefix
     */
    function cutMessage($text, $length, $afterCut = '...') {

        return substr($text, 0, $length) .
        (mb_strlen($text) > $length ? $afterCut : '' );
    }

    /*
     * Cut file path
     */
    function getShortPath( $short_path ) {
        if( $short_path != '-' ) {
            $short_path = substr(
                str_replace(
                    realpath( Yii::getAlias('@webroot') . '/../../' ),
                    '',
                    $short_path
                ) , 0, 50);
        }

        return $short_path;
    }

    /*
     * Get time interval
     */
    function getTimeInterval($finish, $start) {

        //Get differents
        $diff = abs($finish - $start);

        $interval = array();

        $interval['days'] = intval($diff / (3600 * 24));
        $diff -= $interval['days'] * 3600 * 24;

        $interval['hours'] = intval($diff / 3600);
        $diff -= $interval['hours'] * 3600;

        $interval['minutes'] = intval($diff / 60);
        $diff -= $interval['minutes'] * 60;

        $interval['seconds'] = $diff;

        //Get formated date
        $formated = array();
        if ($interval['days']) {
            $formated[] = $interval['days'] . " " . ($interval['days'] > 1 ? "days" : "day");
        }
        if ($interval['hours']) {
            $formated[] = $interval['hours'] . " " . ($interval['hours'] > 1 ? "hrs" : "hour");
        }
        if ($interval['minutes']) {
            $formated[] = $interval['minutes'] . " min";
        }
        if (!$formated) {
            $formated[] = "< 1 min";
        }
        return implode(", ", $formated);
    }

    /**
     * Get error log data
     * @param $hash_id
     * @param $date_range
     * @param $box
     * @return array
     */
    public function getStats($hash_id, $date_range, $box) {
        $max_value = 0;
        $stats = array();

        for ($i = 0; $i < $box['width']; $i++) $stats[$i] = array('sum' => 0, 'total' => 0);

        $group_type = 'sum';
        $step = 3600 * 24;
        for ($from = $date_range['from']; $from < $date_range['to']; $from += $step) {

            $command = Yii::$app->db->createCommand('
                    SELECT
                      time AS _time,
                      repeated AS total
                    FROM ' .$this->getTableName(). '
                    WHERE error_hash_id = :hash_id
                    AND time BETWEEN :from AND (:end);
             ');

            $data = $command->bindValues([
                'hash_id' => $hash_id,
                'from' => $from,
                'end'  => ($from + $step - 1),
            ])->queryAll();
            foreach ($data as $item) {
                $x = floor(($item['_time'] - $date_range['from']) / (($date_range['to'] - $date_range['from']) / $box['width']));

                $stats[$x]['sum'] += $item['total'];
                $stats[$x]['total']++;
            }
        }

        $interval = 60;
        foreach ($stats as &$value) {
            switch ($group_type) {
                case 'avg':
                    $value = $value['total'] > 0 ? $value['sum'] / $value['total'] : 0;
                    break;
                case 'sum':
                    $value = $value['total'] > 0 ? $value['sum'] / (($date_range['to'] - $date_range['from']) / $interval / $box['width']) : 0;
                    break;
                case 'total':
                    $value = $value['total'];
                    break;
            }

            if ($value > $max_value) $max_value = $value;
        }

        $max_value += $max_value * 0.1;

        foreach ($stats as &$value) {
            $value = ($max_value) ? $box['height'] / $max_value * $value : 0;
        }

        return array(
            'values' => $stats,
            'max' => $max_value
        );
    }

    /**
     * Get back trace as string
     * @param $offset
     * @param $item
     * @return string
     */
    public function getTraceAsString($offset, $item) {
        return str_repeat('&nbsp;', $offset * 4) .
            htmlspecialchars($item['function'] .
            $item['args']) . " <small style='color: gray;'>" .
            $this->getShortPath($item['file']) .
            ' % ' . $item['line'] . '</small>';
    }

    /**
     * Clear old error messages. Oldest than 1 month
     * @throws \yii\db\Exception
     */
    public function errorLogCleaner() {
        $this->db->createCommand(
            'DELETE FROM ' .$this->getTableName(). ' WHERE time < UNIX_TIMESTAMP(NOW() - interval 1 month)'
        )->execute();
    }

    /**
     * Cut CDATA tag
     * @param $text
     * @return mixed
     */
    public function cutCDATATag($text) {
        return preg_replace('/(<!\[CDATA\[.+?\]\]>)/s', '', $text);
    }
}