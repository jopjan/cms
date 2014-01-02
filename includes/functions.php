<?php
	//this file is the place to store all basic functions
	
	function confirm_query($result_set){
		if(!$result_set){
			die("database query failed: " . mysql_error());
		}
	}
        function redirect_to($location= NULL) {
            if($location != NULL) {
                header("Location: {$location}");
                exit;
            } 
        }
        function mysql_prep( $value ) {
            $magic_quotes_active = get_magic_quotes_gpc();
            $new_enough_php = function_exists("mysql_real_escape_string");//i.e.  PHP >= v4.3.0
                if($new_enough_php) { //php v4.3.0 or higher 
                //undo any magic quote effects so mysql_real_escape_string can do the work
                    if($magic_quotes_active){ $value = stripslashes( $value ); }
                    $value = mysql_real_escape_string( $value );
                
                } else { //php v4.3.0
                    //if magic quotes aren't already on then add slashes manually
                    if(!$magic_quotes_active){ $value = addslashes( $value );}
                    // if magic quotes are activem then the slashes already exist
                }
                return $value;
            }
        

	function get_all_subjects(){
		$query = "SELECT * FROM 
			`subjects` ORDER BY 
			`position` ASC";
		$subject_set = mysql_query($query);
		confirm_query($subject_set);
		return $subject_set;		
	}
	
	function get_pages_for_subject($subject){
		$query = "SELECT * FROM 
						          `pages` WHERE 
								  `subject_id`='{$subject}' 
								  ORDER BY `position` ASC";
						$page_set = mysql_query($query);
						confirm_query($page_set);
					return $page_set;	
						
	}


        function get_subject_by_id($subject_id) {
            global $connection;
            $query = "select * ";
            $query .= "from subjects ";
            $query .= "where id=" . $subject_id;
            $query .= " LIMIT 1";
            
            $result_set = mysql_query($query, $connection);
            confirm_query($result_set);
            if($subject = mysql_fetch_array($result_set)){
                return $subject;
            }else{
                return NULL;
            }
        }   
        
        function get_page_by_id($page_id) {
            global $connection;
            $query = "select * ";
            $query .= "from pages ";
            $query .= "where id=" . $page_id;
            $query .= " LIMIT 1";
            
            $result_set = mysql_query($query, $connection);
            confirm_query($result_set);
            if($page = mysql_fetch_array($result_set)){
                return $page;
            }else{
                return NULL;
            }
        }
        
        function find_selected_page() {
            global $sel_subject;
            global $sel_page;
            if (isset($_GET['subj'])) {
		$sel_page = NULL;
                $sel_subject = get_subject_by_id($_GET['subj']);
            } elseif (isset($_GET['page'])) {
                    $sel_page = get_page_by_id($_GET['page']);
                    $sel_subject = NULL;
            } else {
                    $sel_page = NULL;
                    $sel_subject = NULL;
            }
        }
        
        function navigation($sel_subject,$sel_page) {
            $output = "<ul class=\"subjects\">";
				
					//perform database query
					$subject_set = get_all_subjects();
					
					//use returned data
					while($subject = mysql_fetch_array($subject_set)){
						$output .= "<li class=\"";
							if($subject['id'] == $sel_subject['id']){
								$output .= "selected";
							}else{
								$output .= "";
							}
						$output .=  "\"><a href=\"edit_subject.php?subj=".urlencode($subject['id'])."\">{$subject['menu_name']}</a></li>";
						
						$output .= "<ul class=\"pages\">";
						$page_set = get_pages_for_subject($subject['id']);
						
						while($page = mysql_fetch_array($page_set)){
							$output .= "<li class=\"";
							if($page['id'] == $sel_page['id']){
								$output .= "selected";
							}else{
								$output .= "";
							}
							$output .= "\"><a href=\"content.php?page=".urlencode($page['id'])."\">{$page['menu_name']}</a></li>";
						}
						$output .= "</ul>";
					}
				
				$output .= "</ul>";
                                
                                return $output;
        }
?>