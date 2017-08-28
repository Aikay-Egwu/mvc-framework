<?php
namespace Codenest\Library ;

use PDO ;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Database extends PDO
{
    private $stmt;
    public $dbError;
    private $dbString;
    private $error;
//Config::get('site_name')
    //connect to database

    public function __construct()
    {
//$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => 'ERRMODE_EXCEPTION');
        try {
            parent::__construct(Config::get('host') . Config::get('db_name') . Config::get('charset'), Config::get('username'), Config::get('password'), $options);
        } catch (PDOException $exp) {
            echo $exp->getMessage();
        }
    }

    public function dbStatement($query)
    {
        $this->stmt = $this->prepare($query);
    }

    public function dbExecute($param = null)
    {
        $this->stmt->execute($param);
    }

    /*public function dbExecute(){
    $this->stmt->execute();
    }*/

    private function dbBind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    private function dbLoadParam($param)
    {
        if (!is_null($param)) {
            foreach ($param as $key => $value) {
                $this->dbBind($key, $value);
            }
        }
    }

    //get row
   //get row
    public function dbGetRow($sql, $param = null)
    {
        try {
            $this->dbStatement($sql);
            $this->dbExecute($param);
            if ($this->stmt->errorCode()==0) {
                return $this->stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->saveError();
            }
            return false ;
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage, 1);
            $this->dbError = $ex->getMessage;
        }
    }

    //get rows
    public function dbGetRows($sql, $param = null)
    {
        try {
            $this->dbStatement($sql);
            $this->dbLoadParam($param);
            $this->dbExecute();
            if ($this->stmt->errorCode() == 0) {
                return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->saveError();
            }
            return false ;
        } catch (PDOException $ex) {
            throw new PDOException($ex->getMessage, 1);
            $this->dbError = $ex->getMessage ;
        }
    }
    private function saveError()
    {
        $error = $this->stmt->errorInfo();
        $error = $error[2]; //extract only the
        $query = "INSERT INTO query_error (bad_query) VALUES (:error)" ;
        $this->dbInsertRow($query, array(':error'=>$error));
    }

    public function dbGetObject($sql, $param = null)
    {
        try {
            $this->dbStatement($sql);
            $this->dbExecute($param);
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage, 1);
            $this->dbError = $ex->getMessage;
        }
    }

    //get rows
    public function dbGetObjects($sql, $param = null)
    {
        try {
            $this->dbStatement($sql);
            $this->dbLoadParam($param);
            $this->dbExecute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage, 1);
        }
    }

    //insert row
    public function dbInsertRow($sql, $param)
    {
        try {
            $this->dbStatement($sql);
            $this->dbLoadParam($param);
            $this->dbExecute();
            if ($this->stmt->errorCode()==0) {
                return true ;
            } else {
                $this->saveError();
            }
            return false;
        } catch (PDOException $ex) {
            $this->error = $ex->getMessage;
            throw new Exception($ex->getMessage, 1);
        }
    }

    //update row
    public function dbUpdateRow($sql, $param)
    {
        try {
            $this->dbStatement($sql);
            $this->dbLoadParam($param);
            $this->dbExecute();
            if ($this->stmt->errorCode()==0) {
                return true;
            } else {
                $this->saveError();
            }
            return false;
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage, 1);
        }
    }

    //delete row
    public function deleteRow($sql, $param)
    {
        try {
            $this->dbStatement($sql);
            $this->dbLoadParam($param);
            $this->dbExecute();
            if ($this->stmt->errorCode()==0) {
                return true ;
            } else {
                $this->saveError();
            }
            return false;
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage, 1);
        }
    }

    //create transactions

    //disconnect  database
    public function disconnect()
    {
    }

    public function dbRowCount()
    {
        return $this->stmt->rowCount();
    }

    public function dbLastInsertId()
    {
        return $this->lastInsertId();
    }

    /**
     * [description here]
     *
     * @return [type] [description]
     */
    public function getDbString()
    {
        return $this->dbString;
    }

/**
 * [description here]
 *
 * @return [type] [description]
 */
    public function getDbError()
    {
        return $this->dbError;
    }

/**
 * [Description]
 *
 * @param [type] $newdbError [description]
 */
    public function setDbError($dbError)
    {
        $this->dbError = $dbError;
        return $this;
    }
}
