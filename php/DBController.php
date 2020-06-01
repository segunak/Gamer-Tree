<?php
/*
 *Database connection class
 */
class DBController
{
    /* Set login credentials. Pulled from ini file in final version */
    private $host = "************";
    private $user = "*********";
    private $password = "***********";
    private $database = "***********";
    private $conn;

    /* establish constructor*/
    public function __construct()
    {
        $this->conn = $this->connectDB();
    }

    /* establishes a connection to database*/
    public function connectDB()
    {
        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        return $conn;
    }

    public function runQuery($query)
    {
        $result = mysqli_query($this->conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        if (!empty($resultset)) {
            return $resultset;
        }

    }

    public function numRows($query)
    {
        $result = mysqli_query($this->conn, $query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }

    public function updateQuery($query)
    {
        $result = mysqli_query($this->conn, $query);
        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            return $result;
        }
    }

    public function insertQuery($query)
    {
        $result = mysqli_query($this->conn, $query);
        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            return mysqli_insert_id($this->conn);
        }
    }

    public function addTokenQuery($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
            return $result;
        } else {
            return $result;
        }
    }

    public function deleteQuery($query)
    {
        $result = mysqli_query($this->conn, $query);
        if (!$result) {
            die('Invalid query: ' . mysqli_error());
        } else {
            return $result;
        }
    }

    public function generateNewString($len = 10)
    {
        $token = "poiuztrewqasdfghjklmnbvcxy1234567890";
        $token = str_shuffle($token);
        $token = substr($token, 0, $len);

        return $token;
    }

    public function getTeamLimit($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row["TeamLimit"];
            }
        }
    }

    public function getUserID($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row["UserID"];
            }
        }
    }

    public function getUserTeamID($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row["TeamID"];
            }
        }
    }

    public function getUserTeamName($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row["TeamName"];
            }
        }
    }

    public function getCount($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            while ($row = mysqli_fetch_array($result)) {
                return $row[0];
            }
        }
    }

    public function getEmail($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row["Creator"];
            }
        }
    }

    public function getImage($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                return $row["file"];
            }
        }
    }
}
