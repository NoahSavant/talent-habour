<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function scopeSearch($query, $search)
    {
        if ($search === '') {
            return $query;
        }

        $keywords = explode(',', $search);

        $query->where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere(function ($query) use ($keyword) {
                    $keyword = mb_strtolower($keyword);
                    $query->whereRaw('LOWER(name) LIKE ?', ["%$keyword%"])
                        ->orWhereRaw('LOWER(address) LIKE ?', ["%$keyword%"])
                        ->orWhereRaw('LOWER(address_main) LIKE ?', ["%$keyword%"]);
                });
            }
        });

        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
