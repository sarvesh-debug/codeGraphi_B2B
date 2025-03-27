<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
	use Queueable, SerializesModels;

	public $templateData;
	public $templateName;
	public $subject;

	public function __construct($templateName, $templateData, $subject = null)
	{
		$this->templateData = $templateData;
		$this->templateName = $templateName;
		$this->subject = $subject ?? $this->getDefaultSubject($templateName);
	}

	public function build()
	{
		return $this->from(config('mail.from.address'), config('mail.from.name'))
			->subject($this->subject)
			->view('emails.' . $this->templateName)
			->with($this->templateData);
	}

	private function getDefaultSubject($templateName)
	{
		$subjects = [
			'add_member_by_admin' => 'Your ZPay Account is Ready – Access Your Credentials'
		];

		return $subjects[$templateName] ?? 'ZPay Notification';
	}
}
