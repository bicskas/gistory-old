<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Traits\BasicModel;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

	use Authenticatable, CanResetPassword, EntrustUserTrait, BasicModel;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'last_login'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	protected function rules()
	{
		return [
			'name' => array(
				'required',
				'max:255',
			),
			'email' => array(
				'required',
				'email',
				'max:255',
				'unique:users',
			),
			/*'password' => array(
				'required',
				'confirmed',
				'min:6',
			),*/
		];
	}

	public function save(array $options = array()) {
		if (empty($this->hash)) {
			$this->hash = sha1($this->email . time());
		}
		return parent::save($options);
	}

	public function setPasswordAttribute($value)
	{
		if (!empty($value)) {
			$this->attributes['password'] = bcrypt($value);
		}
	}

	public function accessMediasAll()
	{
		return $this->hasRole('admin');
	}

	public function project(){
		return $this->hasMany('App\Project', 'user_id', 'id');
	}

	public function ownteam(){
		return $this->hasMany('App\Team', 'owner_id', 'id');
	}

	public function teams()
	{
		return $this->belongsToMany('App\Team','user2team','user_id','team_id');
	}

}
