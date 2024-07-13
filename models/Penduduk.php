<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penduduk".
 *
 * @property int $id
 * @property string $name
 * @property int $jenis_kelamin 1 = L, 0 = W
 * @property string $tanggal_lahir
 * @property string $alamat
 * @property int $province_id
 * @property int $kabupaten_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Kabupaten $kabupaten
 * @property Province $province
 */
class Penduduk extends \jeemce\models\Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penduduk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'jenis_kelamin', 'tanggal_lahir', 'alamat', 'province_id', 'kabupaten_id'], 'required'],
            [['jenis_kelamin', 'province_id', 'kabupaten_id'], 'integer'],
            [['tanggal_lahir', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['alamat'], 'string', 'max' => 50],
            [['kabupaten_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kabupaten::class, 'targetAttribute' => ['kabupaten_id' => 'kabupaten_id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::class, 'targetAttribute' => ['province_id' => 'province_id']],
            [['name'], 'unique', 'targetClass' => Penduduk::class, 'message' => 'Nama Sudah Ada'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat' => 'Alamat',
            'province_id' => 'Province ID',
            'kabupaten_id' => 'Kabupaten ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

            'province.name' => 'Nama Provinsi',
            'kabupaten.name' => 'Nama Kabupaten / Kota'
        ];
    }

    /**
     * Gets query for [[Kabupaten]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKabupaten()
    {
        return $this->hasOne(Kabupaten::class, ['kabupaten_id' => 'kabupaten_id']);
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
