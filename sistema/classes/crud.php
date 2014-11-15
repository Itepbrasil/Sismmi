<?php
/**
 * Description of crud
 *
 * @author Flavio Henrique Curte
 * @author por Carlos Eduardo Kdu
 * email flavio@flaviocurte.eng.br
 * email carloskdu@itepbrasil.net
 * website: http://flaviocurte.eng.br/
 * website: http://itepbrasil.net
 * @version 1.0 (Release January-2012)
 * DataBase: Postgres
 * @project classes
 */
class crud {
    public $host = "";
    public $user = "";
    public $pswd = "";
    public $dbname = "";
    public $conn = null;  
    /*
     * This funcion is always used to connect into the database
    */
    private function connDB() {
        /*
         * You have to change the file _mysql_db.inc_ to the right configutation for your server
         * such as: user, pass, address
        */
        include('pgsql.inc');
        //$HOST = "192.168.1.6";
        //$PORTA = "5432";
        //$USER = "postgres";
        //$PASS = "senhaPo";
        //$DATB = "academic";
        
        $this->host = $HOST;
        $this->port = $PORTA;
        $this->user = $USER;
        $this->pswd = $PASS;
        $this->dbname = $DATB;
        
        //ALTERE PARA O IP DA SUA MÁQUINA E DESCOMENTE A LINHA ABAIXO PARA DEBUGAR A SQL QUE ESTA SENDO EXECUTADO NA CLASSE        
        //$this->ip_busca = '192.168.1.44';
        
        $con_string = "host=$this->host port=$this->port dbname=$this->dbname user=$this->user password=$this->pswd options='--client_encoding=UTF8'";
        //$con_string = "host=192.168.1.6 port=5432 dbname=academic user=postgres password=senhaPo";
        $dbcon = pg_pconnect($con_string);
        //if(!$dbcon = pg_pconnect($con_string)) die ("Erro ao conectar ao banco<br>".pg_last_error($dbcon));       
        $this->conn = $dbcon;
        /*
         * Set all the content to UTF8 by default
         * connBD is used to open every connection. So it means that either to insert or to read the charset will be set to UTF8
        */
       // mysql_set_charset('utf8',$this->conn);
        
    }

    /*
     * Function used to close a connection with a database
    */
    private function closeConn() {
        pg_close($this->conn);// show a erro when is not possible to close the connection
    }

    /**
     * Function used to CREATE (INSERT) a new content into a specific database
     *
     * This function get an array with all the information inside.
     *
     * The rules to be followd are listed bellow
     *
     * @param $ArrayCreate = is an array
     * @desc $ArrayCreate[table] = is a string with the name of the table eg. 'contact'
     * @desc $ArrayCreate[fields][_field_name_] = is a bidimensional array. Inside the array 'fields' is
     * an unidimensional array where the name of the array referes to the name od the field (form/input name)
     * and the content is the actual value of this field (form/input value)
     *
     * @example $ArrayCreate["table"] = "contact"
     *          $ArrayCreate["fields"]["name"] = 'Flavio Curte'
     *          $ArrayCreate["fields"]["email"] = 'php@flaviocurte.eng.br'
     *          $ArrayCreate["fields"]["message"] = 'Here is the content und so on...'
     *
     * @return String (1=success)
     */
    function create($ArrayCreate) {
        $table = "".$ArrayCreate["table"].""; // put in the right way for mysql with `name`

        /*
         * Here a function count gets the number of fields submitted to later on separete them in fields and values
        */
        $count = count($ArrayCreate["fields"]);

        /*
         * Organise the fields and values into a numeric array
        */
        $a = 0;
        foreach ($ArrayCreate["fields"] as $field => $value) {
            $fields[$a] = $field;
            $values[$a] = $value;
            $a++;
        }

        /*
         * The variable $query will be created by parts.
        */
        $query = "INSERT INTO $table ("; //set the begining of the query

        /*
         * This _for_ will take every field (name) and organise into the right way between `` and ,
        */
        for ($i=0;$i<$count;$i++) {
            $query.= "".$fields[$i]."";
            $x = $i+1;
            if ($x != $count) {
                $query.= ",";
            }
        }

        $query.= ") VALUES ("; //set the second part of the query

        /*
         * This _for_ will take every field (value) and organise into the right way between `` and ,
        */
        for ($j=0;$j<$count;$j++) {
            $query.= "'".$values[$j]."'";
            $y = $j+1;
            if ($y != $count) {
                $query.= ",";
            }
        }

        $query.= ");"; // finishes the variable $query.

		  /*
             * The variable $query is done an now it can be inserted into the database
            */
            
            $this->ConnDB(); // open a new connection with the database
            
//            //MOSTRA O SQL SOMENTE NO MEU IP
//            $ip = getenv("REMOTE_ADDR"); 
//            $host = gethostbyaddr("$ip"); 
//            if ($ip == $this->ip_busca)
//            { echo $query;
//            } //echo $query;
            //echo $query;          
           // echo $ArrayCreate["debug"];
            
            if ($ArrayCreate["debug"]=='yes' || $ArrayCreate["debug"]=='YES')
                echo  $query;

            $result = @pg_exec($this->conn, $query);
             if (!$result) { //printf ("ERROR");
                 $errormessage = pg_errormessage($this->conn);
                 //echo $errormessage;
                 //exit;
             }
//            /*
//             * Here the results will be organized into an array and the variable $VAR will be returned with the results
//            */
//		
//            $getRegistro = array(
//                "function" => "log_erro",
//                "parameters" => "'$query', 'Inserindo dados '"
//            );
//
//            $this->exec_function($getRegistro);
//
//             
             
            $this->closeConn(); // Close the connection anyway
            
            /*
             * By default, when the insert is well succeded, return is 1
            */		
	    return $errormessage;
    }

