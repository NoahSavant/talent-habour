<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'file_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $search)
    {
        if ($search === '')
            return $query;
        $keywords = explode(',', $search);
        $query->where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%$keyword%");
                });
            }
        });
    }
}
