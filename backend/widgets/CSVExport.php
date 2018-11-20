<?php


namespace backend\widgets;

use yii\data\ActiveDataProvider;
use yii\data\BaseDataProvider;
use yii\db\ActiveQueryInterface;
use yii\grid\ActionColumn;
use yii\grid\Column;
use yii\grid\DataColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Inflector;

class CSVExport extends GridView
{

    /**
     * @var string the exported output file name.
     */
    public $filename = 'export';
    /**
     * @var string the request parameter that will be submitted during export.
     */
    public $exportRequestParam = 'exportCSV';
    /**
     * @var bool trigger that now download mode
     */
    public $triggerDownload = false;

    public $buttonLabel = 'CSV Export';
    /**
     * @var string separator for data
     */
    public $separator = ',';
    /**
     * @var string encoding of file
     */
    public $encoding = 'utf-8';
    /**
     * @var bool if true export all data from provider
     */
    public $exportAll = false;

    /**
     * @var bool erase output buffer
     */
    public $clearBuffers = true;

    /**
     * @var int timeout for the export function (in seconds), if timeout = -1 it doesn't set any timeout so default PHP
     *     timeout will be used
     */
    public $timeout = -1;

    /**
     * @var BaseDataProvider the modified data provider for usage with export.
     */
    private $provider;

    private $output;


    public function init()
    {

        $this->triggerDownload = !empty($_POST) && !empty($_POST[$this->exportRequestParam])
            && $_POST[$this->exportRequestParam];

        parent::init();
    }


    public function run()
    {

        if ($this->triggerDownload) {
            $this->export();
        } else {
            echo $this->renderContent();
            return;
        }

    }

    private function export()
    {

        if ($this->timeout >= 0) {
            set_time_limit($this->timeout);
        }

        $this->provider = clone($this->dataProvider);
        $this->clearOutputBuffers();
        $this->setHttpHeaders();

        $this->output = fopen('php://output', 'w');
        fwrite($this->output, "\xEF\xBB\xBF");
        $this->generateHeader();
        $this->generateBody();

        fclose($this->output);

        exit();
    }

    /**
     * Generate header
     * @return string
     */
    public function generateHeader()
    {
        $headerData = [];
        /**
         * @var Column $column
         */
        foreach ($this->columns as $column) {
            if ($column instanceof ActionColumn) {
                continue;
            }

            $headerData[] = $this->getColumnHeader($column);
        }

        fputcsv($this->output, $headerData, $this->separator);
    }

    /**
     * Gets the column header content
     *
     * @param DataColumn $column
     *
     * @return string
     */
    public function getColumnHeader($column)
    {

        if ($column instanceof DataColumn) {

            if ($column->header !== null || ($column->label === null && $column->attribute === null)) {
                return trim($column->header) !== '' ? $column->header : $column->grid->emptyCell;
            }

            $provider = $this->dataProvider;

            if ($column->label === null) {

                if ($provider instanceof ActiveDataProvider
                    && $provider->query instanceof ActiveQueryInterface
                ) {

                    /**
                     * @var \yii\db\ActiveRecord $model
                     */
                    $model = new $provider->query->modelClass;
                    $label = $model->getAttributeLabel($column->attribute);

                } else {

                    $models = $provider->getModels();
                    if (($model = reset($models)) instanceof Model) {
                        $label = $model->getAttributeLabel($column->attribute);
                    } else {
                        $label = Inflector::camel2words($column->attribute);
                    }
                }
            } else {
                $label = $column->label;
            }
        } else {
            $label = $column->header;
        }

        return $label;
    }


    /**
     * Generates the output data body content.
     *
     * @return int the number of output rows.
     */
    public function generateBody()
    {

        $models = $this->provider->getModels();
        $totalCount = $this->provider->getTotalCount();

        while (count($models) > 0) {

            foreach ($models as $index => $model) {
                 $this->generateRow($model, $index);
            }

            if ($this->exportAll && $this->provider->pagination) {
                $this->provider->pagination->page++;
                $this->provider->refresh();
                $this->provider->setTotalCount($totalCount);
                $models = $this->provider->getModels();
            } else {
                $models = [];
            }
        }
    }


    /**
     * Generates an output data row with the given data model and index.
     *
     * @param mixed $model the data model to be rendered
     * @param integer $index the zero-based index of the data model among the model array returned by [[dataProvider]].
     *
     * @return string
     */
    public function generateRow($model, $index)
    {

        $rowData = [];

        /**
         * @var Column $column
         */

        foreach ($this->columns as $key => $column) {

            if ($column instanceof ActionColumn) {
                continue;
            } else {
                $format = isset($column->format) ? $column->format : 'raw';
                $value = ($column->content === null) ? (method_exists($column, 'getDataCellValue') ?
                    $this->formatter->format($column->getDataCellValue($model, $key, $index), $format) :
                    $column->renderDataCell($model, $key, $index)) :
                    call_user_func($column->content, $model, $key, $index, $column);
            }

            $rowData[] = stripslashes(strip_tags($value));
        }

        fputcsv($this->output, $rowData, $this->separator);
    }

    /**
     * Render widget content
     */
    public function renderContent()
    {

        $content = [
            Html::beginForm('', 'post'),
            Html::hiddenInput($this->exportRequestParam, 1),
            Html::submitButton($this->buttonLabel, ['class' => 'btn btn-info']),
            Html::endForm(),
        ];

        return implode(PHP_EOL, $content);
    }

    /**
     * Set HTTP headers for download
     * @return void
     */
    protected function setHttpHeaders()
    {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Content-Encoding: {$this->encoding}");
        header("Content-Type: text/csv; charset={$this->encoding}");
        header("Content-Disposition: attachment; filename={$this->filename}.csv");
    }


    /**
     * Clear output buffer
     * @return void
     */
    protected function clearOutputBuffers()
    {
        if ($this->clearBuffers) {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
        } else {
            ob_end_clean();
        }
    }

}