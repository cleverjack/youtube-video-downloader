<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Videos;
use App\Youtube\Toolkit;
use App\Youtube\Config;
use App\Youtube\VideoInfo;
use App\Youtube\Cache\FileCache;
use Intervention\Image\Facades\Image as Image;

class YoutubeController extends Controller
{




  public function __construct(){
    
  }
  
  public function index()
  {
    

    echo $template->render('index.php');

  }



  public function result($video_id)
  {

    $toolkit = new Toolkit;

    $ds = DIRECTORY_SEPARATOR;

    $config_dir = realpath(__DIR__.'/../../../config/');

    $config = Config::createFromFiles(
      $config_dir . '/default.php'
    );

     $cache = FileCache::createFromDirectory(
      realpath(__DIR__ .'/../../../cache/')
    );


    $my_id = $video_id;
    

    if( $toolkit->isMobileUrl($my_id) )
    {
      $my_id = $toolkit->treatMobileUrl($my_id);
    }

    $my_id = $toolkit->validateVideoId($my_id);

   

    /* First get the video info page for this video id */
    // $my_video_info = 'http://www.youtube.com/get_video_info?&video_id='. $my_id;
    // thanks to amit kumar @ bloggertale.com for sharing the fix
    $video_info_url = 'http://www.youtube.com/get_video_info?&video_id=' . $my_id . '&asv=3&el=detailpage&hl=en_US';
    $video_info_string = $toolkit->curlGet($video_info_url, $config);

    /* TODO: Check return from curl for status code */
    $video_info = VideoInfo::createFromStringWithConfig($video_info_string, $config);

   

    $video_info->setCache($cache);

    

    $my_title = $video_info->getTitle();
    $cleanedtitle = $video_info->getCleanedTitle();

   
    /* create an array of available download formats */
    $avail_formats = $video_info->getFormats();



    /* now that we have the array, print the options */
    foreach ($avail_formats as $avail_format)
    {

      if($avail_format->getType() == "video/webm"){
        $directlink = $avail_format->getUrl();
        
        $directlink .= '&title=' . $cleanedtitle;

      }
    }


    return $directlink;
  }

  public function uploadVideo(Request $request){
    /**
 * Transfer (Import) Files Server to Server using PHP FTP
 * @link https://shellcreeper.com/?p=1249
 */

    if( (Videos::where('video_id','=', $request['video_id'])->count()) > 0 )
            return "already exist";
    header('Content-Type: text/html; charset=utf-8');

    ini_set('max_execution_time', 300); //300 seconds = 5 minutes

  

    $img_file = Image::make("https://i.ytimg.com/vi/".$request['video_id']."/mqdefault.jpg");
    $img_name = uniqid('img_', true) . '.jpg';
    $img_file->save('../storage/app/public/images/'.$img_name); 
   

   

    $ch = curl_init($request['video_url']);

    $vid_filename = uniqid('vid_', true).".webm";
    
   
        $fp = fopen("../storage/app/public/videos/".$vid_filename, "wb");
        // set URL and other appropriate options
        $options = array(
            CURLOPT_FILE => $fp,
            CURLOPT_HEADER => 0,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_TIMEOUT => 1800); // 30 minute timeout (should be enough)

        curl_setopt_array($ch, $options);

        $curl_result = curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        if($curl_result){

          $video = new Videos;

          
          
            $video->category_id = $request['category_id'];
            $video->age_id = $request['age_id'];
            $video->video_id = $request['video_id'];
            $video->thumbnail_url = $img_name;
            $video->video_title = $request['video_title'];
            $video->video_description = $request['video_description'];
            $video->video_url = $vid_filename;
            //$video->publish_at = $item['snippet']['publishedAt'];
        //    if(Videos::where('video_id', $video->video_id)->count() > 0)
        //      continue();
            $video->save();
            return "successfully";
          


            
        }else{
            die('ERROR Saving Remote File using cURL');
        }
        exit;
  }
  
  public function uploadMyVideo(Request $request) {
     
      if($request->hasFile('video') && $request->hasFile('thumbnail')) {
          $video = $request->video;
          $org_videoname = $video->getClientOriginalName();
          $temp_videoname = pathinfo ( $org_videoname, PATHINFO_FILENAME );
          $video_extension = pathinfo ( $org_videoname, PATHINFO_EXTENSION );
          
          $videofilename = uniqid() . "_" . date ( "YmdHis" ) . "." . $video_extension;
          
          $video->storeAs('public/videos', $videofilename);
          
          $thumbnail = $request->thumbnail;
          $org_thumbnailname = $thumbnail->getClientOriginalName();
          $temp_thumbnailname = pathinfo ( $org_thumbnailname, PATHINFO_FILENAME );
          $thumbnail_extension = pathinfo ( $org_thumbnailname, PATHINFO_EXTENSION );
          
          $thumbnailfilename = uniqid() . "_" . date ( "YmdHis" ) . "." . $thumbnail_extension;
          
          $thumbnail->storeAs('public/images', $thumbnailfilename);
          
          
          $video = new Videos;

          
          
            $video->category_id = $request['local_category_id'];
            $video->age_id = $request['local_age_id'];
            $video->video_id = uniqid();
            $video->thumbnail_url = $thumbnailfilename;
            $video->video_title = $request['local_title'];
            $video->video_description = $request['local_description'];
            $video->video_url = $videofilename;
            
            $video->save();
      }
      
      return redirect ( '/home' );
  }
}
