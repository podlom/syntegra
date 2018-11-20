<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 01.06.2017
 * Time: 15:21
 */

namespace backend\models;


use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class UploadQuestionFileForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf, doc, docx'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $dirName = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR .
                'web' . DIRECTORY_SEPARATOR .
                'uploads' . DIRECTORY_SEPARATOR .
                'files' . DIRECTORY_SEPARATOR;
            Yii::trace('Saving file ' . $this->imageFile->baseName . '.' . $this->imageFile->extension . ' to directory: ' . $dirName);
            $this->imageFile->saveAs( $dirName . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}