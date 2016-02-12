<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "group_save".
 *
 * @property integer $id
 * @property integer $id_group
 * @property string $type_doc
 * @property string $number_book
 * @property string $date_update
 * @property string $filepath
 * @property number $price_postoffice
 * @property string $comment
 */
class GroupSave extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $imageFile;

    public static function tableName()
    {
        return 'group_save';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_group', 'type_doc', 'number_book', 'date_update'], 'required'],
            [['price_postoffice','group_owner'],'number'],
            [['date_update'], 'safe'],
            [['type_doc', 'number_book','filepath'], 'string', 'max' => 40],
            [['imageFile'], 'file', 'extensions' => 'pdf'],
            [['comment'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'index',
            'id_group' => 'เลขกลุ่ม',
            'type_doc' => 'ประเภท',
            'number_book' => 'หมายเลขเล่ม',
            'price_postoffice'=>'ราคาจากไปรษณีย์',
            'date_update' => 'lastupdate',
            'imageFile' =>'ไฟล์',
            'filepath'=>'เส้นทาง',
            'status_group'=>'สถานะ',
            'email_owner'=>'emailเจ้าของ',
            'comment'=>'หมายเหตุ',
            'date_create'=>'วันที่',
            'group_owner'=>'หน่วยงานเจ้าของกลุ่ม',
        ];
    }



    // public function upload()
    // {
    //     if ($this->validate()) {
    //         //$this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
      public function getSendItems()
    {
        return $this->hasMany(SendItem::className(), ['group_item' => 'id']);
    }
    
    public function getIdUnitSender()
    {
        return $this->hasOne(Unit::className(), ['id_unit' => 'group_owner']);
    }

}
