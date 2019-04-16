<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Image;
use Storage;

class Profile extends Model
{
    //
	public function getProfiles() {
		$ins = new Profile();
		return $ins->all();
	}
    public function saveProfile($data) {


    	$sig_path = "";
    	$profile_path = "";

    	//save profile
    	if(isset($data["thumbnail"]) && !empty($data["thumbnail"])) {
    		$profile_path = "profile-".str_random(15).".png";
		    $storage_path = "/profile/".$profile_path;
		    $img = Image::make(file_get_contents($data["thumbnail"]));

		    $img->stream();

		    Storage::disk('local')->put($storage_path, $img, 'public');
    	}
    	//save signature
    	if(isset($data["signature"]) && !empty($data["signature"])) {
    		$sig_path = "sig-".str_random(15).".png";
		    $path = "/signature/".$sig_path;
		    $img = Image::make(file_get_contents($data["signature"]));

		    $img->stream();

		    Storage::disk('local')->put($path, $img, 'public');
    	}

		$ins               = new Profile();
		$ins->first_name   = $data["first_name"];
		$ins->last_name    = $data["last_name"];
		$ins->gender       = $data["gender"];
		$ins->age          = $data["age"];
		$ins->civil_status = isset($data["civil_status"]) ? $data["civil_status"] : "";
		$ins->birth_date   = isset($data["birth_date"]) ? $data["birth_date"] : "";
		$ins->blood_type   = isset($data["blood_type"]) ? $data["blood_type"] : "";

		if(!empty($profile_path)) {
			$ins->thumbnail    = $profile_path;
		}
		
		if(!empty($profile_path)) {
			$ins->signature    = $sig_path;
		}

		$ins->save();
		

    } 
}
