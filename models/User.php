<?php

namespace app\models;

use app\rbac\models\Role;
use kartik\password\StrengthValidator;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the user model class extending UserIdentity.
 * Here you can implement your custom user solutions.
 *
 * @property Role[] $role
 * @property Article[] $articles
 */
class User extends UserIdentity
{
    // the list of status values that can be stored in user table
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -99;

    /**
     * List of names for each status.
     * @var array
     */
    public $statusList = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_DELETED => 'Deleted'
    ];

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'unique'],
            [['consumer', 'access_given', 'auth_key'], 'safe'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['status', 'required'],
        ];
    }

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => date("Y-m-d h:i:s"),
            ],
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    //------------------------------------------------------------------------------------------------//
    // USER FINDERS
    //------------------------------------------------------------------------------------------------//

    /**
     * Finds user by username.
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->where(['username' => $username])->andWhere(["status" => self::STATUS_ACTIVE])->one();
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public static function active(): Yii\db\ActiveQuery
    {
        return static::find()->where(["status" => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email.
     *
     * @param string $email
     * @return User|null
     */
    public static function findByEmail(string $email): User|null
    {
        return static::active()->andWhere(["email" => $email])->one();
    }

    /**
     * Finds user by password reset token.
     *
     * @param string $token Password reset token.
     * @return static|null
     */
    public static function findByPasswordResetToken(string $token): ?static
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => User::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by account activation token.
     *
     * @param string $token Account activation token.
     * @return static|null
     */
    public static function findByAccountActivationToken(string $token): static
    {
        return static::findOne([
            'account_activation_token' => $token,
            'status' => User::STATUS_INACTIVE,
        ]);
    }


    //------------------------------------------------------------------------------------------------//
    // HELPERS
    //------------------------------------------------------------------------------------------------//

    /**
     * Returns the user status in nice format.
     *
     * @param integer $status Status integer value.
     * @return string          Nicely formatted status.
     */
    public function getStatusName($status)
    {
        return $this->statusList[$status];
    }

    public function getStatusText()
    {
        return $this->statusList[$this->status];
    }


    /**
     * Generates new password reset token.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token.
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds out if password reset token is valid.
     *
     * @param string $token Password reset token.
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Generates new account activation token.
     */
    public function generateAccountActivationToken()
    {
        $this->account_activation_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes account activation token.
     */
    public function removeAccountActivationToken()
    {
        $this->account_activation_token = null;
    }
}
