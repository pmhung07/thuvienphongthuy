<?
class sendMail{


	public $mail;
	public $error;

	function init(){

		$this->mail = new PHPMailer();  // tạo một đối tượng mới từ class PHPMailer
	    $this->mail->IsSMTP(); // bật chức năng SMTP
	    $this->mail->SMTPDebug = false;  // kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
	    $this->mail->SMTPAuth = true;  // bật chức năng đăng nhập vào SMTP này
	    $this->mail->CharSet  = "utf-8";
	    $this->mail->SMTPSecure = 'ssl'; // sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
	    $this->mail->Host = 'smtp.gmail.com';
	    $this->mail->Port = 465;
	    $this->mail->IsHTML(true);
	    return $this->mail;
		/*
		$this->mail->IsSMTP(); // telling the class to use SMTP
		$this->mail->Host          = "smtp1.site.com;smtp2.site.com";
		$this->mail->SMTPAuth      = true;                  // enable SMTP authentication
		$this->mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
		$this->mail->Host          = "mail.yourdomain.com"; // sets the SMTP server
		$this->mail->Port          = 26;                    // set the SMTP port for the GMAIL server
		$this->mail->Username      = "yourname@yourdomain"; // SMTP account username
		$this->mail->Password      = "yourpassword";        // SMTP account password
		$this->mail->SetFrom('list@mydomain.com', 'List manager');
		$this->mail->AddReplyTo('list@mydomain.com', 'List manager');

		*/
	}


	function send($message, $addressEmail, $addressName, $subject = '', $from = '', $password = '', $reply = ''){

		//Option.
	    //from.
	    if($from == ''){
	    	$this->mail->Username = 'webhamhoc@gmail.com'; //'noreply@hochay.vn';   //hss.svnn.analytics@gmail.com
			$this->mail->Password = 'hamhoc.edu.vn'; //8g#yRW^Dhk4qes$AfYzr
			$this->mail->SetFrom('webhamhoc@gmail.com', "webhamhoc@gmail.com");
		}
		else{
			$this->mail->Username = $from;
			$this->mail->Password = $password;
			$this->mail->SetFrom($from, "hamhoc.edu.vn");
		}

		//title.
		if($subject == ''){
			$subject = 'Thông báo từ hamhoc.edu.vn';
		}

		//Reply.
		if($reply == ''){
			$reply = 'webhamhoc@gmail.com';
		}

		//Add.
		$this->mail->Subject = $subject;
		$this->mail->Body = $message;
		$this->mail->AltBody = "Để xem được mail này phải dùng trình hiển thị HTML";
		$this->mail->AddReplyTo($reply, "hamhoc.edu.vn");
		$this->mail->AddAddress($addressEmail, $addressName);

		//Start.
		if(!$this->mail->Send()){
			$this->error = $this->mail->ErrorInfo;
			return false;
		}
		else
			return true;
	}








}
?>