<?php
namespace App;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
class User extends Model implements Authenticatable
{
	use \Illuminate\Auth\Authenticatable;

	public function user(){
		$this->belongsToMany('App/User');
	}

    public function roles()
	{
	return $this
		->belongsToMany('App\Role')
		->withTimestamps();
	}

	public function hasAnyRoles($roles){
		if(is_array($roles)){
			foreach ( $roles as $role ) {
				if($this->hasRole($role)){
					return true;
				}
			}
		}else{
			if($this->hasRole($roles)){
				return true;
		}
			return false;
		}
	}

	public function hasRole($role){
		if($this->roles()->where('name', $role)->first()){
			return true;
		}
		return false;
	}

	public function posts(){
		return $this->hasMany('App\Post');
	}
}