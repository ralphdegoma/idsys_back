<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use Validator;

class ProfileController extends Controller
{
    //


	public function index(Request $request, Profile $profile_ins) {
		return $profile_ins->getProfiles();
	}

    public function store(Profile $profile_ins,Request $request) {

    	try {

    		$validator = Validator::make( $request->all(), array(
                    'first_name'         => 'required|max:255',
                    'last_name'         => 'required|max:255',
                    'gender'         => 'required|max:255',
                    'age'         => 'required|max:255',
                    )
                );

		    if($validator->fails()) {
		    	$error_messages = implode(',', $validator->messages()->all());
		    	return response()->json([
					'status' => '400',
				    'message' =>  $error_messages,
				]);
		    }

			$profile_ins->saveProfile($request->all());

			return response()->json([
				'status' => '200',
			    'message' => 'Profile has been saved',
			]);

    	} catch (Exception $e) {

    		$error_message = $e->getMessage();
    		return response($error_message, 500);

    	}
    	
    }
}
