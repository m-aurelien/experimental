<?php
/**
 * Created by Aurelien
 * Date: 03/08/13
 * Time: 23:45
 */

namespace Library\ApplicationComponent\Database;


use Library\Application;
use Library\ApplicationComponent\ApplicationComponent;
use Library\ApplicationComponent\Log\Logger;

class OrmGen extends ApplicationComponent {
    private $_path;
    private $_basePath;

    public function __construct(Application $app){
        parent::__construct($app);

        $this->logger()->trace("OrmGen", "Initiate OrmGen", Logger::PERIOD_VOID);

        $this->_path = SERVER_ROOT.'Applications'.DIRECTORY_SEPARATOR.APP_NAME.DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR.'ORM'.DIRECTORY_SEPARATOR;
        if(!is_dir($this->_path)){
            $this->logger()->trace("OrmGen", "Create ORM folder", Logger::PERIOD_VOID);

            mkdir($this->_path);
        }

        $this->_basePath = $this->_path.'Base'.DIRECTORY_SEPARATOR;
        if(!is_dir($this->_basePath)){
            $this->logger()->trace("OrmGen", "Create Base folder", Logger::PERIOD_VOID);

            mkdir($this->_basePath);
        }
    }

    public function generate(){
        try{
            $tableList = $this->pdo()->mysql()->listTable();
            foreach ($tableList as $table) {
                $this->_baseGenAndCreate($table);
            }
            foreach ($tableList as $table) {
                $this->_extendGenAndCreate($table);
            }

            $this->logger()->trace("OrmGen", "Files was generated with success", Logger::PERIOD_VOID);
        }catch (\Exception $e){
            $this->logger()->trace("OrmGen", "An error was occurred", Logger::PERIOD_VOID);
        }
    }

    private function _baseGenAndCreate($table){
        $this->logger()->trace("OrmGen", "Generate base".ucfirst($table[0]).".php", Logger::PERIOD_VOID);

        $filePath = $this->_basePath.'base'.ucfirst($table[0]).'.php';
        if(file_exists($filePath)) unlink($filePath);
        $file = fopen($filePath,'a+');

        $describe = $this->pdo()->mysql()->describeTable($table[0]);

        $input = $this->_headerGen();
        $input .= "\n";
        $input .= $this->_baseHeaderGen($table);
        $input .= "\n";
        $input .= $this->_baseConstGen($table, $describe);
        $input .= "\n";
        $input .= $this->_baseAttrGen($describe);
        $input .= "\n";
        $input .= $this->_baseConstructGen($describe);
        $input .= "\n";
        $input .= $this->_baseAccessorGen($describe);
        $input .= "\n";
        $input .= $this->_baseLoadGen($table);
        $input .= "\n";
        $input .= $this->_baseRetrieveGen($table, $this->_searchPrimaries($describe));
        $input .= "\n";
        $input .= $this->_baseInsertGen($table, $describe);
        $input .= "\n";
        $input .= $this->_baseUpdateGen($table, $this->_searchPrimaries($describe));
        $input .= "\n";
        $input .= $this->_baseDelGen($table, $this->_searchPrimaries($describe));
        $input .= "\n";
        $input .= $this->_footerGen();

        fputs($file, $input);
        fclose($file);
    }

    private function _extendGenAndCreate($table){
        $filePath = $this->_path.'e'.ucfirst($table[0]).'.php';
        if(!file_exists($filePath)){
            $this->logger()->trace("OrmGen", "Generate e".ucfirst($table[0]).".php", Logger::PERIOD_VOID);

            $file = fopen($filePath,'a+');

            $input = $this->_headerGen();
            $input .= "\n";
            $input .= $this->_extHeaderGen($table);
            $input .= "\n";
            $input .= $this->_footerGen();

            fputs($file, $input);
            fclose($file);
        }
    }

    private function _headerGen(){
        $input  = "<?php\n";
        $input .= "/**\n";
        $input .= " * Generated by eXtal\n";
        $input .= " * Date: ".date('d/m/y')."\n";
        $input .= " * Time: ".date('h:i')."\n";
        $input .= " */\n";
        return $input;
    }

