<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tgusers".
 *
 * @property int $id
 * @property string $username
 * @property string $lastname
 * @property string $firstname
 * @property int $tgid
 * @property string $tili
 * @property string $step
 * @property string $asos
 */
class Tgusers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tgusers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgid'], 'integer'],
            [['username', 'firstname', 'step'], 'string', 'max' => 255],
            [['lastname'], 'string', 'max' => 250],
            [['tili'], 'string', 'max' => 30],
            [['asos'], 'string', 'max' => 15],
            [['kirganvaqti'], 'string', 'max' => 15],
            [['datareg'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Юзер',
            'lastname' => 'Фамилия',
            'firstname' => 'Имя',
            'tgid' => 'Телегрпм ИД',
            'tili' => 'Язык',
            'step' => 'Step',
            'asos' => 'Asos',
            'kirganvaqti' => 'Дата последнего запуска',
            'datareg' => 'Дата регистрации',
        ];
    }
}
