<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "savat".
 *
 * @property int $id
 * @property string $nomi
 * @property string $narxi
 * @property string $dona
 * @property string $tgid
 * @property string $turi
 * @property string $telefon
 * @property string $manzil
 * @property string $ism
 */
class Savat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'savat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nomi', 'narxi', 'dona', 'tgid', 'turi', 'telefon', 'manzil', 'ism'], 'string', 'max' => 255],
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
            'narxi' => 'Цена',
            'dona' => 'Количство',
            'tgid' => 'Телеграм ИД',
            'turi' => 'Тип',
            'telefon' => 'Телефон',
            'manzil' => 'Адресс',
            'ism' => 'Имя заказчика',
        ];
    }
}
