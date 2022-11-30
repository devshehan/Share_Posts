<?php
      /*
   * PDO Database Class
   * Connect to database
   * Create prepared statements
   * Bind values
   * Return rows and results
   */

   class Database{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $databaseName = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
        // set database source name(DSN)
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->databaseName;

        // option requiries
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try{
            //create a connection with database
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
            $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
            echo "connection is successful";

        }catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // prepare statement with query
    public function prepareQuery($sql){
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * if we want to insert data into the database need to parameter , value and type
     * therefore need to check every element's type
     * */ 

    public function bind($parameter, $value, $type = null){
        if(is_null($type)){
            switch(true){
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

        //bind values
        $this->stmt->bindValue($parameter, $value, $type);
    }

    //execute prepared question
    public function executeStmt(){
        $this->stmt->execute();
    }

    //get result set
    public function resultSet(){
        $this->executeStmt();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //get single record as the object
    public function single(){
        $this->executeStmt();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    //get row count
    public function rowCount(){
        return $this->stmt->rowCount();
    }




   }