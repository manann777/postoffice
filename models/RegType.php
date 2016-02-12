<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reg_type".
 *
 * @property integer $id_reg
 * @property string $type_reg
 * @property string $comment
 *
 * @property ForwardItem[] $forwardItems
 * @property SendItem[] $sendItems
 */
class RegType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reg_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_reg'], 'required'],
            [['type_reg'],   'unique'],
            [['type_reg'], 'string', 'max' => 30],
            [['comment'], 'string', 'max' => 140]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_reg' => 'รหัสรูปแบบ',
            'type_reg' => 'ประเภทการลงทะเบียนพัสดุ',
            'comment' => 'หมายเหตุ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForwardItems()
    {
        return $this->hasMany(ForwardItem::className(), ['id_reg_type' => 'id_reg']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendItems()
    {
        return $this->hasMany(SendItem::className(), ['id_reg_type' => 'id_reg']);
    }
}
