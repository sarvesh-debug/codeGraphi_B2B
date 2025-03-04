<?php

namespace App\Helpers;

use App\Mail\CustomMail;
use Illuminate\Support\Facades\Mail;

class MailHelper
{
	public static function sendEmail($templateName, $templateData, $toEmail, $subject = null)
	{
		try {
			Mail::to($toEmail)->send(new CustomMail($templateName, $templateData, $subject));
			return true;
		} catch (\Exception $e) {
			return false;
		}
	}
}
