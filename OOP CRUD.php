<?php

class CrudOperations {
    private $conn;

    public function __construct($host, $username, $password, $database) {
        // Create a database connection
        $this->conn = new mysqli($host, $username, $password, $database);

        // Check for connection errors
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Create operation
    public function create($tableName, $data) {
        $columns = implode(',', array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    // Read operation
    public function read($tableName, $conditions = null) {
        $sql = "SELECT * FROM $tableName";
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return [];
        }
    }

    // Update operation
    public function update($tableName, $data, $conditions) {
        $updateFields = [];
        foreach ($data as $key => $value) {
            $updateFields[] = "$key = '$value'";
        }
        $updateFields = implode(', ', $updateFields);

        $sql = "UPDATE $tableName SET $updateFields WHERE $conditions";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    // Delete operation
    public function delete($tableName, $conditions) {
        $sql = "DELETE FROM $tableName WHERE $conditions";

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

// Database credentials
$host = "localhost";
$username = "your_username";
$password = "your_password";
$database = "your_database";

// Create an instance of CrudOperations and pass the database credentials
$crud = new CrudOperations($host, $username, $password, $database);

// Example usage:

// Create
$dataToInsert = array("name" => "John", "email" => "john@example.com");
$createResult = $crud->create("users", $dataToInsert);
if ($createResult) {
    echo "Record inserted successfully.<br>";
} else {
    echo "Error inserting record.<br>";
}

// Read
$allUsers = $crud->read("users");
echo "All users:<br>";
print_r($allUsers);

$userWithEmail = $crud->read("users", "email = 'john@example.com'");
echo "User with email 'john@example.com':<br>";
print_r($userWithEmail);

// Update
$dataToUpdate = array("name" => "Updated John");
$updateResult = $crud->update("users", $dataToUpdate, "email = 'john@example.com'");
if ($updateResult) {
    echo "Record updated successfully.<br>";
} else {
    echo "Error updating record.<br>";
}

// Delete
$deleteResult = $crud->delete("users", "email = 'john@example.com'");
if ($deleteResult) {
    echo "Record deleted successfully.<br>";
} else {
    echo "Error deleting record.<br>";
}

// Close the database connection when done
$crud->closeConnection();