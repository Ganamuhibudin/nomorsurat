<?php

class UserController extends BaseController {

	public function index() {
		$active = 'user';
		if (Auth::user()) {
			$user = User::with('role')->where('user_id', Auth::user()->user_id)->first();
			$users = User::nonAdministrator()->get();
			$roles = Role::all();
			return View::make('user', compact('user', 'active', 'users', 'roles'));
		} else {
			return View::make('login');
		}
	}

	public function newUser() {
		try {
			#deklarasi data input
			$name = Input::get('name');
			$email = Input::get('email');
			$password = Input::get('password');
			$role = Input::get('role');

			$validator = Validator::make(
				array(
					'name' => $name,
					'email' => $email,
					'password' => $password,
					'role' => $role
				),
				array(
					'name' => 'required',
					'email' => 'required|email',
					'password' => 'required',
					'role' => 'required|numeric'
				)
			);
			if ($validator->fails()) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = $validator->messages()->first();
				$response->data = null;

				return Response::json($response);
			}

			$user = new User;
			$user->name = $name;
			$user->email = $email;
			$user->password = Hash::make($password);
			$user->role_id = $role;
			$user->save();
			$user->keterangan = Role::where('role_id', $role)->first()->keterangan;
			
			$response = new stdclass();
			$response->code = '1';
			$response->status = 'success';
			$response->message = 'Successful';
			$response->data = $user;
			#jika ingin dapat last insert id
			#$response->data = $user->user_id;
			return Response::json($response);

		} catch (Exception $e) {
			$response = new stdclass();
			$response->code = '0';
			$response->status = 'error';
			$response->message = 'Failed';
			$response->data = null;

			return Response::json($response);
		}
	}

	public function searchUser() {
		try {
			#deklarasi data input
			$id = Input::get('id');

			$validator = Validator::make(
				array(
					'id' => $id,
				),
				array(
					'id' => 'numeric'
				)
			);
			if ($validator->fails()) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = $validator->messages()->first();
				$response->data = null;

				return Response::json($response);
			}

			$user = User::whereNotNull('user_id');
			
			if (! empty($id)) {
				$user->where('user_id', $id);
			}

			$name = Input::get('name');
			if (! empty($name)) {
				$user->where('name', 'like', '%' . $name . '%');
			}

			$role_id = Input::get('role');
			if (! empty($role_id)) {
				$user->where('role_id', $name);
			}

			$_user = clone($user);

			$sort_by = 'users.user_id';
			$_sort_by = Input::get('sort_by');
			if (! empty($_sort_by)) {
				$sort_by = $_sort_by;
			}

			$sort_mode = 'asc';
			$_sort_mode = Input::get('sort_mode');
			if (! empty($_sort_mode)) {
				$sort_mode = $_sort_mode;
			}

			$total_records = $_user->count();

			$response = new stdclass();
			$response->code = '1';
			$response->status = 'success';
			$response->message = 'Successful';
			$response->total_records = $total_records;
			$response->data = $user->orderBy($sort_by, $sort_mode)->get();
			#jika ingin dapat last insert id
			#$response->data = $user->user_id;
			return Response::json($response);

		} catch (Exception $e) {
			$response = new stdclass();
			$response->code = '0';
			$response->status = 'error';
			$response->message = 'Failed';
			$response->data = null;

			return Response::json($response);
		}
	}

	public function updateUser() {
		try {
			#deklarasi data input
			$user_id = Input::get('user_id');
			$name = Input::get('name');
			$email = Input::get('email');
			$password = Input::get('password');
			$role = Input::get('role');

			$validator = Validator::make(
				array(
					'user_id' => $user_id,
					'name' => $name,
					'email' => $email,
					// 'password' => $password,
					'role' => $role
				),
				array(
					'user_id' => 'required|numeric',
					'name' => 'required',
					'email' => 'required|email',
					// 'password' => 'required',
					'role' => 'required|numeric'
				)
			);
			if ($validator->fails()) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = $validator->messages()->first();
				$response->data = null;

				return Response::json($response);
			}

			$user = User::where('user_id', $user_id)->first();
			if (! is_object($user)) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = 'User Not Found';
				$response->data = null;

				return Response::json($response);
			}

			$user->name = $name;
			$user->email = $email;
			// $user->password = Hash::make($password);
			$user->role_id = $role;
			$user->save();
			$user->keterangan = Role::where('role_id', $role)->first()->keterangan;
			
			$response = new stdclass();
			$response->code = '1';
			$response->status = 'success';
			$response->message = 'Successful';
			$response->data = $user;
			#jika ingin dapat last insert id
			#$response->data = $user->user_id;
			return Response::json($response);

		} catch (Exception $e) {
			$response = new stdclass();
			$response->code = '0';
			$response->status = 'error';
			$response->message = 'Failed';
			$response->data = null;

			return Response::json($response);
		}
	}

	public function deleteUser() {
		try {
			#deklarasi data input
			$user_id = Input::get('user_id');

			$validator = Validator::make(
				array(
					'user_id' => $user_id
				),
				array(
					'user_id' => 'required|numeric'
				)
			);
			if ($validator->fails()) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = $validator->messages()->first();
				$response->data = null;

				return Response::json($response);
			}

			$user = User::where('user_id', $user_id)->first();
			if (! is_object($user)) {
				$response = new stdclass();
				$response->code = '0';
				$response->status = 'error';
				$response->message = 'User Not Found';
				$response->data = null;

				return Response::json($response);
			}

			$user->delete();
			
			$response = new stdclass();
			$response->code = '1';
			$response->status = 'success';
			$response->message = 'Successful';
			$response->data = $user_id;
			
			return Response::json($response);

		} catch (Exception $e) {
			$response = new stdclass();
			$response->code = '0';
			$response->status = 'error';
			$response->message = 'Failed';
			$response->data = null;

			return Response::json($response);
		}
	}
}
