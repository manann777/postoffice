<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "regmail".
 *
 * @property integer $id
 * @property double $min_weight
 * @property double $max_weight
 * @property double $price_rank
 * @property string $comment
 */
class Regmail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regmail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['min_weight', 'max_weight', 'price_rank', 'comment'], 'required'],
            [['min_weight', 'max_weight', 'price_rank'], 'number'],
            [['comment'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'min_weight' => 'น้ำหนักน้อย',
            'max_weight' => 'น้ำหนักมาก',
            'price_rank' => 'ราคา',
            'comment' => 'หมายเหตุ',
        ];
    }
}
