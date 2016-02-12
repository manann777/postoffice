<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property integer $id_unit
 * @property string $name_unit
 * @property string $old_code
 *
 * @property ForwardItem[] $forwardItems
 * @property SendItem[] $sendItems
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_unit'], 'string', 'max' => 200],
            [['old_code'], 'string', 'max' => 5],
            [['unit_in'],'boolean'],
            [['name_unit'],'unique'],
            [['comment'],'string','max'=>200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_unit' => 'รหัสหน่วยงาน',
            'name_unit' => 'ชื่อหน่วยงาน',
            'old_code' => 'เก่า',
            'unit_in'=>'หน่วยงานสำคัญ',
            'comment'=>'ที่ตั้งหน่วยงาน / หมายเหตุ'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForwardItems()
    {
        return $this->hasMany(ForwardItem::className(), ['id_unit_receiver' => 'id_unit']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendItems()
    {
        return $this->hasMany(SendItem::className(), ['id_unit_sender' => 'id_unit']);
    }


   /* public function getUnit()
    {
        return $this->hasMany(groupSave::className(),['group_owner'=>'id_unit']);
    }*/
}
