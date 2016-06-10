<?php 
use Flywheel\Db\Manager;
use Flywheel\Model\ActiveRecord;
/**.
 * News
 * @version		$Id$
 * @package		Model

 * @property integer $id id primary auto_increment type : int(11)
 * @property integer $menu_id menu_id type : int(11)
 * @property string $title title type : varchar(255) max_length : 255
 * @property string $image image type : varchar(255) max_length : 255
 * @property string $summary summary type : varchar(255) max_length : 255
 * @property string $content content type : text max_length : 
 * @property string $footer footer type : varchar(255) max_length : 255
 * @property date $created_time created_time type : date

 * @method void setId(integer $id) set id value
 * @method integer getId() get id value
 * @method static \News[] findById(integer $id) find objects in database by id
 * @method static \News findOneById(integer $id) find object in database by id
 * @method static \News retrieveById(integer $id) retrieve object from poll by id, get it from db if not exist in poll

 * @method void setMenuId(integer $menu_id) set menu_id value
 * @method integer getMenuId() get menu_id value
 * @method static \News[] findByMenuId(integer $menu_id) find objects in database by menu_id
 * @method static \News findOneByMenuId(integer $menu_id) find object in database by menu_id
 * @method static \News retrieveByMenuId(integer $menu_id) retrieve object from poll by menu_id, get it from db if not exist in poll

 * @method void setTitle(string $title) set title value
 * @method string getTitle() get title value
 * @method static \News[] findByTitle(string $title) find objects in database by title
 * @method static \News findOneByTitle(string $title) find object in database by title
 * @method static \News retrieveByTitle(string $title) retrieve object from poll by title, get it from db if not exist in poll

 * @method void setImage(string $image) set image value
 * @method string getImage() get image value
 * @method static \News[] findByImage(string $image) find objects in database by image
 * @method static \News findOneByImage(string $image) find object in database by image
 * @method static \News retrieveByImage(string $image) retrieve object from poll by image, get it from db if not exist in poll

 * @method void setSummary(string $summary) set summary value
 * @method string getSummary() get summary value
 * @method static \News[] findBySummary(string $summary) find objects in database by summary
 * @method static \News findOneBySummary(string $summary) find object in database by summary
 * @method static \News retrieveBySummary(string $summary) retrieve object from poll by summary, get it from db if not exist in poll

 * @method void setContent(string $content) set content value
 * @method string getContent() get content value
 * @method static \News[] findByContent(string $content) find objects in database by content
 * @method static \News findOneByContent(string $content) find object in database by content
 * @method static \News retrieveByContent(string $content) retrieve object from poll by content, get it from db if not exist in poll

 * @method void setFooter(string $footer) set footer value
 * @method string getFooter() get footer value
 * @method static \News[] findByFooter(string $footer) find objects in database by footer
 * @method static \News findOneByFooter(string $footer) find object in database by footer
 * @method static \News retrieveByFooter(string $footer) retrieve object from poll by footer, get it from db if not exist in poll

 * @method void setCreatedTime(\Flywheel\Db\Type\DateTime $created_time) setCreatedTime(string $created_time) set created_time value
 * @method \Flywheel\Db\Type\DateTime getCreatedTime() get created_time value
 * @method static \News[] findByCreatedTime(\Flywheel\Db\Type\DateTime $created_time) findByCreatedTime(string $created_time) find objects in database by created_time
 * @method static \News findOneByCreatedTime(\Flywheel\Db\Type\DateTime $created_time) findOneByCreatedTime(string $created_time) find object in database by created_time
 * @method static \News retrieveByCreatedTime(\Flywheel\Db\Type\DateTime $created_time) retrieveByCreatedTime(string $created_time) retrieve object from poll by created_time, get it from db if not exist in poll


 */
abstract class NewsBase extends ActiveRecord {
    protected static $_tableName = 'news';
    protected static $_phpName = 'News';
    protected static $_pk = 'id';
    protected static $_alias = 'n';
    protected static $_dbConnectName = 'news';
    protected static $_instances = array();
    protected static $_schema = array(
        'id' => array('name' => 'id',
                'not_null' => true,
                'type' => 'integer',
                'primary' => true,
                'auto_increment' => true,
                'db_type' => 'int(11)',
                'length' => 4),
        'menu_id' => array('name' => 'menu_id',
                'not_null' => true,
                'type' => 'integer',
                'auto_increment' => false,
                'db_type' => 'int(11)',
                'length' => 4),
        'title' => array('name' => 'title',
                'not_null' => false,
                'type' => 'string',
                'db_type' => 'varchar(255)',
                'length' => 255),
        'image' => array('name' => 'image',
                'not_null' => false,
                'type' => 'string',
                'db_type' => 'varchar(255)',
                'length' => 255),
        'summary' => array('name' => 'summary',
                'not_null' => false,
                'type' => 'string',
                'db_type' => 'varchar(255)',
                'length' => 255),
        'content' => array('name' => 'content',
                'not_null' => false,
                'type' => 'string',
                'db_type' => 'text'),
        'footer' => array('name' => 'footer',
                'not_null' => false,
                'type' => 'string',
                'db_type' => 'varchar(255)',
                'length' => 255),
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
    protected static $_cols = array('id','menu_id','title','image','summary','content','footer','created_time');

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