<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Videos;
use App\Models\Category;
use App\User;
use Hash;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('nocache');
    }
    
    public function getCategoryVideos($age_id, $title){
        
        $category = Category::where('title',$title)->first();
    	$category_id = $category->id;
    	$categories = Videos::where('age_id', '=', $age_id)->where('category_id', '=', $category_id)->orderBy('id', "desc")->get();
      	$data = json_encode($categories);
      	return $data;
    }

    public function getCategories(){
    	$allCategories = Category::pluck('title','id')->all();
    	$data = json_encode($allCategories);
    	return $data;
    }
    
    public function getSearchResults($age_id, $query){
        
        if(trim($query) == '') return;
        $age_videos = Videos::where('age_id', '=', $age_id);
        $videos = $age_videos->where('video_title','like', '%'.$query.'%')->orWhere('video_description','like', $query)->orderBy('id', "desc")->get();
        $data = json_encode($videos);
        return $data;
    }

    public function login(Request $request){
    	$user = User::where('email', '=', $request['user_email'])->first();
    	
    	if($user == null)
    		return "false";
    	else{
    		if(Hash::check($request['user_password'] , $user->password)){
    			return "true";
    		}
    		else{
    			return "false";

    		}
    	}
    	
    }

    public function register(Request $data){

    	return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
	
	public function getSearchPostResults(Request $data){
        
		$age_id = $data['age_id'];
		$query = $data['query'];
        if(trim($query) == '') {
			return;
		}
        $age_videos = Videos::where('age_id', '=', $age_id);
        $videos = $age_videos->where('video_title','like', '%'.$query.'%')->orWhere('video_description','like', $query)->orderBy('id', "desc")->get();
        $data = json_encode($videos);
        return $data;
    }
}
