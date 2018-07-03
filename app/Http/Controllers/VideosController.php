<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Videos;
use atphp\youtube_downloader\YoutubeDownloader;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;

class VideosController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function getVideos($age_id, $category_id)
  {

      $categories = Videos::where('age_id', '=', $age_id)->where('category_id', '=', $category_id)->get();
      $data = json_encode($categories);
      return $data;
  }


  public function removeVideo($id)
  {
      

      $columne = Videos::where('id', '=', $id)->first(['video_url', 'thumbnail_url']);
      $vid_file = $columne['video_url'];
      $img_file = $columne['thumbnail_url'];
      
      if(unlink(storage_path('app/public/videos/'.$vid_file)) && unlink(storage_path('app/public/images/'.$img_file))){
        Videos::where('id', '=', $id)->delete();
        return "remove successfully";
      }

      return "failed";

      
  }
  
  
  public function editVideo($id){
    $item = Videos::where('id', '=', $id)->first();
   
    return json_encode($item);
  }

  public function updateVideo(Request $request){

    $col = Videos::find($request['id']);
    $col->video_title = $request['video_title'];
    $col->video_description = $request['video_description'];
    $col->category_id = $request['category_id'];
    $col->age_id = $request['age_id'];
    $col->save();
  }
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
}
