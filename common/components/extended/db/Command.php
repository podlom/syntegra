<?php

namespace common\components\extended\db;

class Command extends \yii\db\Command
{
    const MYSQL_DEADLOCK_ERROR_CODE = 1213;
    const MAX_EXECUTE_ATTEMPTS = 3;

    public function execute()
    {
        static $attempts = 0;
        try {
            $result = parent::execute();
            $attempts = 0;
            return $result;
        } catch (\yii\db\Exception $e) {
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == static::MYSQL_DEADLOCK_ERROR_CODE) {
                if (++ $attempts < static::MAX_EXECUTE_ATTEMPTS) {
                    $delay_ms = rand(1, 10);
                    \Yii::warning(
                        sprintf(
                            'MySQL deadlock <![CDATA[retry %u from %u with delay %ums. %s]]>',
                            $attempts,
                            static::MAX_EXECUTE_ATTEMPTS,
                            $delay_ms,
                            $e->getMessage()
                        ),
                        __METHOD__
                    );
                    usleep($delay_ms * 1000);
                    return $this->execute();
                }
                $attempts = 0;
                throw $e;
            }
        }
    }
}
