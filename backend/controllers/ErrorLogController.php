<?php

namespace backend\controllers;


use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;


/**
 * Контроллер авторизации пользователя
 */
class ErrorLogController extends Controller
{
    /**
     * View error log list
     * @return mixed
     */
    public function actionIndex()
    {
        //Get errors for last day
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT
              MIN(time) AS first_time,
              MAX(time) AS last_time,
              error_hash_id,
              error_no,
              error_message,
              category,
              error_file,
              error_line,
              SUM(repeated) AS repeated
            FROM ' .Yii::$app->log->targets['db']->getTableName(). '
            WHERE time > UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)
            GROUP BY error_hash_id
            ORDER BY ROUND((UNIX_TIMESTAMP(NOW()) - MAX(time)) / 600) ASC, repeated DESC;',
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Get detailed info, about error
     */
    public function actionDetailed() {

        //Get hash id
        $hash_id = Yii::$app->request->get('hash_id');
        if(empty($hash_id))
            exit('No hash id');

        //Get detailed data
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM
                    ' .Yii::$app->log->targets['db']->getTableName(). '
                WHERE
                    time > UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)
                    AND error_hash_id = :hash_id
                ORDER BY time DESC',
            'params' => [':hash_id' => $hash_id],
            'pagination' => false,
        ]);

        return $this->render('detailed', [
            'dataProvider' => $dataProvider,
            'hash_id' => $hash_id,
        ]);
    }

    /**
     * Get error graph
     */
    public function actionGraph() {

        //Get hash id
        $hash_id = Yii::$app->request->get('hash_id');
        if(empty($hash_id))
            exit('No hash id');

        //Get period
        $period = Yii::$app->request->get('period', 'last_day');

        //Set variables by period
        switch ($period) {
            case 'last_day':
                $now = floor(time() / 600) * 600;
                $date_range = array('from' => $now - 24 * 3600, 'to' => $now);
                $cache_time = 600 + rand(-60, 60);
                break;
            case 'last_week':
                $now = floor(time() / 3600) * 3600;
                $date_range = array('from' => $now - 24 * 3600 * 7, 'to' => $now);
                $cache_time = 3600 + rand(-600, 600);
                break;
            case 'last_month':
                $now = floor(time() / 3600 / 24) * 3600 * 24;
                $date_range = array('from' => $now - 24 * 3600 * 30, 'to' => $now);
                $cache_time = 3600 * 24 + rand(-3600, 3600);
                break;
        }

        $label = Yii::$app->request->get('label', 'Graph');

        //Set box variables
        $box = [];

        $box['width'] = Yii::$app->request->get('width', '1200');
        $box['height'] = Yii::$app->request->get('height', '200');
        $box['border'] = Yii::$app->request->get('border', '1');
        $box['margin'] = Yii::$app->request->get('margin', array('top' => 30, 'left' => 10, 'right' => 50, 'bottom' => 70));

        if( is_string($box['margin']) ) {
            $tBox = $box['margin'];

            $box['margin'] = [];
            list($box['margin']['top'], $box['margin']['left'],
                $box['margin']['right'], $box['margin']['bottom']) = explode(',', $tBox);
        }

        if( Yii::$app->request->get('from') != '' )
            $date_range['from'] = strtotime(Yii::$app->request->get('from'));

        if( Yii::$app->request->get('to') != '' )
            $date_range['to'] = strtotime(Yii::$app->request->get('to'));

        $no_labels = (bool)Yii::$app->request->get('no_labels', false);

        if ($date_range['to'] <= $date_range['from'])
            exit('Invalid period');

        $cache_key = 'errors_graph_data_' . $box['width'] . '_' . $box['height'] . '_' . $hash_id . '_' . $date_range['from'] . '_' . $date_range['to'];

        if (Yii::$app->cache->exists($cache_key)) {
            $stats = Yii::$app->cache->get($cache_key);
        }
        else {
            $stats = Yii::$app->log->targets['db']->getStats($hash_id, $date_range, $box);
            Yii::$app->cache->set($cache_key, $stats, 5 * 600); // кеш на 5 минут
        }

        //Create image
        $canvas = imagecreatetruecolor(
            $box['width'] + $box['border'] * 2 + $box['margin']['left'] + $box['margin']['right'],
            $box['height'] + $box['border'] * 2 + $box['margin']['top'] + $box['margin']['bottom']
        );
        $colors = array(
            'transparent' => imagecolorallocate($canvas, 250, 250, 250),
            'background' => imagecolorallocate($canvas, 255, 255, 255),
            'axes' => imagecolorallocate($canvas, 200, 200, 200),
            'graph' => imagecolorallocatealpha($canvas, 0, 0, 128, 60),
            'border' => imagecolorallocate($canvas, 0, 0, 0),
            'text' => imagecolorallocate($canvas, 0, 0, 0),
            'important_text' => imagecolorallocate($canvas, 128, 0, 0),
        );

        imagefilledrectangle($canvas, 0, 0,
            $box['width'] + $box['border'] * 2 + $box['margin']['left'] + $box['margin']['right'] - 1,
            $box['height'] + $box['border'] * 2 + $box['margin']['top'] + $box['margin']['bottom'] - 1,
            $colors['transparent']
        );

        // background
        imagefilledrectangle(
            $canvas,
            $box['border'] + $box['margin']['left'],
            $box['border'] + $box['margin']['top'],
            $box['width'] + $box['border'] + $box['margin']['left'] - 1,
            $box['height'] + $box['border'] +$box['margin']['top'] - 1,
            $colors['background']
        );

        // axes
        $parts_x = floor($box['width'] / 35);
        $step_x = ($date_range['to'] - $date_range['from']) / ($parts_x ? $parts_x : 1);
        $time = $date_range['from'];
        $prev_day = false;

        $dashed_style = array(
            $colors['background'],
            $colors['background'],
            $colors['axes'],
            $colors['axes']
        );
        imagesetstyle($canvas, $dashed_style);

        while ($time <= $date_range['to']) {
            $x_scale = (($date_range['to'] - $date_range['from']) / $box['width']);
            $x = floor(($time - $date_range['from']) / $x_scale);

            imageline(
                $canvas,
                $x + $box['border'] + $box['margin']['left'],
                $box['border'] + $box['margin']['top'] - 1,
                $x + $box['border'] + $box['margin']['left'],
                $box['height'] + $box['border'] + $box['margin']['top'] - 1,
                IMG_COLOR_STYLED
            );

            if (!$no_labels) {
                if ($prev_day != date('Ymd', $time)) {
                    $time_str = date("m.d H:i", $time);
                    $color = $colors['important_text'];
                } else {
                    $time_str = date("H:i", $time);
                    $color = $colors['text'];
                }
                imagestringup(
                    $canvas, 1,
                    $x + $box['border'] + $box['margin']['left'] - 3,
                    $box['height'] + $box['border'] + $box['margin']['top'] + strlen($time_str) * 5 + 3,
                    $time_str, $color
                );

                $prev_day = date('Ymd', $time);
            }

            $time += $step_x;
        }

        $parts_y = floor($box['height'] / 35);
        $step_y = $stats['max'] / ($parts_y ? $parts_y : 1);
        $value = 0;
        $scale_y = $stats['max'] == 0 ? 0 : ($box['height'] / $stats['max']);

        while ($value < $stats['max']) {
            imageline(
                $canvas,
                $box['border'] + $box['margin']['left'],
                $box['border'] + $box['margin']['top'] + $box['height'] - $scale_y * $value,
                $box['width'] + $box['border'] + $box['margin']['left'],
                $box['border'] + $box['margin']['top'] + $box['height'] - $scale_y * $value,
                IMG_COLOR_STYLED
            );
            if (!$no_labels) {
                imagestring(
                    $canvas, 1,
                    $box['width'] + $box['border'] + $box['margin']['left'] + 4,
                    $box['border'] + $box['margin']['top'] + $box['height'] - $scale_y * $value - 4,
                    round($value, 2), $colors['axes']
                );
            }

            $value += $step_y;
        }

        // graph
        foreach ($stats['values'] as $x => $value) {
            imageline(
                $canvas,
                $x + $box['border'] + $box['margin']['left'],
                $box['height'] + $box['border'] + $box['margin']['top'] - 1,
                $x + $box['border'] + $box['margin']['left'],
                $box['height'] - $value + $box['border'] + $box['margin']['top'] - 1,
                $colors['graph']
            );
        }

        // border
        imagerectangle(
            $canvas,
            $box['margin']['left'], $box['margin']['top'],
            $box['width'] + $box['border'] * 2 + $box['margin']['left'] - 1,
            $box['height'] + $box['border'] * 2 + $box['margin']['top'] - 1,
            $colors['border']
        );

        if (!$no_labels) {
            imagestring(
                $canvas, 2, 10, 10,
                $label . "; generated in " . round(microtime(true) - $started, 2) . " seconds",
                $colors['text']
            );
        }

        header('Cache-Control: public');
        header('Cache-Control: max-age=300');
        header('Content-type: image/png');
        imagepng($canvas);
    }

}
