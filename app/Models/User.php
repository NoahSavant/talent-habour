<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'status',
        'gender',
        'date_of_birth',
        'phonenumber',
        'introduction',
        'image_url'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function accountVerify(): HasOne
    {
        return $this->hasOne(AccountVerify::class);
    }

    public function fullname(): string 
    {
        return $this->firstname .' '. $this->lastname;
    }

    public function companyInformation(): HasOne
    {
        return $this->hasOne(CompanyInformation::class);
    }

    public function recruitmentPosts(): HasMany
    {
        return $this->hasMany(RecruitmentPost::class);
    }

    public function recruitmentPostsHiring(): HasMany 
    {
        return $this->hasMany(RecruitmentPost::class)->where('expired_at', '>', now());
    }
}
