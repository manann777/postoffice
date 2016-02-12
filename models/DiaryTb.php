<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "diary_tb".
 *
 * @property string $id_diary
 * @property integer $receive_airmail
 * @property integer $send_airmail
 * @property double $price_airmail
 * @property integer $receive_mailreg
 * @property integer $receive_mail
 * @property integer $send_mail
 * @property integer $sendback_post
 * @property integer $return_post
 * @property string $comment
 * @property string $diary_date
 * @property string $writer
 */
class DiaryTb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diary_tb';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receive_airmail', 'send_airmail', 'receive_mailreg', 'receive_mail', 'send_mail', 'sendback_post', 'return_post','sendback_postman', 'return_postman','send_ems','receive_ems','send_mailreg','price_airmail'], 'required','message' => 'ข้อมูลจำเป็น'],
            [['receive_airmail', 'send_airmail', 'receive_mailreg', 'receive_mail', 'send_mail', 'sendback_post', 'return_post','sendback_postman', 'return_postman','send_ems','receive_ems','send_mailreg'],'integer','message' => 'ตัวจำนวนเต็มเท่านั้น'],
            [['price_airmail','mail_price'], 'number'],
            [['diary_date'], 'required'],
            [['diary_date'], 'safe'],
            [['comment'], 'string', 'max' => 200],
            [['writer'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_diary' => 'เลขบันทึก',
            'receive_airmail' => 'รับairmail',
            'send_airmail' => 'ส่งairmail',
            'price_airmail' => 'ค่าใช้จ่ายairmail',
            'receive_mailreg' => 'รับจดหมายลงทะเบียน',
            'receive_mail' => 'รับจดหมายธรรมดา',
            'send_mail' => 'ส่งจดหมายธรรมดา',
            'mail_price'=>'ค่าใช้จ่ายจดหมายธรรมดา',
            'sendback_post' => 'จดหมายส่งคืนไปรษณีย์ลงทะเบียน',
            'return_post' => 'จดหมายตีกลับลงทะเบียน',
            'sendback_postman' => 'จดหมายส่งคืนไปรษณีย์ธรรมดา',
            'return_postman' => 'จดหมายตีกลับธรรมดา',
            'comment' => 'หมายเหตุ',
            'diary_date' => 'ประจำวันที่',
            'writer' => 'ผู้บันทึก',
            'send_ems' =>'ส่งพัสดุems',
            'receive_ems'=> 'รับพัสดุems',
            'send_mailreg'=>'ส่งพัสดุลงทะเบียน'

        ];
    }
}
