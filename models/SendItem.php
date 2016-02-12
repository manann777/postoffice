<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "send_item".
 *
 * @property string $id_item
 * @property string $name_sender
 * @property string $name_receiver
 * @property string $id_reg_item
 * @property integer $id_reg_type
 * @property string $date_send
 * @property double $price_item
 * @property double $weight_item
 * @property integer $id_unit_sender
 * @property string $status_item
 * @property integer $id_staff
 * @property string $last_update
 * @property string $item_comment
 *
 * @property RegType $idRegType
 * @property StaffTb $idStaff
 * @property Unit $idUnitSender
 */
class SendItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'send_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_sender', 'name_receiver', 'id_reg_type',  'id_unit_sender', 'status_item','destiny_code','qty_item'], 'required','message' => 'ข้อมูลจำเป็น'],
            [['id_reg_type', 'id_unit_sender', 'id_staff','qty_item'], 'integer','message' => 'ตัวจำนวนเต็มเท่านั้น'],
            [['date_send', 'last_update'], 'safe'],
            [['price_item', 'weight_item','price_item_post'], 'number','message' => 'ข้อมูลตัวเลข'],
            [['status_item'], 'string'],
            [['name_sender', 'name_receiver'], 'string', 'max' => 150],
            [['id_reg_item'], 'string'],
             [['staff_do'], 'integer'],
            [['item_comment'], 'string', 'max' => 200],
            [['destiny_code'],'string','max'=>5,'min'=>5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_item' => 'รหัสพัสดุ',
            'name_sender' => 'ชื่อผู้ส่ง',
            'name_receiver' => 'ชื่อผู้รับ',
            'id_reg_item' => 'เลขที่หนังสือ',
            'id_reg_type' => 'ประเภทการส่ง',
            'date_send' => 'วันเวลาส่ง',
            'price_item' => 'ค่าส่ง(บาท)',
            'weight_item' => 'น้ำหนัก(กก.)',
            'id_unit_sender' => 'หน่วยงาน',
            'status_item' => 'สถานะ',
            'id_staff' => 'หมายเลขเจ้าหน้าที่',
            'last_update' => 'วันเวลาปรับข้อมูล',
            'item_comment' => 'หมายเหตุ',
            'destiny_code'=>'รหัสปลายทาง',
            'commit_item'=>'ชื่อผู้รับรองเอกสาร',
            'qty_item'=>'จำนวน',
            'staff_do'=>'เจ้าหน้าทีทำงาน',
            'price_item_post'=>'ค่าส่งจากไปรษณีย์'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRegType()
    {
        return $this->hasOne(RegType::className(), ['id_reg' => 'id_reg_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStaff()
    {
        return $this->hasOne(StaffTb::className(), ['id_staff' => 'id_staff']);
    }
    public function getGroupItem()
    {
        return $this->hasOne(GroupSave::className(), ['id' => 'group_item']);

    }

     public function getGroupItemMove()
    {
        return $this->hasOne(GroupSave::className(), ['id' => 'group_item_move']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUnitSender()
    {
        return $this->hasOne(Unit::className(), ['id_unit' => 'id_unit_sender']);
    }
}
