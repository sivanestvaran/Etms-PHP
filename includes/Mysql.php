<?php
class MYSQL
{
    private $server = "localhost";
    private $database = "etms";
    private $user = "root";
    private $pass = "";

    private $conn = null;

    function connect()
    {
        if (!isset($conn)) {
            $this->conn = new mysqli($this->server, $this->user, $this->pass, $this->database);

            if ($this->conn->connect_error) {
                die("There was a connection issue" . $this->conn->connect_error);
            }
        }
    }

    function close()
    {
        if (isset($this->conn)) {
            $this->conn->close();
        }
    }

    function GetTableData($mode, $sql, $types = null, ...$param)
    {
        $id = $id ?? 0;
        $mode = strtoupper($mode);
        $this->connect();
        $stmt = $this->conn->prepare($sql);
        switch ($mode) {
            case "DT":
                $stmt->execute();
                $result = $stmt->get_result();
                break;
            case "DR":
                $stmt->bind_param($types, ...$param);
                $stmt->execute();
                $result = $stmt->get_result();
                break;
        }

        $this->close();
        return $result; // $result->fetch_all(MYSQLI_ASSOC)
        //var_dump($result);
        //$data = $result->fetch_all(MYSQLI_ASSOC);
        // echo"<br/>";
        //var_dump($data);


    }

    function Execute($sql, $types = null, ...$params)
    {
        $this->connect();
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $inserted_id = $this->conn->insert_id;
        $affected_rows = $this->conn->affected_rows;
        $this->close();

        return ["inserted_id" => $inserted_id, "affected_rows" => $affected_rows];
    }

}

/*$test = new MYSQL();*/

//Method 1 ---------------------------------------------------------------------------
/*$dt = $test->GetTableData("Select * from sample");
$dt = $dt->fetch_all(MYSQLI_ASSOC);
echo "<br/>";
//var_dump($dt);
echo "<h2>Select All Rows</h2>";
foreach ($dt as $row) {
    echo "<p>".$row['name']." | ".$row['email']." | ". $row['age']."</p>";
}*/

//Method 2 ----------------------------------------------------------------------------

/*$dt = $test->GetTableData("Select * from sample");
echo "<br/>";
//var_dump($dt);
echo "<h2>Select All Rows</h2>";
foreach ($dt as $row) {
    echo "<p>" . $row['name'] . " | " . $row['email'] . " | " . $row['age'] . "</p>";
}
//--------------------------------------------------------------------------------------
unset($dt, $row); //destroy variable

$dt = $test->GetTableData("Select * from sample where id=23");

echo "<h2>Select By ID - Search</h2>";
if ($dt->num_rows == 0) {
    echo "<p style='color:red;'>No such ID exist !!</p>";
} else {
    $dr = $dt->fetch_assoc();
    echo "<p>" . $dr['name'] . " | " . $dr['email'] . " | " . $dr['age'] . "</p>";
}*/


?>