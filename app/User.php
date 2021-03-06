<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Scout\Searchable;

use App\Question;
use App\Reply;
use Carbon\Carbon;


class User extends Authenticatable implements JWTSubject
{

    use Notifiable; //For Jwt

    use Searchable; //For Scout

    public function toSearchableArray() //For Scout if you get mb_strtolower() expects parameter 1 to be string, array given in Tokenizer.php error
    {
        return [];
    }

    protected $fillable = [
        'name', 'email', 'password', 'birthday', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    protected $dates = ['birthday'];

    public function setBirthdayAttribute($birthday)
    {
        $this->attributes['birthday'] = Carbon::parse($birthday);
    }

    protected $with = ['questions'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
