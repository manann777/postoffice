<?php

namespace app\models;

use Yii;

class ReciverReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reciver_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_unit','date'], 'required'],
            [['qty_reg','qty_manmail'],'number'],
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
            'date' => 'วันที่',
           
            'qty_reg'=>'จำนวนลงทะเบียน',
            'qty_manmail'=>'จำนวนจดหมาธรรมดา',
            'comment'=>'หมายเหตุ',
        ];
    }


}
