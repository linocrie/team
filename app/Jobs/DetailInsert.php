<?php

namespace App\Jobs;

use App\Models\Detail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DetailInsert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $request;
    protected User $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,array $request)
    {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        dd($this->detail);
//        dd($this->user->id);
        if (isset($this->request) && !empty($this->request)) {
            Detail::updateOrCreate(
                ['user_id'    => $this->user->id],
                [
                    'phone'   => $this->request['phone'],
                    'address' => $this->request['address'],
                    'city'    => $this->request['city'],
                    'country' => $this->request['country']
                ]
            );
        }
    }
}
