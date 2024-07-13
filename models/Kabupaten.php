<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kabupaten".
 *
 * @property int $kabupaten_id
 * @property string $name
 * @property int $province_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Province $province
 */
class Kabupaten extends \jeemce\models\Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kabupaten';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'province_id'], 'required'],
            [['province_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::class, 'targetAttribute' => ['province_id' => 'province_id']],
            [['name'], 'unique', 'targetClass' => Kabupaten::class, 'message' => 'Nama Sudah Ada'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kabupaten_id' => 'Kabupaten ID',
            'name' => 'Name',
            'province_id' => 'Province ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

            'province.name' => 'Nama Provinsi'
        ];
    }

    /**
     * Gets query for [[Province]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Provinces::class, ['province_id' => 'province_id']);
    }
}
