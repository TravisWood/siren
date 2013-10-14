<?

function exist($table, $row, $value) {
	
	$exist = R::findOne($table, "$row =:$row", array($row => $value));
	
	if (!empty($exist)):
		return true;
	else:
		return false;
	endif;
	
} // end function

function account_type($permission, $type) {
	
	if ($permission == $type):
		echo 'selected="selected"';
	endif;
	
} // end function


function randKey($length, $strength) {
	
    $vowels = 'aeuy';
	
    $consonants = 'bdghjmnpqrstvz';
	
    if ($strength >= 1) {
        $consonants .= 'BDGHJLMNPQRSTVWXZ';
    } // end if
    if ($strength >= 2) {
        $vowels .= "AEUY";
    } // end if 
    if ($strength >= 4) {
        $consonants .= '23456789';
    } // end if 
    if ($strength >= 8) {
        $consonants .= '@#$%';
    } // end if 

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
        if ($alt == 1) {
            $password .= $consonants[(rand() % strlen($consonants))];
            $alt = 0;
        } // end if 
		 else {
            $password .= $vowels[(rand() % strlen($vowels))];
            $alt = 1;
        } // end else
    } // end for
	
    return $password;
	
} // end function


function addUser($fname, $lname, $email, $permission, $company=NULL, $phone=NULL, $password) {
	
	$user = R::dispense('user');
	$user->first_name = $fname;
	$user->last_name = $lname;
	$user->email = $email;
	$user->permission = $permission;
	$user->company = $company;
	$user->phone = $phone;
	$user->password = $password;
	$user_id = R::store($user);
	
	$result = array('status' => 'success', 'message' => "$fname $lname as been added to the system successfully.");
	
	echo json_encode($result);
	
} // end function

function projectFiles($file) {
	
	ini_set ( "memory_limit", "120M");
	include $_SERVER['DOCUMENT_ROOT'].'/signature/classes/class.upload.php'; 
 
	$handle = new upload($file);
 
	if ($handle->uploaded) {
      $handle->image_resize         = false;
      $handle->image_ratio_x        = false;
      $handle->process($_SERVER['DOCUMENT_ROOT'].'/signature/uploads/tmp/');
      if ($handle->processed) {	  
		  
		  $mime = $handle->file_src_name_ext;

		  $this_image = array('url' => $handle->file_dst_name, 'mime' => $mime);
      } // end if
	  
	  else {
           echo $handle->error; 
      } // end else 
	  
  } // end if 

  if ($handle->processed) {
	  		
    $handle->Clean();
  } else {
    echo 'error : ' . $handle->error;
  } 
  echo json_encode(array($this_image)); 
	
} // end function 


?>