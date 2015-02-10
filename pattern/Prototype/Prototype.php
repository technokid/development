<?php
/**
 * Created by Serhii Dudik.
 * User: dudman
 * Date: 11.02.15
 * E-mail: duda902@gmail.com
 */
/**
 * Concrete prototype
 */
class Entity_EmailMessage
{
	public $headers = array();
	public $subject = null;
	public $message = null;
	public $to = null;
	public function headersAsString()
	{
		$out = "MIME-Version: 1.0\r\n";
		foreach ($this->headers as $key => $val) {
			$out .= sprintf("%s: %s\r\n", $key, $val);
		}
		return $out;
	}
}
class Lib_PhpNative_Email
{
	public function send(Entity_EmailMessage $message)
	{
		printf ("Following message sent:\n %s\n To: %s\n Subject: %s\n Message: %s\n\n",
			$message->headersAsString(), $message->to, $message->subject
			, $message->message);
	}
}
class Lib_Mailer
{
	private $_messages = array();

	public function enqueue($email, $messagePrototype)
	{
		$message = clone $messagePrototype;
		$message->to = $email;
		$this->_messages[] = $message;
	}
	public function sendToAll()
	{
		$sender = new Lib_PhpNative_Email();
		array_walk ($this->_messages, array($sender, "send"));
	}
}

/**
 * Usage
 */
$prototype = new Entity_EmailMessage();
$prototype->headers = array(
	'From' => 'Our project <no-reply@ourproject.com>',
	'Content-type' => 'text/html; charset="iso-8859-1"',
	'Content-Transfer-Encoding' => '8bit',
);
$prototype->subject = 'Newsletter from our project';
$prototype->message = 'Body text....';

$mailer = new Lib_Mailer();
$mailer->enqueue("email1@email.com", $prototype);
$mailer->enqueue("email2@email.com", $prototype);
$mailer->sendToAll();

// Output:
// Following message sent:
// MIME-Version: 1.0
// From: Our project <no-reply@ourproject.com>
// Content-type: text/html; charset="iso-8859-1"
// Content-Transfer-Encoding: 8bit
//
// To: email1@email.com
// Subject: Newsletter from our project
// Message: Body text....
//
// Following message sent:
// MIME-Version: 1.0
// From: Our project <no-reply@ourproject.com>
// Content-type: text/html; charset="iso-8859-1"
// Content-Transfer-Encoding: 8bit
//
// To: email2@email.com
// Subject: Newsletter from our project
// Message: Body text....