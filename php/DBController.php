<?php
/*
*Database connection class
*version 1.0
*Author Keith Djouba, Tunde Akinyemi, Zoe Chang
*
*
*/
class DBController
  {
    /* Set login credidential*/
    private $host = "gamertree.coeozr7b8ydf.us-east-1.rds.amazonaws.com";
    private $user = "rocklee";
    private $password = "rockleelions77";
    private $database = "rocklee";
    private $conn;

    /* establish constructor*/
    public function __construct()
    {
        $this->conn = $this->connectDB();
    }
    /* function that establish connection to database*/
    public function connectDB()
    {
        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        return $conn;
    }
    /* function that run all the queries*/
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
    /* function that count the number of rows from a specific value*/
    public function numRows($query)
    {
        $result = mysqli_query($this->conn, $query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }
    /* Update queries from the databse*/
    public function updateQuery($query)
    {
        $result = mysqli_query($this->conn, $query);
        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            return $result;
        }
    }
    /* Function that insert queries to the database*/
    public function insertQuery($query)
    {
        $result = mysqli_query($this->conn, $query);
        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            return mysqli_insert_id($this->conn);
        }
    }
    /*function that add token to database*/
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
    /* function that delete values from database*/
    public function deleteQuery($query)
    {
        $result = mysqli_query($this->conn, $query);
        if (!$result) {
            die('Invalid query: ' . mysqli_error());
        } else {
            return $result;
        }
    }
    /* function which shuffle a set of strings*/
    public function generateNewString($len = 10)
    {
        $token = "poiuztrewqasdfghjklmnbvcxy1234567890";
        $token = str_shuffle($token);
        $token = substr($token, 0, $len);

        return $token;
    }
    /*Function that gets teams limit value for the database*/
    public function getTeamLimit($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row["TeamLimit"];
            }
        }
    }
    /*Function that gets User ID value for the database*/
    public function getUserID($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
			while ($row = mysqli_fetch_assoc($result))
			{
              return $row["UserID"];
            }
        }
    }
    /*Function that Teams ID  value for the database*/
    public function getUserTeamID($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
      while ($row = mysqli_fetch_assoc($result))
      {
              return $row["TeamID"];
            }
        }
    }
    /*Function that gets teams Name value for the database*/
    public function getUserTeamName($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
      while ($row = mysqli_fetch_assoc($result))
      {
              return $row["TeamName"];
            }
        }
    }
    /*Function that Count the number of rows of a specific value from database*/
    public function getCount($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
      while ($row = mysqli_fetch_array($result))
      {
              return $row[0];
            }
        }
    }
    /*Function that gets user email value for the database*/
    public function getEmail($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row["Creator"];
            }
        }
    }
    /* Function that get the image file from database*/
    public function getImage($query)
    {
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die('Invalid query: ' . mysqli_error($this->conn));
        } else {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row["file"];
            }
        }
    }
}
