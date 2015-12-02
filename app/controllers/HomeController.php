<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function home() {
		$active = 'home';
		if (Auth::user()) {
			$user = User::with('role')->where('user_id', Auth::user()->user_id)->first();
			return View::make('home', compact('user', 'active'));
		} else {
			return View::make('login');
		}
	}

	public function login() {
		$validator = Validator::make(
				array(
					'email' => Input::get('email'),
					'password' => Input::get('password')
				),
				array(
					'email' => 'required|email',
					'password' => 'required'
				)
				// ,
				// array(
				// 	'email' => 'Problem with your email',
				// 	'password' => 'Problem with your password'
				// )
			);

		if ($validator->fails()) {
			$response = new stdclass();
			$response->code = '0';
			$response->status = 'error';
			$response->message = $validator->messages()->first();
			$response->data = null;

			return Response::json($response);
		} else {

			$userdata = array(
				'email' 	=> Input::get('email'),
				'password' 	=> Input::get('password')
			);

			if (Auth::attempt($userdata)) {
				Session::set('user', Auth::user());
				$response = new stdclass();
				$response->code = '1';
				$response->status = 'success';
				$response->message = 'Successful';
				$response->data = null;

				return Response::json($response);
			} else {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = 'Login Error';
				$response->data = null;

				return Response::json($response);

			}

		}
	}

}