    private function _extHeaderGen($table){
        $input  = "namespace Applications\\".APP_NAME."\\Models\\ORM;\n";
        $input .= "\n";
        $input .= "use Applications\\".APP_NAME."\\Models\\ORM\\Base\\base".ucfirst($table[0]).";\n";
        $input .= "\n";
        $input .= "class e".ucfirst($table[0])." extends base".ucfirst($table[0])." {\n";
        return $input;
    }

    private function _baseHeaderGen($table){
        $input  = "namespace Applications\\".APP_NAME."\\Models\\ORM\\Base;\n";
        $input .= "\n";
        $input .= "use Applications\\OneTry\\Models\\ORM\\e".ucfirst($table[0]).";\n";
        $input .= "use Library\\Application;\n";
        $input .= "\n";
        $input .= "class base".ucfirst($table[0])." {\n";
        return $input;
    }

    private function _baseConstGen($table, $describe){
        $input  = "\t// **********************\n";
        $input .= "\t// CONST DECLARATION\n";
        $input .= "\t// **********************\n";
        $input .= "\tconst TABLE = '".strtolower($table[0])."';\n";
        $input .= "\n";
        foreach ($describe as $field) {
            $input .= "\tconst ".strtoupper($field->Field)." = '".strtolower($field->Field)."';\n";
        }
        return $input;
    }

    private function _baseAttrGen($describe){
        $input  = "\t// **********************\n";
        $input .= "\t// ATTRIBUTE DECLARATION\n";
        $input .= "\t// **********************\n";
        foreach ($describe as $field) {
            $input .= "\t".'protected $'.strtolower($field->Field).";\n";
        }
        return $input;
    }

    private function _baseConstructGen($describe){
        $params = '';
        $end = end($describe);
        foreach ($describe as $field) {
            $params .= ($field != $end) ? '$'.strtolower($field->Field).' = null, ' : '$'.strtolower($field->Field.' = null');
        }

        $input  = "\t// **********************\n";
        $input .= "\t// CONSTRUCTOR METHOD\n";
        $input .= "\t// **********************\n";
        $input .= "\tpublic function __construct(".$params."){\n";
        foreach ($describe as $field) {
            $input .= "\t\t".'$this->'.strtolower($field->Field)." = $".strtolower($field->Field).";\n";
        }
        $input .= "\t}\n";
        return $input;
    }

    private function _baseAccessorGen($describe){
        $input  = "\t// **********************\n";
        $input .= "\t// ACCESSOR METHODS\n";
        $input .= "\t// **********************\n";
        foreach ($describe as $field) {
            $input .= "\tpublic function ".strtolower($field->Field)."(){\n";
            $input .= "\t\t".'return $this->'.strtolower($field->Field).";\n";
            $input .= "\t}\n";
            $input .= "\n";
            $input .= "\tpublic function set".ucfirst($field->Field)."($".strtolower($field->Field)."){\n";
            $input .= "\t\t".'$this->'.strtolower($field->Field)." = $".strtolower($field->Field).";\n";
            $input .= "\t}\n";
        }
        return $input;
    }

    private function _baseLoadGen($table){
        $input  = "\t// **********************\n";
        $input .= "\t// SELECT METHOD / LOAD ALL\n";
        $input .= "\t// **********************\n";
        $input .= "\tpublic static function doSelect(".'$sql, $param = array()'."){\n";
        $input .= "\t\t".'$stmt = Application::instance()->pdo()->mysql()->prepare($sql);'."\n";
        $input .= "\t\t".'$stmt->execute($param);'."\n";
        $input .= "\t\t".'return $stmt->fetchAllObjectOfClass("e'.ucfirst($table[0]).'");'."\n";
        $input .= "\t}\n";
        return $input;
    }

