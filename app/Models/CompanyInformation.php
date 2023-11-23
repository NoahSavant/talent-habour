<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyInformation extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'company_informations';

    protected $fillable = [
        'user_id',
        'logo_url',
        'image_url',
        'name',
        'title',
        'address',
        'address_main',
        'scale',
        'field',
        'web',
        'facebook',
        'linkedIn',
        'description',
        'culture',
    ];
}
