<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 14.11.2017
 * Time: 17:06
 */

namespace backend\models;


use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class UploadCatalogItemGalleryImageForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $dirName = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR .
                'web' . DIRECTORY_SEPARATOR .
                'images' . DIRECTORY_SEPARATOR .
                'gallery' . DIRECTORY_SEPARATOR;
            Yii::trace('Saving file ' . $this->imageFile->baseName . '.' . $this->imageFile->extension . ' to directory: ' . $dirName);
            $this->imageFile->saveAs( $dirName . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}