    private function _baseRetrieveGen($table, $primaries){
        $PKs = '';
        $sql = 'SELECT * FROM '.strtolower($table[0]).' WHERE ';
        $end = end($primaries[0]);
        foreach ($primaries[0] as $primary) {
            $PKs .= ($primary != $end) ? '$'.$primary.', ' : '$'.$primary;
            $sql .= ($primary != $end) ? $primary.' = ? AND ' :  $primary.' = ?';
        }

        $input  = "\t// **********************\n";
        $input .= "\t// RETRIEVE BY PRIMARY KEY\n";
        $input .= "\t// **********************\n";
        $input .= "\t/**\n";
        $input .= "\t * @return e".ucfirst($table[0])."\n";
        $input .= "\t */\n";
        $input .= "\tpublic static function retrieveByPk(".$PKs."){\n";
        $input .= "\t\t".'$stmt = Application::instance()->pdo()->mysql()->prepare("'.$sql.'");'."\n";
        $input .= "\t\t".'$stmt->execute(array('.$PKs.'));'."\n";
        $input .= "\t\t".'return $stmt->fetchObjectOfClass("e'.ucfirst($table[0]).'");'."\n";
        $input .= "\t}\n";
        return $input;
    }

    private function _baseInsertGen($table, $describe){
        $sets = '';
        $params = '';
        $values = '';
        $end = end($describe);
        foreach ($describe as $field) {
            $sets .= ($field != $end) ? strtolower($field->Field).', ' : strtolower($field->Field);
            $params .= ($field != $end) ? '?, ' : '?';
            $values .= ($field != $end) ? '$this->'.strtolower($field->Field).', ' : '$this->'.strtolower($field->Field);
        }

        $input  = "\t// **********************\n";
        $input .= "\t// INSERT\n";
        $input .= "\t// **********************\n";
        $input .= "\tpublic function insert(){\n";
        $input .= "\t\t".'$stmt = Application::instance()->pdo()->mysql()->prepare("INSERT INTO '.strtolower($table[0]).' ('.$sets.') VALUES ('.$params.');");'."\n";
        $input .= "\t\t".'$stmt->execute(array('.$values.'));'."\n";
        $input .= "\t}\n";
        return $input;
    }

    private function _baseUpdateGen($table, $primaries){
        $sets = '';
        $params = '';
        $values = '';
        $end = end($primaries[1]);
        foreach ($primaries[1] as $field) {
            $sets .= ($field != $end) ? $field.' = ?, ' : $field.' = ? ';
            $values .= '$this->'.$field.', ';
        }
        $end = end($primaries[0]);
        foreach ($primaries[0] as $primary) {
            $params .= ($primary != $end) ? $primary.' = ? AND ' :  $primary.' = ?';
            $values .= ($primary != $end) ? '$this->'.$primary.', ' : '$this->'.$primary;
        }

        $input  = "\t// **********************\n";
        $input .= "\t// UPDATE\n";
        $input .= "\t// **********************\n";
        $input .= "\tpublic function update(){\n";
        $input .= "\t\t".'$stmt = Application::instance()->pdo()->mysql()->prepare("UPDATE '.strtolower($table[0]).' SET '.$sets.' WHERE '.$params.';");'."\n";
        $input .= "\t\t".'$stmt->execute(array('.$values.'));'."\n";
        $input .= "\t}\n";
        return $input;
    }

    private function _baseDelGen($table, $primaries){
        $params = '';
        $values = '';
        $end = end($primaries[0]);
        foreach ($primaries[0] as $primary) {
            $params .= ($primary != $end) ? $primary.' = ? AND ' :  $primary.' = ?';
            $values .= ($primary != $end) ? '$this->'.$primary.', ' : '$this->'.$primary;
        }

        $input  = "\t// **********************\n";
        $input .= "\t// DELETE\n";
        $input .= "\t// **********************\n";
        $input .= "\tpublic function delete(){\n";
        $input .= "\t\t".'$stmt = Application::instance()->pdo()->mysql()->prepare("DELETE FROM '.strtolower($table[0]).' WHERE '.$params.';");'."\n";
        $input .= "\t\t".'$stmt->execute(array('.$values.'));'."\n";
        $input .= "\t}\n";
        return $input;
    }

    private function _footerGen(){
        $input = "}";
        return $input;
    }

    private function _searchPrimaries($describe){
        $primaries = array();
        $others = array();
        foreach ($describe as $field) {
            if($field->Key == "PRI") {
                $primaries[] = $field->Field;
            }else{
                $others[] = $field->Field;
            }
        }
        return array($primaries, $others);
    }
}