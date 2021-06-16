<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Video;

class VideoJob extends Job implements ShouldQueue
{
    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $video_id;

    public function __construct(Video $video)
    {
        $this->video_id = $video->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    private function longProcess() {
        // Do the long running process
        sleep(20);
    }

    public function handle()
    {
        $this->longProcess();
        $video = Video::find($this->video_id);
        $video->status = 'done';
        $video->save();
    }
}
