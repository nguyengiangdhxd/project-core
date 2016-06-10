<?php 
use Flywheel\Db\Manager;
use Flywheel\Model\ActiveRecord;
/**.
 * Users
 * @version		$Id$
 * @package		Model

 * @property integer $id id primary auto_increment type : int(11)
 * @property string $username username type : varchar(255) max_length : 255
 * @property string $password password type : varchar(255) max_length : 255
 * @property string $level level type : varchar(11) max_length : 11
 * @property string $email email type : varchar(255) max_length : 255
 * @property string $fullname fullname type : varchar(255) max_length : 255
 * @property number $balance balance type : double
 * @property number $money_in money_in type : double
 * @property number $money_out money_out type : double
 * @property date $created_time created_time type : date

 * @method void setId(integer $id) set id value
 * @method integer getId() get id value
 * @method static \Users[] findById(integer $id) find objects in database by id
 * @method static \Users findOneById(integer $id) find object in database by id
 * @method static \Users retrieveById(integer $id) retrieve object from poll by id, get it from db if not exist in poll

 * @method void setUsername(string $username) set username value
 * @method string getUsername() get username value
 * @method static \Users[] findByUsername(string $username) find objects in database by username
 * @method static \Users findOneByUsername(string $username) find object in database by username
 * @method static \Users retrieveByUsername(string $username) retrieve object from poll by username, get it from db if not exist in poll

 * @method void setPassword(string $password) set password value
 * @method string getPassword() get password value
 * @method static \Users[] findByPassword(string $password) find objects in database by password
 * @method static \Users findOneByPassword(string $password) find object in database by password
 * @method static \Users retrieveByPassword(string $password) retrieve object from poll by password, get it from db if not exist in poll

 * @method void setLevel(string $level) set level value
 * @method string getLevel() get level value
 * @method static \Users[] findByLevel(string $level) find objects in database by level
 * @method static \Users findOneByLevel(string $level) find object in database by level
 * @method static \Users retrieveByLevel(string $level) retrieve object from poll by level, get it from db if not exist in poll

 * @method void setEmail(string $email) set email value
 * @method string getEmail() get email value
 * @method static \Users[] findByEmail(string $email) find objects in database by email
 * @method static \Users findOneByEmail(string $email) find object in database by email
 * @method static \Users retrieveByEmail(string $email) retrieve object from poll by email, get it from db if not exist in poll

 * @method void setFullname(string $fullname) set fullname value
 * @method string getFullname() get fullname value
 * @method static \Users[] findByFullname(string $fullname) find objects in database by fullname
 * @method static \Users findOneByFullname(string $fullname) find object in database by fullname
 * @method static \Users retrieveByFullname(string $fullname) retrieve object from poll by fullname, get it from db if not exist in poll

 * @method void setBalance(number $balance) set balance value
 * @method number getBalance() get balance value
 * @method static \Users[] findByBalance(number $balance) find objects in database by balance
 * @method static \Users findOneByBalance(number $balance) find object in database by balance
 * @method static \Users retrieveByBalance(number $balance) retrieve object from poll by balance, get it from db if not exist in poll

 * @method void setMoneyIn(number $money_in) set money_in value
 * @method number getMoneyIn() get money_in value
 * @method static \Users[] findByMoneyIn(number $money_in) find objects in database by money_in
 * @method static \Users findOneByMoneyIn(number $money_in) find object in database by money_in
 * @method static \Users retrieveByMoneyIn(number $money_in) retrieve object from poll by money_in, get it from db if not exist in poll

 * @method void setMoneyOut(number $money_out) set money_out value
 * @method number getMoneyOut() get money_out value
 * @method static \Users[] findByMoneyOut(number $money_out) find objects in database by money_out
 * @method static \Users findOneByMoneyOut(number $money_out) find object in database by money_out
 * @method static \Users retrieveByMoneyOut(number $money_out) retrieve object from poll by money_out, get it from db if not exist in poll

 * @method void setCreatedTime(\Flywheel\Db\Type\DateTime $created_time) setCreatedTime(string $created_time) set created_time value
 * @method \Flywheel\Db\Type\DateTime getCreatedTime() get created_time value
 * @method static \Users[] findByCreatedTime(\Flywheel\Db\Type\DateTime $created_time) findByCreatedTime(string $created_time) find objects in database by created_time
 * @method static \Users findOneByCreatedTime(\Flywheel\Db\Type\DateTime $created_time) findOneByCreatedTime(string $created_time) find object in database by created_time
 * @method static \Users retrieveByCreatedTime(\Flywheel\Db\Type\DateTime $created_time) retrieveByCreatedTime(string $created_time) retrieve object from poll by created_time, get it from db if not exist in poll


 */
