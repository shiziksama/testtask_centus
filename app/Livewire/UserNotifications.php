<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;

class UserNotifications extends Component
{
    public $notifications;
    public $newNotification = [
        'city' => '',
        'pop' => '',
        'uvi' => '',
    ];
    protected $rules = [
        'notifications.*.city' => 'required|string|max:255',
        'notifications.*.pop' => 'required|numeric',
        'notifications.*.uvi' => 'required|numeric',
        'newNotification.city' => 'required|string|max:255',
        'newNotification.pop' => 'required|numeric',
        'newNotification.uvi' => 'required|numeric',
    ];


    public function mount()
    {
        $this->notifications = Auth::user()->notifications->keyBy('id')->toArray();
    }

    public function addNotification()
    {
        $this->validateOnly("newNotification.city");
        $this->validateOnly("newNotification.pop");
        $this->validateOnly("newNotification.uvi");
        $notification = new UserNotification();
        $notification->city = $this->newNotification['city'];
        $notification->pop = $this->newNotification['pop'];
        $notification->uvi = $this->newNotification['uvi'];
        
        $notification->user_id = Auth::id();
        $notification->save();

        $this->notifications = Auth::user()->notifications->keyBy('id')->toArray();
        $this->newNotification = [
            'city' => '',
            'pop' => '',
            'uvi' => '',
        ];
    }

    public function updateNotification($notificationId)
    {
        $this->validateOnly("notifications.$notificationId.city");
        $this->validateOnly("notifications.$notificationId.pop");
        $this->validateOnly("notifications.$notificationId.uvi");
        UserNotification::where('id', $notificationId)->update([
            'city' => $this->notifications[$notificationId]['city'],
            'pop' => $this->notifications[$notificationId]['pop'],
            'uvi' => $this->notifications[$notificationId]['uvi'],
        ]);
        $this->notifications = Auth::user()->notifications->keyBy('id')->toArray();
    }


    public function render()
    {
        return view('livewire.user-notifications');
    }
}
