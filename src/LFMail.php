<?php


namespace Ohooki\LFMail;


use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\View;

/**
 * Class LFMAIL
 * @package Ohooki\LFMail
 * Build your email without SMTP configuration
 */
class LFMAIL
{

    /**
     * @var String $to
     * Email receiver
     */
    private $to;

    /**
     * @var String $subject
     * Email subject
     */
    private $subject;

    /**
     * @var View $view
     * HTML email use on your email
     */
    private $view;

    /**
     * @param $address
     * @return $this
     * Declare the receiver email
     */
    public function to($address) {

        $this->to = $address;

        return $this;

    }

    /**
     * @param String $subject
     * @return $this
     * Declare your email subject
     */
    public function subject(String $subject) {

        $this->subject = $subject;

        return $this;

    }

    /**
     * @param Mailable $mail
     * @return bool
     * Send the email with your Mailable object and return true or false if our mail has been sent successfully
     */
    public function send(Mailable $mail) {

        // Check if our View exist, else, send an execption
        if(View::exists($mail->build()->view))
        {
            // Get the data
            $mail->build()->data['subject'] = $this->subject;

            $infos = $mail->build();

            $this->view = View::first([$infos->view], $infos->data);

            // Send our email
            $this->_mail();

            return true;

        }
        else
        {
            return false;
        }

    }

    /**
     * Create our Headers and send the mail
     */
    private function _mail() {

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        $headers .= 'From: '. env('MAIL_FROM_NAME') ."\r\n".
                    'Reply-To: '. env('MAIL_FROM_NAME') ."\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        mail($this->to, $this->subject, $this->view, $headers);

    }

}
