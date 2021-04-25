<?php
class DB 
{
    private $mysql;
    private $entities = [];

    //izveido savienojumu
    public function __construct($servername, $username, $password, $dbname){
        
        $this->mysql = new mysqli($servername, $username, $password, $dbname);

        if ($this->mysql->connect_error) {
            die("Connection failed: " . $this->mysql->connect_error);
        }
    }
    public function __deconstruct(){
        $this->mysql->close();
    }

    
    public function fetchAll($table_name){
        $table_name = $this->mysql->escape_string($table_name);
        $result = $this->mysql->query("SELECT * FROM `$table_name`");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $this->entities[$row["id"]] = $row;
            }
        }
        else{
        $this->entities =  [];
        }
    }


    //Atgriež visu tabulu masīvā
    //@return array - tukšs vai tabulas datus
    public function getAll(){
        return $this->entities;
    }

    public function find($id){
        if(array_key_exists($id, $this->entities)){
            return $this->entities[$id];
        }
    }

    //@param string $table_name
    //@param array $values - [$field_name => $field_value]
    //@return string

    public function add(string $table_name, array $entries) {
        $columns = array_keys($entries);

        $first = true;
        $entry_keys = "";
        $field_values = "";
        foreach ($entries as $column => $value) {
            if ($first) {
                $entry_keys .= "`" . $column . "`";
                $field_values .= "'" .  $this->mysql->escape_string($value) . "'";
                $first = false;
            }
            else {
                $entry_keys .= ", `" . $column . "`";
                $field_values .= ", '" .  $this->mysql->escape_string($value) . "'";
            }

        }
        
        //create SQL
        $sql = "INSERT INTO $table_name ($entry_keys) VALUES ($field_values)";
        echo $sql;
        //save to db and check
        if ($this->mysql->query($sql) === true) {
            $id = $this->mysql->insert_id;
            $this->entities[$id] = $entries;
            $this->entities[$id]['id'] = $id;
            return "New record created successfully";
        } else {
            return "Error: " . $sql . "<br>" . $this->mysql->error;
        }
    }

    public function update($id, $username, $email){
        echo "Update test; ID:$id, Username: $username, Email: $email";
    }

    public function delete(string $table_name, $id){

        $sql = "DELETE FROM `$table_name` WHERE id=$id";

        if ($this->mysql->query($sql) === true) {
            unset($this->entities[$id]);
        return true;
        }
        return false;
    }
}