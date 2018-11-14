<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $nomi
 * @property string $turi
 * @property string $ulchami
 * @property string $rangi
 * @property string $rasmi
 * @property string $tavfsiloti
 * @property string $narxi
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'rasmi'], 'required'],
            [['rasmi'], 'file'],
            [['text'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          
        ];
    }
}
