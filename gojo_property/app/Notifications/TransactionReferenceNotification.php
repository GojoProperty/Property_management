<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TransactionReferenceNotification extends Notification
{
    use Queueable;

    protected $referenceCode;

    public function __construct($referenceCode)
    {
        $this->referenceCode = $referenceCode;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

   public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Your Gojo Property Transaction Reference')
        ->greeting('Hello ' . $notifiable->name . '!')
        ->line('Thank you for your transaction request on Gojo Property.')
        ->line('Your transaction reference code is: **' . $this->referenceCode . '**')
        ->line('Please reply to this email within 24 hours attaching your transaction receipt.')
        ->line('If you do not reply within 24 hours, your transaction request may be cancelled.')
        ->salutation('Thanks for using Gojo Property!');
}

}
