<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ThumbnailGenerator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, array $request)
    {
        $this->user = $user;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->update([
            'name'     => $this->request['name'],
            'email'    => $this->request['email'],
            'password' => $this->request['password'] ? bcrypt($this->request['password']) : $this->user->password
        ]);
    }
}
