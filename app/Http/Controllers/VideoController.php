<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\VideoJob;
use App\Models\Video;

class VideoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(Request $request){

        $video = new Video;
        $video->text = $request->script_text;
        $video->status = 'pending';
        $video->save();

        $this->dispatch(new VideoJob($video));

        $res['data'] = $video->id;
        $res['success'] = true;
        $res['message'] = 'Query Successfull';
        return response($res, 200);
    }

    public function getStatus(Request $request){

        $this->validate($request, [
            'ids' => 'array',
        ]);

        $data = array();
        $ids = $request->ids;
        $videos = Video::findMany($ids);

        foreach ($videos as $video) {
          $data[$video->id] = $video->status;
        }

        $res['data'] = $data;
        $res['success'] = true;
        $res['message'] = 'Query Successfull';
        return response($res, 200);
    }
}
