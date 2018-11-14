<?php
namespace app\models;
use yii\web\UploadedFile;

class MailForm extends \yii\base\Model
{
    public $textarea;
    public $imgpath;

    public function rules()
    {
        return [
        	  [['textarea', 'imgpath'], 'required'],
        	  [['imgpath'], 'file'],
            // define validation rules here
        ];
    }
}