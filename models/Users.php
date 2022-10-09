<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $created_at
 * @property string $email
 * @property string $login
 * @property string $password
 * @property string|null $date_of_birth
 * @property string|null $phone
 * @property string|null $telegram
 * @property int|null $rating
 * @property int $city_id
 * @property int|null $avatar_file_id
 *
 * @property Files $avatarFile
 * @property Cities $city
 * @property Responses[] $responses
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UsersRole[] $usersRoles
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'date_of_birth'], 'safe'],
            [['email', 'login', 'password', 'city_id'], 'required'],
            [['rating', 'city_id', 'avatar_file_id'], 'integer'],
            [['email'], 'string', 'max' => 128],
            [['login', 'telegram'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 11],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'id']],
            [['avatar_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::class, 'targetAttribute' => ['avatar_file_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'email' => 'Email',
            'login' => 'Login',
            'password' => 'Password',
            'date_of_birth' => 'Date Of Birth',
            'phone' => 'Phone',
            'telegram' => 'Telegram',
            'rating' => 'Rating',
            'city_id' => 'City ID',
            'avatar_file_id' => 'Avatar File ID',
        ];
    }

    /**
     * Gets query for [[AvatarFile]].
     *
     * @return \yii\db\ActiveQuery|FilesQuery
     */
    public function getAvatarFile()
    {
        return $this->hasOne(Files::class, ['id' => 'avatar_file_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery|ResponsesQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::class, ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::class, ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[UsersRoles]].
     *
     * @return \yii\db\ActiveQuery|UsersRoleQuery
     */
    public function getUsersRoles()
    {
        return $this->hasMany(UsersRole::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
