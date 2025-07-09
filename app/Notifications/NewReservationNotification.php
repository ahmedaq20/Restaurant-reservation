<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;


class NewReservationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

     public $reservation;
    public function __construct(Reservation $reservation)
    {
        $this->reservation =$reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    // public function toDatabase(object $notifiable){
    //     return [
    //         'id' =>$this->reservation->id,
    //         'name' =>$this->reservation->first_name .' '.$this->reservation->last_name,
    //         'res_date' =>$this->reservation->res_date,
    //     ];
    // }
  
    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'id' => $this->reservation->id,
    //         'name' => $this->reservation->first_name . ' ' . $this->reservation->last_name,
    //         'res_date' => $this->reservation->res_date,
    //     ]);
    // }

    public function toBroadcast($notifiable)
    {
        
    return new BroadcastMessage($this->toArray($notifiable));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // هذه هي البيانات التي سيتم تخزينها في عمود `data` بجدول `notifications`.
        // وهي نفس البيانات التي سيتم بثها عبر Pusher.
        return [
            'reservation_id' => $this->reservation->id,
            'first_name' => $this->reservation->first_name,
            'last_name' => $this->reservation->last_name,
            'res_date' => Carbon::parse($this->reservation->res_date)->format('Y-m-d H:i'),
            'guest_number' => $this->reservation->guest_number,
            'table_name' => $this->reservation->table->name ?? 'N/A', // تأكد من وجود table->name
            'message' => 'New reservation created by ' . $this->reservation->first_name . ' for table ' . ($this->reservation->table->name ?? 'N/A') . ' in ' .Carbon::parse($this->reservation->res_date)->format('Y-m-d'),
            'url' => route('admin.reservations.show', $this->reservation->id), // رابط لتفاصيل الحجز
        ];
    }

    public function broadcastOn()
    {
        // قناة خاصة للإدمن
           return new PrivateChannel('admin');

    }

    public function broadcastAs()
    {
        return 'new-reservation';
    }
}