    /**
     * Function used to READ a content into a specific database
     *
     * This function get an array with all the needed information inside.
     *
     * The rules to be followd are listed bellow
     *
     * $ArrayRead = array("table" => "jas_mural", "order" => "id DESC");
     *
     * @param $ArrayRead = is an array
     * @desc    $ArrayRead[table] = <string> with the name of the table eg, 'contact'
     *          $ArrayRead[fields] = <string> with the fields to be selected eg, 'id,name'
     *          $ArrayRead[where] = <string> with the full condition for where eg, 'id = 1', name = 'flavio'
     *          $ArrayRead[order] = <string> where the content is either a value ASC or DESC eg, 'name ASC'
     *          $ArrayRead[limit] = <string> where the first number is the 'start from' and the second is 'how many lines after' eg, '0, 5'
     *
     * @return Array Array[count][field] = value
     */
    function read($ArrayRead) {

        $table = $ArrayRead["table"]; // Get the name of the table

        /*
         * The lines bellow will check if there is any condition set for the conditions.
         * If not, clean (unset) the corresponding variable to do not have any error after
        */

        /*
         * Checking condition 'fields'
        */
        if (isset($ArrayRead["fields"])) {
            $fields = $ArrayRead["fields"];
        } else $fields = "*";

        /*
         * Checking condition 'JOIN'
        */
        if (isset($ArrayRead["join"])) {
            $join = $ArrayRead["join"]." ";
        } else unset($join);


        /*
         * Checking condition 'where'
        */
        if (isset($ArrayRead["where"])) {
            //criado teste porque diferente do oracle e mysql o postgres não aceita 1 na where
            if ($ArrayRead["where"]=='1')
            { $where = "";} else { $where = "WHERE ".$ArrayRead["where"]." ";}
            
            
        } else unset($where);

		/*
         * Checking condition 'group' by
        */
        if (isset($ArrayRead["group"])) {
            $group = "GROUP BY ".$ArrayRead["group"]." ";
        } else unset($group);
		
        /*
         * Checking condition 'order' by
        */
        if (isset($ArrayRead["order"])) {
            $order = "ORDER BY ".$ArrayRead["order"]." ";
        } else unset($order);

        /*
         * Checking condition 'limit'
        */
        if (isset($ArrayRead["offset"])) {
            $limit = "offset ".$ArrayRead["offset"];
        } else unset($limit);    
        
        
        
        $this->ConnDB(); // open a new connection with the database
        $SQL = "select $fields FROM $table $join $where $group $order $limit"; // put the SELECT all together
        
        
        if ($ArrayRead["debug"]=='yes' || $ArrayRead["debug"]=='YES')
                echo  $SQL;
        
        
	$QUERY = pg_query($SQL); // execute
        $VAR = array();
        $i = 0;         
        /*
         * Here the results will be organized into an array and the variable $VAR will be returned with the results
        */

        while ($DAT = pg_fetch_array($QUERY, NULL, PGSQL_ASSOC)) {
            $countDat = count($DAT); // Get the size of the results. For example size 2 means two fields (id, name)            
            foreach($DAT as $field => $value) {
                $VAR[$i][$field] = $value;             
            }
            $i++;
        }        
            // parado o log de consulta 19_03_2012
            /*$getRegistro = array(
                "function" => "log_erro",
                "parameters" => "'$SQL', 'executando consultas'"
            );

            $this->exec_function($getRegistro);*/

        $this->closeConn(); // close connection with the database
        return $VAR;
    }

