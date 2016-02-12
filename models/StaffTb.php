<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "staff_tb".
 *
 * @property integer $id_staff
 * @property string $name_staff
 * @property string $email_staff
 * @property string $level_staff
 *
 * @property ForwardItem[] $forwardItems
 * @property SendItem[] $sendItems
 */
class StaffTb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_tb';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_staff', 'email_staff', 'level_staff','unit'], 'required'],
            [['level_staff','comment'], 'string'],
            [['name_staff', 'email_staff'], 'string', 'max' => 140],
            [['email_staff'],'email'],
             [['email_staff'],'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_staff' => 'รหัสเจ้าหน้าที่',
            'name_staff' => 'ชื่อเจ้าหน้าที่',
            'email_staff' => 'email',
            'level_staff' => 'สถานะเจ้าหน้าที่',
            'comment'=>'หมายเหตุ',
            'unit'=>'หน่วยงาน'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForwardItems()
    {
        return $this->hasMany(ForwardItem::className(), ['id_staff' => 'id_staff']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendItems()
    {
        return $this->hasMany(SendItem::className(), ['id_staff' => 'id_staff']);
    }

    

    public function getLevel($email)
    {
       return $this->findOne(['email_staff'=>$email]);

    }
}
