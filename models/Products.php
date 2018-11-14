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
            [['nomi', 'turi', 'tavfsiloti'], 'required'],
            [['nomi', 'narxi'], 'string', 'max' => 255],
            [['turi'], 'string', 'max' => 250],
            [['rasmi'], 'file'],
            [['tavfsiloti'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomi' => 'Имя',
            'turi' => 'Тип катигория',
            'ulchami' => 'Размер',
            'rangi' => 'Rangi',
            'rasmi' => 'Картинка',
            'tavfsiloti' => 'Описания',
            'narxi' => 'Цена',
        ];
    }
}