    /**
     * Function used to DELETE a register into a database.
     *
     * This function get an array with all the needed information inside.
     *
     * The rules to be followed are listed bellow
     *
     * $ArrayDelete = array("table" => "table_name", "column" => "column_name", "value" => "value");
     *
     * @param $ArrayDelete = is an array
     * @desc    $ArrayDelete[table] = <string> with the name of the table eg, 'contact'
     *          $ArrayDelete[column] = <string> with the name of the column (PK) eg, 'id'
     *          $ArrayDelete[value] = <string> with the value (reference, KEY) to delete eg, '26' ** would delete the register 26 in the primary key coloumn ID
     *
     * @return value where value = 1 is succesful
     */
    function delete($ArrayDelete) {

        $table = $ArrayDelete["table"];
        $column = $ArrayDelete["column"];
        $value = $ArrayDelete["value"];
        
        $this->ConnDB(); // open a new connection with the database
         
        $query = "DELETE FROM $table WHERE $column = $value";
	               

//		$ip = getenv("REMOTE_ADDR"); 
//		$host = gethostbyaddr("$ip"); 
//		if ($ip == $this->ip_busca)
//		{ echo $query; 
//                
//		}
		 
    //        echo $query;
        if ($ArrayDelete["debug"]=='yes' || $ArrayDelete["debug"]=='YES')
                echo  $query;
        
        
             $result = @pg_exec($this->conn, $query);
             if (!$result) { 
                 $errormessage = pg_errormessage($this->conn);
             }            
             
             
         $this->closeConn(); 
        /*
         * By default, when deleted is succeded, return is equal 1
        */
        return $errormessage;
    }

