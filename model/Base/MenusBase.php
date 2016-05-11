<?php 
use Flywheel\Db\Manager;
use Flywheel\Model\ActiveRecord;
/**.
 * Menus
 * @version		$Id$
 * @package		Model

 * @property integer $id id primary auto_increment type : int(11)
 * @property string $name name type : varchar(200) max_length : 200
 * @property integer $parent parent type : int(11)

 * @method void setId(integer $id) set id value
 * @method integer getId() get id value
 * @method static \Menus[] findById(integer $id) find objects in database by id
 * @method static \Menus findOneById(integer $id) find object in database by id
 * @method static \Menus retrieveById(integer $id) retrieve object from poll by id, get it from db if not exist in poll

 * @method void setName(string $name) set name value
 * @method string getName() get name value
 * @method static \Menus[] findByName(string $name) find objects in database by name
 * @method static \Menus findOneByName(string $name) find object in database by name
 * @method static \Menus retrieveByName(string $name) retrieve object from poll by name, get it from db if not exist in poll

 * @method void setParent(integer $parent) set parent value
 * @method integer getParent() get parent value
 * @method static \Menus[] findByParent(integer $parent) find objects in database by parent
 * @method static \Menus findOneByParent(integer $parent) find object in database by parent
 * @method static \Menus retrieveByParent(integer $parent) retrieve object from poll by parent, get it from db if not exist in poll


 */
abstract class MenusBase extends ActiveRecord {
    protected static $_tableName = 'menus';
    protected static $_phpName = 'Menus';
    protected static $_pk = 'id';
    protected static $_alias = 'm';
    protected static $_dbConnectName = 'menus';
    protected static $_instances = array();
    protected static $_schema = array(
        'id' => array('name' => 'id',
                'not_null' => true,
                'type' => 'integer',
                'primary' => true,
                'auto_increment' => true,
                'db_type' => 'int(11)',
                'length' => 4),
        'name' => array('name' => 'name',
                'not_null' => true,
                'type' => 'string',
                'db_type' => 'varchar(200)',
                'length' => 200),
        'parent' => array('name' => 'parent',
                'not_null' => true,
                'type' => 'integer',
                'auto_increment' => false,
                'db_type' => 'int(11)',
                'length' => 4),
     );
    protected static $_validate = array(
    );
    protected static $_validatorRules = array(
    );
    protected static $_init = false;
    protected static $_cols = array('id','name','parent');

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