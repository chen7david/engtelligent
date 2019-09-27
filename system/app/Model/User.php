<?php 
namespace Core\Model;
use Carbon\Carbon;

use \Illuminate\Database\Eloquent\Model;

use Core\Model\Password;
use Core\Model\Email;
use Core\Model\PhoneNumber;
use Core\Model\Username;
use Core\Model\Role;


class User extends Model
{

	protected $fillable = [
		'user_id',
		'first_name',
		'last_name',
		'gender',
		'date_of_birth',
		'country_of_birth',
		'place_of_birth'
	];

	public function delete() {
	    $this->usernames()->delete();
	    $this->emails()->delete();
	    $this->phoneNumbers()->delete();
	    $this->passwords()->delete();
	    $this->roles()->detach();
	    $this->leagues()->detach();
	    parent::delete();
	}

	public function getAgeAttribute(){
		return Carbon::parse($this->date_of_birth)->age;
	}

	public function getNameAttribute(){

		if ($this->first_name != null) {
			return $this->full_name;
		}else{
			return $this->username;
		}
	}

	public function getFullNameAttribute(){
		return $this->first_name." ".$this->last_name;
	}

	public function getPasswordAttribute(){
		return $this->password()->password;
	}

	public function password(){
		return $this->passwords()->orderBy('created_at', 'desc')->latest()->first();
	}

	public function passwords(){
		return $this->hasMany(Password::class);
	}

	public function getLeagueAttribute(){
		return $this->league->name;
	}

	public function league(){
		return $this->leagues()->latest()->first();
	}

	public function updateLeague(int $league){
		return $this->leagues()->sync([$league],true);
	}

	public function leagues(){
		return $this->belongsToMany(League::class)->withTimestamps();
	}

	public function getEmailAttribute(){
		return $this->emails()->where('is_primary',true)->latest()->first()->email;
	}

	public function email(){
		return $this->emails()->where('is_primary',true)->latest()->first();
	}

	public function emails(){
		return $this->hasMany(Email::class);
	}

	public function getphoneNumberAttribute(){
		return $this->phoneNumber()->phone_number;
	}

	public function phoneNumber(){
		return $this->phoneNumbers()->where('is_primary',true)->latest()->first();
	}

	public function phoneNumbers(){
		return $this->hasMany(PhoneNumber::class);
	}

	public function getUsernameAttribute(){
		return $this->username()->username;
	}

	public function username(){
		return $this->usernames()->latest()->first();
	}

	public function usernames(){
		return $this->hasMany(Username::class);
	}

	public function activeTokens(){
		return $this->tokens()->where('active',true)->sum('active');
	}

	public function limitActiveTokens(){
		$active = $this->activeTokens() + 1;
		$allowed = $this->league()->connections;
		if ($active >= $allowed) {
			$excess = $active - $allowed;
			$this->tokens()->where('active',true)->orderBy('created_at','asc')->limit($excess)->update([
				'active'=>false,
			]);
		}
	}

	public function tokens(){
		return $this->hasMany(Token::class);
	}

	public function addRole(int $role){
		return $this->roles()->sync([$role] ,false);
	}

	public function updateRoles(array $roles){
		return $this->roles()->sync($roles ,true);
	}

	public function hasAnyRole(array $roles){
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        }else{
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role){
        if ($this->roles()->where('name',$role)->first()) {
            return true;
        }
        return false;
    }

    public function roles(){
		return $this->belongsToMany(Role::class)->withTimestamps();
	}







}