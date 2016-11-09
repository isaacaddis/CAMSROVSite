<?php 
	if(isset($_POST['submit'])){
	    $to = "camsrov@gmail.com";
	    $from = $_POST['email']; 
	    $name = $_POST['name'];
	    $subject = $_POST['subject'];
	    $message = "Email: ". $from . " Name: ". $name . " Message: " . $_POST['message'];
	    $headers = $subject;

	    # Verify captcha
	    $post_data = http_build_query(
	        array(
	            'secret' => "6LchLgoUAAAAAOn3gKMJJFB_Z0fTP1jd58EpfQYe",
	            'response' => $_POST['g-recaptcha-response'],
	            'remoteip' => $_SERVER['REMOTE_ADDR']
	        )
	    );
	    $opts = array('http' =>
	        array(
	            'method'  => 'POST',
	            'header'  => 'Content-type: application/x-www-form-urlencoded',
	            'content' => $post_data
	        )
	    );
	    $context  = stream_context_create($opts);
	    $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
	    $result = json_decode($response);
	    if (!$result->success) {
	        // throw new Exception('Gah! CAPTCHA verification failed. Please email me directly at: jstark at jonathanstark dot com', 1);
	    	echo '<script type="text/javascript">',
	    	     'alert("Please do not forget to fill out the captcha!");',
	    	     '</script>'
	    	;
	    }
	    else{
	    	mail($to, $subject, $message);
	    	header("location: index.html");
	    }
	}
?>