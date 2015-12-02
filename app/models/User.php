<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $primaryKey = 'user_id';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function role() {
		#param 1 => nama class
		#param 2 => FK
		#param 3 => PK pada model tujuan
		return $this->belongsTo('Role', 'role_id', 'role_id');
	}

	public function scopeNonAdministrator(){
		return $this->whereHas('role', function($q) {
			$q->where('roles.role_id', '<>', 1);
		})->with('role');
	}

	public function logs() {
		return $this->hasMany('Logsurat');
	}
}
