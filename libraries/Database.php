<?php namespace Libraries;

use PDO;
use Exception;
use System\BaseConfig;

/**
 * Class that acts as abstract layer with the database, based on PDO.
 * @author David Unay Santisteban <slavepens@gmail.com>
 * @package SlaveFramework
 * @subpackage Libraries
 * @version 2.8.20140310
 */
Class Database
{

    /**
     * DB config.
     * @var BaseConfig
     */
    private $cfg;
    /**
     * PDO object.
     * @var Object
     */
    private $instance;

    /**
     * Prepared statements object.
     * @var Object
     */
    private $stmt;

    /**
     * Errors Array.
     * @var array
     */
    private $error = array();

    /**
     * State of the transaction. TRUE=OK / FALSE=FAIL
     * @var int
     */
    private $sentinel = TRUE;

    /**
     * Affected rows by a query.
     * @var int
     */
    private $affectedRows = 0;

    /**
     * Number of rows in a select.
     * @var int
     */
    private $countRows = 0;

    /**
     * Class constructor.
     */
    public function __construct($setup = 'DefaultDB')
    {
        $configuration = "Configuration\\Database\\" . $setup;
        $this->cfg = new $configuration();
        try {
            $this->instance = new PDO(
                $this->cfg->driver . ':host=' . $this->cfg->dbhost . ';dbname=' . $this->cfg->dbname,
                $this->cfg->dbuser,
                $this->cfg->dbpass
            );
            return $this->instance;
        } catch (Exception $e) {
            die ("There was an error in connection with the BD.");
        }
    }

    /**
     * Executes an SQL statement
     * @param type $sql SQL query to execute
     * @param type $params params for the query
     */
    public function query($sql, $params = null)
    {
        if (isset($this->cfg->prefix)) {
            $sql = str_replace('#__', $this->cfg->prefix, $sql);
        }
        $this->stmt = $this->instance->prepare($sql);
        $this->stmt->execute($params);
        $this->checkQuery();
    }

    /**
     * Load one single result (one cell).
     * @return mixed
     */
    public function loadResult()
    {
        $singleResult = $this->stmt->fetch(PDO::FETCH_NUM);
        return $singleResult[0];
    }

    /**
     * Load a column values.
     * @return array
     */
    public function loadColumn()
    {
        $columnList = array();
        while ($row = $this->stmt->fetch(PDO::FETCH_NUM)) {
            $columnList[] = $row[0];
        }
        $this->countRows = count($columnList);
        return $columnList;
    }

    /**
     * Return a object with the result of the query like properties
     * @param string $class_name class name, by default stdClass
     * @return object
     */
    public function loadObject($class_name = "stdClass")
    {
        $object = $this->stmt->fetchObject($class_name);
        return $object;
    }

    /**
     * Return an array of objects.
     * @param string $class_name class name, by default stdClass
     * @return array
     */
    public function loadObjectList($class_name = "stdClass")
    {
        $objectList = array();
        while ($object = $this->stmt->fetchObject($class_name)) {
            $objectList[] = $object;
        }
        $this->countRows = count($objectList);
        return $objectList;
    }

    /**
     * Return a single assoc array.
     * @return array
     */
    public function loadAssocRow()
    {
        $assocRow = $this->stmt->fetch(PDO::FETCH_ASSOC);
        return $assocRow;
    }

    /**
     * Return a list of assoc arrays
     * @return array
     */
    public function loadAssocList()
    {
        $assocList = array();
        while ($row = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
            $assocList[] = $row;
        }
        $this->countRows = count($assocList);
        return $assocList;
    }

    /**
     * Return a sigle indexed array.
     * @return array
     */
    public function loadIndexedRow()
    {
        $indexedRow = $this->stmt->fetch(PDO::FETCH_NUM);
        return $indexedRow;
    }

    /**
     * Return a list of indexed arrays.
     * @return array
     */
    public function loadIndexedList()
    {
        $indexedList = array();
        while ($row = $this->stmt->fetch(PDO::FETCH_NUM)) {
            $indexedList[] = $row;
        }
        $this->countRows = count($indexedList);
        return $indexedList;
    }

    /**
     * Return a sigle row query like JSON
     * @return string
     */
    public function loadJsonObject()
    {
        $jsonObject = json_encode($this->stmt->fetch(PDO::FETCH_ASSOC));
        return $jsonObject;
    }

    /**
     * Return multi row result like JSON.
     * @return string
     */
    public function loadJsonObjectList()
    {
        $index = 1;
        $jsonObjectList = "";
        while ($row = $this->loadAssocList()) {
            $jsonObjectList .= json_encode($row);
            if ($index <= (count($this->loadAssocList()) - 1)) {
                $jsonObjectList .= ",";
            }
        }
        return $jsonObjectList;
    }

    /**
     * Return multi row result like XML.
     * @param string $version version of the XML.
     * @param string $encoding encoding of the XML.
     * @param string $root father element of the document
     * @param string $elementName child elements of the documents.
     * @return string
     */
    public function loadXmlDocument($file = null, $root = 'query', $elementName = 'entry')
    {
        $xml = new DOMDocument('1.0', 'utf-8');
        $table = $xml->createElement($root);
        foreach ($this->loadAssocList() as $entry) {
            $element = $xml->createElement($elementName);
            foreach ($entry as $node => $value) {
                if ($this->valideXmlValue($value)) {
                    $field = $xml->createElement($node, $value);
                    $element->appendChild($field);
                } else {
                    $field = $xml->createElement($node);
                    $cdata = $xml->createCDATASection($value);
                    $field->appendChild($cdata);
                    $element->appendChild($field);
                }
            }
            $table->appendChild($element);
        }
        $xml->appendChild($table);
        if ($file != null) {
            return file_put_contents($file, $xml->saveXML());
        } else {
            return $xml->saveXML();
        }
    }

    /**
     * Start a transaction.
     */
    public function startTransaction()
    {
        $this->instance->beginTransaction();
        $this->sentinel = TRUE;
        $this->affectedRows = 0;
    }

    /**
     * Checks if the transaction was successful
     * @return int return 1 on commit or 0 at rollback
     */
    public function endTransaction()
    {
        if ($this->sentinel === TRUE) {
            $this->instance->commit();
        } else {
            $this->instance->rollBack();
        }
        return $this->sentinel;
    }

    /**
     * Return the affected rows
     * @return int
     */
    public function getAffectedRows()
    {
        return $this->affectedRows;
    }

    /**
     * Return the num rows
     * @return int
     */
    public function getCountRows()
    {
        return $this->countRows;
    }

    /**
     * Return the last query error.
     * @return array
     */
    public function getError()
    {
        $e = array();
        $e['ref'] = $this->error[0];
        $e['code'] = $this->error[1];
        $e['desc'] = $this->error[2];
        return $e;
    }

    /**
     * Return the last inserted id.
     * @return type
     */
    public function getLastId()
    {
        return $this->instance->lastInsertId();
    }

    /**
     * Checks if the query was successful
     */
    private function checkQuery()
    {
        $this->error = $this->stmt->errorInfo();
        if ($this->error[0] != 00000) {
            $this->sentinel = FALSE;
        }
        // always return 1 on a SELECT
        $this->affectedRows = $this->stmt->rowCount();
    }

    /**
     * Check illegal characters in the field value
     * to mark it as a CDATA element.
     * @param mixed $value
     * @return boolean
     */
    private function valideXmlValue($value)
    {
        $chars = array('<', '>', '&');
        foreach ($chars as $ilegal) {
            $state = strpos($value, $ilegal);
            if ($state !== FALSE) {
                return FALSE;
            }
        }
        return TRUE;
    }
}