<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kontakt".
 *
 * @property int $id
 * @property string $nomi
 * @property string $manzili
 * @property string $telefoni
 */
class Kontakt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kontakt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nomi', 'manzili', 'telefoni'], 'required'],
            [['nomi', 'manzili', 'telefoni'], 'string', 'max' => 255],
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
            'manzili' => 'Адресс',
            'telefoni' => 'Телефон',
        ];
    }
}
