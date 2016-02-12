<?php

namespace app\models;

use Yii;

class MailPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['price_system','price_postoffice'], 'number'],
            [['comment'], 'string', 'max' => 250],
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'เลขกลุ่ม',
            'price_postoffice' => 'ราคาจากไปรษณีย์',
            'price_system' => 'ราคาจากระบบ',
            'comment' => 'หมายเหตุ',
           

        ];
    }
}
