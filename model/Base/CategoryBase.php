<?php 
use Flywheel\Db\Manager;
use Flywheel\Model\ActiveRecord;
/**.
 * Category
 * @version		$Id$
 * @package		Model

 * @property integer $id id primary auto_increment type : int(11)
 * @property string $category_name category_name type : varchar(50) max_length : 50
 * @property date $createdTime createdTime type : date

 * @method void setId(integer $id) set id value
 * @method integer getId() get id value
 * @method static \Category[] findById(integer $id) find objects in database by id
 * @method static \Category findOneById(integer $id) find object in database by id
 * @method static \Category retrieveById(integer $id) retrieve object from poll by id, get it from db if not exist in poll

 * @method void setCategoryName(string $category_name) set category_name value
 * @method string getCategoryName() get category_name value
 * @method static \Category[] findByCategoryName(string $category_name) find objects in database by category_name
 * @method static \Category findOneByCategoryName(string $category_name) find object in database by category_name
 * @method static \Category retrieveByCategoryName(string $category_name) retrieve object from poll by category_name, get it from db if not exist in poll

 * @method void setCreatedTime(\Flywheel\Db\Type\DateTime $createdTime) setCreatedTime(string $createdTime) set createdTime value
 * @method \Flywheel\Db\Type\DateTime getCreatedTime() get createdTime value
 * @method static \Category[] findByCreatedTime(\Flywheel\Db\Type\DateTime $createdTime) findByCreatedTime(string $createdTime) find objects in database by createdTime
 * @method static \Category findOneByCreatedTime(\Flywheel\Db\Type\DateTime $createdTime) findOneByCreatedTime(string $createdTime) find object in database by createdTime
 * @method static \Category retrieveByCreatedTime(\Flywheel\Db\Type\DateTime $createdTime) retrieveByCreatedTime(string $createdTime) retrieve object from poll by createdTime, get it from db if not exist in poll


 */
abstract class CategoryBase extends ActiveRecord {
    protected static $_tableName = 'category';
    protected static $_phpName = 'Category';
    protected static $_pk = 'id';
    protected static $_alias = 'c';
    protected static $_dbConnectName = 'category';
    protected static $_instances = array();
    protected static $_schema = array(
        'id' => array('name' => 'id',
                'not_null' => true,
                'type' => 'integer',
                'primary' => true,
                'auto_increment' => true,
                'db_type' => 'int(11)',
                'length' => 4),
        'category_name' => array('name' => 'category_name',
                'not_null' => false,
                'type' => 'string',
                'db_type' => 'varchar(50)',
                'length' => 50),
        'createdTime' => array('name' => 'createdTime',
                'not_null' => false,
                'type' => 'date',
                'db_type' => 'date'),
     );
    protected static $_validate = array(
    );
    protected static $_validatorRules = array(
    );
    protected static $_init = false;
    protected static $_cols = array('id','category_name','createdTime');

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