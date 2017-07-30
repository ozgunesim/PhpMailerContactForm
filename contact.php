<?php
echo "Lütfen Bekleyin...";
require '../vendor/autoload.php';
class ContactForm{
	public function SaveContactForm($sender_name, $sender_email, $message){
		$website = 'XXXXXXXXXX.com';

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Mailer = 'smtp';
		$mail->SMTPAuth = true;
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;
		$mail->SMTPSecure = 'ssl';

		$mail->Username = 'XXXXXXXXXX@gmail.com';
		$mail->Password = 'XXXXXXXXXX';
		$mail->CharSet = 'UTF-8';
		
		$mail->setFrom($sender_email, $sender_name);
		$mail->isHTML(true);

		$mail->AddAddress('XXXXXXXXXX@gmail.com');
		$mail->Subject = 'Web Sayfası İletişim Formu';
		$mail->MsgHTML(
			'Gönderen: ' . $sender_email . '<hr>' . 
			$message . '<hr>' .
			'<div style="text-color: blue; font-weight:bold; padding:15px; border: 1px solid blue; margin:5px;"><strong>BİLGİ: </strong> | Bu email ' . $website . ' web sayfasının iletişim formundan gelmiştir.</div>'
			);
		if($mail->Send()) {
			return true;
		} else {
			return false;
		}
	}
}


/* SAMPLE USAGE */

function msg_cookie($msg){
	setcookie('message', $msg, time()+10);
}

if(isset($_POST['sender_email'])){
	$email = trim($_POST['sender_email']);
	$name = strip_tags(trim($_POST['sender_name']));
	$message = str_replace("\n", "<br>", strip_tags(trim($_POST['message'])));
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		msg_cookie("Geçersiz Email!");
	}else{
		$form = new ContactForm();
		$isSent = $form->SaveContactForm($name, $email, $message);
		if($isSent){
			msg_cookie("Mesajınız kaydedildi!");
		}else{
			msg_cookie("Mesaj gönderilemedi!");
		}
	}
	header("Location: ../index.php#contact");
}

?>