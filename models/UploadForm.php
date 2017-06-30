<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $postid;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['postid'], 'integer'],
        ];
    }

    public function upload()
    {
        if ($this->validate())
        {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);

            $imgModel = new Postimage();

            $imgModel->image = $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $imgModel->post_id = $this->postid;
            $imgModel->save();

            return true;
        } else {
            return false;
        }
    }
}