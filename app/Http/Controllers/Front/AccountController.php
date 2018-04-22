<?php

namespace Manddu\Http\Controllers\Front;

use Manddu\User;
use Manddu\FinalUser;
use Illuminate\Http\Request;
use Manddu\Http\Controllers\Controller;
use Manddu\Http\Requests\Front\Account\StoreRequest;

class AccountController extends Controller
{
    public function store(StoreRequest $request)
    {
    	$request;

    	//New user record
    	$user = new User();
    	$user->name = $request->nombre;
    	$user->email = $request->correoElectronico;
    	$user->password = bcrypt($request->password);
    	$user->user_group_id = 1;

    	if ($user->save()) {
    		//New final user record
    		$finalUser = new FinalUser();
    		$finalUser->user_id = $user->id;
    		$finalUser->last_name = $request->apellidoPaterno;

    		if ($finalUser->save()) {
    			$response = [
	    			'status' => true,
	    			'message' => 'Se ha creado con éxito tu cuenta en Manddu'
	    		];
    		} else {
    			$user->delete();

    			$response = [
    				'status' => false,
    				'message' => 'No se ha podido crear tu cuenta en Manddu (x0002)'
    			];
    		}
    	} else {
    		$response = [
    			'status' => false,
    			'message' => 'No se ha podido crear tu cuenta en Manddu (x0001)'
    		]
    	}

    	return response()->json($request);
    }
}
