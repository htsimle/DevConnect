<?php

include ('model.php');

if (isset($_REQUEST['action'])) {




    if ($_REQUEST['action'] == 'addblogdata') {
		$addobj = new ModalOperations();
		
		
		
		$id = $addobj -> adduserdata($_REQUEST['title'], $_REQUEST['pic'], $_REQUEST['disc'], $_REQUEST['dtime']);
		
		
		
	}	

	if ($_REQUEST['action'] == 'getblogdata') {
		
		$dobj = new ModalOperations();
	
		
		$itemsarr = array();
		
		$campres = $dobj -> getblogdata();
		
		if ($campres -> num_rows > 0) {
	
		while ($row = $campres -> fetch_assoc()) {
			
		$itemsarr['id'][] = $row['id'];
			$itemsarr['title'][] = $row['title'];
			$itemsarr['dtime'][] = $row['dtime'];
	
		}
	
		}
		
		echo json_encode($itemsarr);
		
	}

	if ($_REQUEST['action'] == 'fetchdatabyid') {
		
		$dobj = new ModalOperations();

		
		$itemsarr = array();
		
		$campres = $dobj -> fetchdatabyid($_REQUEST['upid']);
		
		if ($campres -> num_rows > 0) {

		while ($row = $campres -> fetch_assoc()) {
			
			// $itemsarr['id'][] = $row['id'];
			$itemsarr['title'][] = $row['title'];
			$itemsarr['pic'][] = $row['pic'];
			$itemsarr['disc'][] = $row['disc'];

		}

		}
		
		echo json_encode($itemsarr);
		
	}	

	if ($_REQUEST['action'] == 'updateblogdata') {
		$addobj = new ModalOperations();
		
		
		
		$id = $addobj -> updateblogdata($_REQUEST['upid'], $_REQUEST['title'], $_REQUEST['pic'], $_REQUEST['disc']);
		
		echo $upid;
		
	}	

	if ($_REQUEST['action'] == 'deletecurrentblog') {
		$addobj = new ModalOperations();
		
		$id = $_REQUEST['upid'];
		
		$delres = $addobj->deleteblogdata($id);
		
		if ($delres) {
			echo "Blog deleted successfully";
		} else {
			echo "Error deleting blog";
		}
	}
	

	if ($_REQUEST['action'] == 'signupdata') {
		$addobj = new ModalOperations();
		
		
		
		$id = $addobj -> usersignupdata($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password']);
		
		
		
	}

	if ($_REQUEST['action'] == 'login') {
   

		$userObj = new ModalOperations();
        $name = $_POST['name'];
        $password = $_POST['password'];
        $userData = $userObj->get_user_data($name, $password);

        if ($userData) {
            // Store the user data in session variables
            $_SESSION['userID'] = $userData['userId'];
            $_SESSION['name'] = $userData['name'];
            

            // Send JSON response indicating successful login
		echo ($userID);

        header('Location: allblogs.html');
            echo json_encode(array('success' => true));
            exit();
        } else {
            // Send JSON response indicating failed login
            echo json_encode(array('success' => false));
            exit();
        }
    }

	

if ($_REQUEST['action'] == 'fetchdatabylogin') {
 
    $dobj = new ModalOperations();

    $itemsarr = array();

    $campres = $dobj -> fetchdatabylogin($_REQUEST['name'], $_REQUEST['password']);

    // Sanitize and validate the input values if necessary (not shown in this code snippet)

    if ($campres->num_rows > 0) {
        while ($row = $campres->fetch_assoc()) {
            $itemsarr['userID'][] = $row['userID'];
            $itemsarr['name'][] = $row['name'];
        }
    }

    echo json_encode($itemsarr);
}


if ($_REQUEST['action'] == 'profiledata') {
		
	$dobj = new ModalOperations();

	
	$itemsarr = array();
	
	$campres = $dobj -> profiledata($_REQUEST['username']);
	
	
	if ($campres -> num_rows > 0) {

	while ($row = $campres -> fetch_assoc()) {
		
		$itemsarr['id'][] = $row['id'];
		$itemsarr['title'][] = $row['title'];
		$itemsarr['dtime'][] = $row['dtime'];

	}

	}
	
	echo json_encode($itemsarr);
	
}


    }
	
?>