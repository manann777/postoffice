<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "manmail".
 *
 * @property integer $id
 * @property double $min_weight
 * @property double $max_weight
 * @property double $price_rank
 * @property string $comment
 */
class Manmail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manmail';
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
            'min_weight' => 'Min Weight',
            'max_weight' => 'Max Weight',
            'price_rank' => 'Price Rank',
            'comment' => 'Comment',
        ];
    }
}
