<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeatherNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $weatherData;

    /**
     * Create a new message instance.
     */
    public function __construct($weatherData)
    {
        $this->weatherData = $weatherData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Weather Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.weather_notification',
            with: [
                'weatherData' => $this->weatherData,
                'uvIndex' => $this->weatherData['uvIndex'],
                'pop' => $this->weatherData['pop']
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
