<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\SettingUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::now()->toDateTimeString();
        $notifications = Notification::where('date_public', '<=', $date)->where('status', 0)->get();
        if ($notifications) {
            $user_ids = SettingUser::select('user_id')->where('system_notify', 1)->get()->pluck('user_id');
            $users = User::whereIn('id', $user_ids)->where('status', User::STATUS_ACTIVE)->get();
            if ($users) {
                $arrayNotiUser = [];
                foreach ($notifications as $notify) {
                    foreach ($users as $user) {
                        $arrayNotiUser[] = [
                            'notification_id' => $notify->id,
                            'admin_id' => config('constant.admin_id'),
                            'user_from' => $user->id,
                            'user_to' => $user->id,
                            'status' => 0,
                        ];
                    }
                    $notify->update([
                        'status' => 1,
                    ]);
                }
                NotificationUser::insert($arrayNotiUser);
            }
        }
    }
}
