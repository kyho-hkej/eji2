<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "hkej_member".
 *
 * @property string $user_id
 * @property string $login
 * @property string $password
 */
class HKEJUser extends \yii\db\ActiveRecord  implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hkej_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'password', 'firstname', 'lastname', 'forumname'], 'required'],
            [['login', 'password', 'firstname', 'lastname', 'forumname'], 'string', 'max' => 255]            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'login' => 'Login',
            'password' => 'Password',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'forumname' => 'Forumname',
            'birthyear' => 'Birthyear',
            'birthmonth' => 'Birthmonth',
            'birthday' => 'Birthday',
            'age' => 'Age',
            'gender' => 'Gender',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'country' => 'Country',
            'study' => 'Study',
            'profession' => 'Profession',
            'other_country' => 'Other Country',
            'company_nature' => 'Company Nature',
            'company_size' => 'Company Size',
            'regular_reader' => 'Regular Reader',
            'regular_start_year' => 'Regular Start Year',
            'self_buy' => 'Self Buy',
            'share' => 'Share',
            'enable' => 'Enable',
            'deleted' => 'Deleted',
            'createdate' => 'Createdate',
            'lastupdate' => 'Lastupdate',
            'createip' => 'Createip',
            'lastupdateip' => 'Lastupdateip',
            'member_type' => 'Member Type',
            'agentname' => 'Agent Name',
            'agent_ref_id' => 'Agent Reference id', 
            'expect_startdate' => 'Expect Startdate',
            'first_startdate' => 'First Startdate',
            'subscribe_enddate' => 'Subscribe Enddate',
            'district' => 'District',
            'other_district' => 'Other District',
            'modifydate' => 'Modifydate',
            'modifyuser' => 'Modifyuser',
            'contact_no' => 'Contact No',
            'rebate_amt' => 'Rebate Amt',
            'contact_email' => 'Contact Email',
            'createuser' => 'Createuser',
            'addr_modifydate' => 'Addr Modifydate',
            'remarks' => 'Remarks',
            'magazine_no' => 'Magazine No',
            'fax_no' => 'Fax No',
        ];
    }

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByLogin($login)
    {
        return static::findOne(['login' => $login]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    public function getLogin()
    {
        return \Yii::$app->user->identity->login;
    }

    public function getForumname()
    {
        return \Yii::$app->user->identity->forumname;
    }
    public function getAuthKey()
    {
        throw new NotSupportedException();//You should not implement this method if you don't have authKey column in your database
    }

    public function validateAuthKey($authKey)
    {
       throw new NotSupportedException();//You should not implement this method if you don't have authKey column in your database
    }
    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
    /*
    * If you want to use a different database connection other than the db component, you should override the getDb() method:*/

    public static function getDb()
    {
        // use the "db2" application component
        return \Yii::$app->dbMainsiteRemoteWeb;  
    }

}