abstract class UsersBase extends ActiveRecord {
    protected static $_tableName = 'users';
    protected static $_phpName = 'Users';
    protected static $_pk = 'id';
    protected static $_alias = 'u';
    protected static $_dbConnectName = 'users';
    protected static $_instances = array();
    protected static $_schema = array(
        'id' => array('name' => 'id',
                'not_null' => true,
                'type' => 'integer',
                'primary' => true,
                'auto_increment' => true,
                'db_type' => 'int(11)',
                'length' => 4),
        'username' => array('name' => 'username',
                'not_null' => false,
                'type' => 'string',
                'db_type' => 'varchar(255)',
                'length' => 255),
        'password' => array('name' => 'password',
                'not_null' => false,
                'type' => 'string',
                'db_type' => 'varchar(255)',
                'length' => 255),
        'level' => array('name' => 'level',
                'not_null' => false,
                'type' => 'string',
                'db_type' => 'varchar(11)',
                'length' => 11),
        'email' => array('name' => 'email',
                'not_null' => false,
                'type' => 'string',
                'db_type' => 'varchar(255)',
                'length' => 255),
        'fullname' => array('name' => 'fullname',
                'not_null' => false,
                'type' => 'string',
                'db_type' => 'varchar(255)',
                'length' => 255),
        'balance' => array('name' => 'balance',
                'not_null' => false,
                'type' => 'number',
                'auto_increment' => false,
                'db_type' => 'double'),
        'money_in' => array('name' => 'money_in',
                'not_null' => false,
                'type' => 'number',
                'auto_increment' => false,
                'db_type' => 'double'),
        'money_out' => array('name' => 'money_out',
                'not_null' => false,
                'type' => 'number',
                'auto_increment' => false,
                'db_type' => 'double'),
        'created_time' => array('name' => 'created_time',
                'not_null' => false,
                'type' => 'date',
                'db_type' => 'date'),
     );
    protected static $_validate = array(
    );
    protected static $_validatorRules = array(
    );
    protected static $_init = false;
    protected static $_cols = array('id','username','password','level','email','fullname','balance','money_in','money_out','created_time');

    public function setTableDefinition() {
    }

    /**
     * save object model
     * @return boolean
     * @throws \Exception
     */
    public function save($validate = true) {
        $conn = Manager::getConnection(self::getDbConnectName());
        $conn->beginTransaction();
        try {
            $this->_beforeSave();
            $status = $this->saveToDb($validate);
            $this->_afterSave();
            $conn->commit();
            self::addInstanceToPool($this, $this->getPkValue());
            return $status;
        }
        catch (\Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    /**
     * delete object model
     * @return boolean
     * @throws \Exception
     */
    public function delete() {
        $conn = Manager::getConnection(self::getDbConnectName());
        $conn->beginTransaction();
        try {
            $this->_beforeDelete();
            $this->deleteFromDb();
            $this->_afterDelete();
            $conn->commit();
            self::removeInstanceFromPool($this->getPkValue());
            return true;
        }
        catch (\Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    }
}