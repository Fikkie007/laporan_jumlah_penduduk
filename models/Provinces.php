<?php

namespace app\models;

use jeemce\models\Model;
use Yii;

/**
 * This is the model class for table "provinces".
 *
 * @property int $province_id
 * @property string $name
 */
class Provinces extends Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provinces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique', 'targetClass' => Provinces::class, 'message' => 'Nama Sudah Ada'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'province_id' => 'Province ID',
            'name' => 'Name',
        ];
    }
}
