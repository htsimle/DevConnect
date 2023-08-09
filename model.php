<?php

class ModalOperations {

    public function adduserdata($title, $pic, $disc, $dtime) {
		$config = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . '/ex3/' . 'config.ini');
		// Create connection
		$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
		// Check connection
		if ($conn -> connect_error) {
			return null;
		}

		
		// prepare and bind
		$stmt = $conn -> prepare("INSERT INTO `addblog`(`title`, `pic`, `disc`,`dtime`) VALUES (?,?,?,?)");
		
		$stmt -> bind_param("ssss", $title, $pic, $disc, $dtime);
		$stmt -> execute();

		$id = $conn -> insert_id;
		$stmt -> close();
		$conn -> close();
		return $id;
	}



	public function getblogdata() {

		$config = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . '/ex3/' . 'config.ini');
		// Create connection
		$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);	
	
		// Check connection
		if ($conn -> connect_error) {
			return FALSE;
		}
		
		
		
		$sql = "SELECT * From `addblog`";
		$result = $conn -> query($sql);
		
		$conn -> close();
		return $result;
	}

	
	public function fetchdatabyid($id) {

		$config = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . '/ex3/' . 'config.ini');
		// Create connection
		$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);	
	
		// Check connection
		if ($conn -> connect_error) {
			return FALSE;
		}
		
		
		
		$sql = "SELECT * From `addblog` where id = '$id'";
		$result = $conn -> query($sql);
		
		$conn -> close();
		return $result;
	}	
	
	public function updateblogdata($upid, $title, $pic, $disc) {

		$config = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . '/ex3/' . 'config.ini');
		// Create connection
		$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);	
	
		// Check connection
		if ($conn -> connect_error) {
			return FALSE;
		}	
		
		$sql = "UPDATE `addblog` SET  `title`='$title', `pic`='$pic', `disc`='$disc' WHERE `id`='$upid'"; 
		
		$result = $conn -> query($sql);
		
		$conn -> close();
	}	

	public function deleteblogdata($id) {
		$config = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . '/ex3/' . 'config.ini');
		// Create connection
		$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
	
		// Check connection
		if ($conn->connect_error) {
			return FALSE;
		}
	
		// Sanitize the $id to prevent SQL injection
		$id = $conn->real_escape_string($id);
	
		$sql = "DELETE FROM `addblog` WHERE id = '$id'";
		$result = $conn->query($sql);
	
		// Check if the deletion was successful
		if ($result && $conn->affected_rows > 0) {
			$conn->close();
			return TRUE;
		} else {
			$conn->close();
			return FALSE;
		}
	}
	

	public function usersignupdata($name, $email, $password) {
		$config = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . '/ex3/' . 'config.ini');
		// Create connection
		$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
		// Check connection
		if ($conn -> connect_error) {
			return null;
		}

		
		// prepare and bind
		$stmt = $conn -> prepare("INSERT INTO `user`(`name`, `email`, `password`) VALUES (?,?,?)");
		
		$stmt -> bind_param("sss", $name, $email, $password);
		$stmt -> execute();

		$id = $conn -> insert_id;
		$stmt -> close();
		$conn -> close();
		return $id;
	}



    // public function check_user_exists($name, $password) {
    //     $config = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . '/ex3/' . 'config.ini');
    //     // Create connection
    //     $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    //     // Check connection
    //     if ($conn->connect_error) {
    //         return false;
    //     }

    //     // Prepare the SQL statement
    //     $stmt = $conn->prepare("SELECT userID, name, password FROM user WHERE name = ? AND password = ?");
    //     $stmt->bind_param("ss", $name, $password);
    //     $stmt->execute();
    //     $stmt->store_result();
    //     $result = $stmt->num_rows > 0;

    //     $stmt->close();
    //     $conn->close();
    //     return $result;
    // }

		    public function get_user_data($name, $password) {
        $config = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . '/ex3/' . 'config.ini');
        // Create connection
        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

        // Check connection
        if ($conn->connect_error) {
            return false;
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT userID, name FROM user WHERE name = ? AND password = ?");
        $stmt->bind_param("ss", $name, $password);
        $stmt->execute();
        $stmt->bind_result($userId, $name);
        
        if ($stmt->fetch()) {
            $userData = array(
                'userId' => $userId,
                'name' => $name
            );
        } else {
            $userData = false;
        }

        $stmt->close();
        $conn->close();
        return $userData;
    }

	public function fetchdatabylogin($name,$password) {

		$config = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . '/ex3/' . 'config.ini');
		// Create connection
		$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);	
	
		// Check connection
		if ($conn -> connect_error) {
			return FALSE;
		}
		
		
		
		$sql = "SELECT * From `user` where name = '$name'AND password = '$password'";
		$result = $conn -> query($sql);
		
		$conn -> close();
		return $result;
	}	
	
	public function profiledata($name) {

		$config = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . '/ex3/' . 'config.ini');
		// Create connection
		$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);	
	
		// Check connection
		if ($conn -> connect_error) {
			return FALSE;
		}
		
		
		
		$sql = "SELECT ab.id, ab.title, ab.disc, ab.dtime, ab.userID
		FROM addblog AS ab
		JOIN user AS u ON ab.userID = u.userID
		WHERE u.name = '$name';
		";
		$result = $conn -> query($sql);
		
		$conn -> close();
		return $result;
	}

}
?>