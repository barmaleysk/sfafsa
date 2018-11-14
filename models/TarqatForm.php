<?php 
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class TarqatForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;
    public $text;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
        	[['file', 'text'], 'required'],
             [['file'], 'file', 'extensions' => 'gif, jpg, png'],
            [['text'], 'string'],
        ];
    }
}

 ?>