    /**
     * Function used to UPDATE a register
     *
     * This function get an array with all the information inside.
     *
     * The rules to be followd are listed bellow
     *
     * @param $ArrayUpdate = is an array
     * @desc $ArrayUpdate[table] = is a string with the name of the table eg. 'user'
     * @desc $ArrayUpdate[fields][_field_name_] = is a bidimensional array. Inside the array 'fields' is
     * an unidimensional array where the name of the array referes to the name of the field (form/input name)
     * and the content is the actual value of this field (form/input value)
     * @desc $ArrayUpdate[where] = is a string with the condition to update the content eg. 'id=1'
     *
     * @example $ArrayUpdate["table"] = "contact"
     *          $ArrayUpdate["fields"]["name"] = "Flavio Curte"
     *          $ArrayUpdate["fields"]["email"] = "php@flaviocurte.eng.br"
     *          $ArrayUpdate["fields"]["message"] = "Here will go the new message"
     *          $ArrayUpdate["where"] = "id=1"
     *
     * @return String (1=success)
     */
    function update($ArrayUpdate) {
        $table = $ArrayUpdate["table"];
        $where = $ArrayUpdate["where"];

        /*
         * Here a function count gets the number of fields submitted to later on separete them in fields and values
        */
        $count = count($ArrayUpdate["fields"]);
        
        /*
         * Organise the fields and values into a numeric array
        */
        $b = 0;
        foreach ($ArrayUpdate["fields"] as $field => $value) {
            $fields[$b] = $field;
            $values[$b] = $value;
            $b++;
        }
        /*
         * The variable $query will be created by parts.
        */
        $query = "UPDATE $table SET "; //set the begining of the query

        /*
         * This _for_ will take every field (name and value) and organise into the right way between `` and ,
        */
        $z = 0;
        for ($i=0;$i<$count;$i++) {
            
            //modificado para verificar uma atualização da função now 
            // e fazer atualizacao usando timestamp
            if ($values[$i]=='now()')
            {
                $query.= "".$fields[$i]." = ".$values[$i];
            } else if ($values[$i]=='null')
                    {
                       $query.= "".$fields[$i]." = null";
                    } else
                         {
                            $query.= "".$fields[$i]." = '".$values[$i]."'";
                         }
            $z = $i+1;
            if ($z != $count) {
                $query.= ",";
            }
        }
        $query.= " WHERE $where;";
    
        //MOSTRA O SQL SOMENTE NO MEU IP
//		$ip = getenv("REMOTE_ADDR"); 
//		$host = gethostbyaddr("$ip"); 
//		if ($ip == $this->ip_busca)
//		{  
//                   echo $query;
//		} echo $query;
        /*         * The variable $query is done an now it can be inserted into the database
        */
	//echo $query;
        
        if ($ArrayUpdate["debug"]=='yes' || $ArrayUpdate["debug"]=='YES')
            echo  $query;
        
        $this->ConnDB(); // open a new connection with the database
   
        //$QUERY = pg_query($query); // execute
         $errormessage = null;
         
         $result = pg_exec($this->conn, $query);
             if (!$result) { printf ("ERROR");
                 $errormessage = pg_errormessage($this->conn);
             }
        $this->closeConn();
   
        /*
         * By default, when the update is succeded, return is 1
        */
        return $errormessage;
    }
    
     /**
     * Function used to READ a content into a specific database
     *
     * This function get an array with all the needed information inside.
     *
     * The rules to be followd are listed bellow
     *
     * $ArrayRead = array("table" => "jas_mural", "order" => "id DESC");
     *
     * @param $ArrayRead = is an array
     * @desc    $ArrayRead[table] = <string> with the name of the table eg, 'contact'
     *          $ArrayRead[fields] = <string> with the fields to be selected eg, 'id,name'
     *          $ArrayRead[where] = <string> with the full condition for where eg, 'id = 1', name = 'flavio'
     *          $ArrayRead[order] = <string> where the content is either a value ASC or DESC eg, 'name ASC'
     *          $ArrayRead[limit] = <string> where the first number is the 'start from' and the second is 'how many lines after' eg, '0, 5'
     *
     * @return Array Array[count][field] = value
     */
    function seq_nextval($ArrayRead) {

         $sequece_name = $ArrayRead["sequece_name"];
        
        $this->ConnDB(); // open a new connection with the database
        $SQL = "SELECT nextval('".$sequece_name."');"; // put the SELECT all together

        //echo  $SQL;                
	$QUERY = pg_query($SQL); // execute
        $VAR = array();
        $i = 0;         
        
        while ($DAT = pg_fetch_array($QUERY, NULL, PGSQL_ASSOC)) {
            $countDat = count($DAT); // Get the size of the results. For example size 2 means two fields (id, name)            
            foreach($DAT as $field => $value) {
                $VAR[$i][$field] = $value;             
            }
            $i++;
        }                       
            
        $this->closeConn(); // close connection with the database
        return $VAR;
    }

    
    function exec_function($ArrayRead) {

         $function_name = $ArrayRead["function"];
         $parameters = $ArrayRead["parameters"];
        
        $this->ConnDB(); // open a new connection with the database
        $SQL = "SELECT $function_name(".$parameters.");"; 

        //echo  $SQL;                
	$QUERY = pg_query($SQL); // execute
        $VAR = array();
//        $i = 0;         
        
//        while ($DAT = pg_fetch_array($QUERY, NULL, PGSQL_ASSOC)) {
//            $countDat = count($DAT); // Get the size of the results. For example size 2 means two fields (id, name)            
//            foreach($DAT as $field => $value) {
//                $VAR[$i][$field] = $value;             
//            }
//            $i++;
//        }
            
        $this->closeConn(); // close connection with the database
        return $VAR;
    }
    
    
    
}
?>
