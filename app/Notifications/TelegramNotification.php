<?php

namespace App\Notifications;

use App\Notifications\Enums\TelegramMessageType;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $messageType;


    /**
     * Create a new notification instance.
     */

    public function __construct($message)
    {
        $this->message = $message;
    }
    
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toTelegram(object $notifiable): TelegramMessage
    {
        switch ($this->message) {
            case TelegramMessageType::NEW_USER:

                return TelegramMessage::create()
                ->to(env('TELEGRAM_NOTIFICATION_GROUP_ID'))->content("🎉 **New User Registered!** 🎉\n\n👤 **Name:** \
                {$notifiable->first_name} {$notifiable->last_name}\n📧 **Email:** {$notifiable->email}\n\n🎊 \
                We now have {$notifiable->count()} user(s) on Provinear 🎊");

            case TelegramMessageType::PROVIDER_ACCOUNT_ACTIVATED:

                return TelegramMessage::create()
                ->to(env('TELEGRAM_NOTIFICATION_GROUP_ID'))->content("🎉 **Provider Account Activated!** 🎉\n\n \
                Hooray! This user just activated their Provider account. Something Hooge is coming! \
                👤 **Name:** {$notifiable->first_name} {$notifiable->first_name}\n📧 **Email:** {$notifiable->email}\n\n🚀");
            // Add more cases for different message types
            
            default:
                return TelegramMessage::create()
                ->to(env('TELEGRAM_NOTIFICATION_GROUP_ID'))->content($this->message);
        }
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
