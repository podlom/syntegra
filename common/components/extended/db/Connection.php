<?php

namespace common\components\extended\db;

class Connection extends \yii\db\Connection
{
    public function createCommand($sql = null, $params = [])
    {
        $command = new Command([
            'db' => $this,
            'sql' => $sql
        ]);

        return $command->bindValues($params);
    }
}
