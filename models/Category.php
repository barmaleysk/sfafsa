<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $nomi
 * @property string $parent
 * @property string $nomiru
 * @property string $parentru
 * @property string $step
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nomi'], 'required'],
            [['parent', 'nomi','step'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomi' => 'Имя катигория',
            'parent' => 'Под катигория',
            'step' => 'Step',
        ];
    }
    public function beforeSave($insert) {

        if(!$this->parent)
            $this->parent = 'home';
         return parent::beforeSave($insert);
    }

}
