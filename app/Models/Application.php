<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'name',
        'file_url',
        'user_id',
        'recruitment_post_id',
        'status',
        'feedback',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recruitmentPost(): BelongsTo
    {
        return $this->belongsTo(RecruitmentPost::class);
    }

    public function scopeSearch($query, $search)
    {
        if ($search === '') {
            return $query;
        }

        $keywords = explode(',', $search);

        $query->where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere(function ($query) use ($keyword) {
                    $keyword = mb_strtolower($keyword); // Convert keyword to lowercase
                    $query->whereRaw('LOWER(name) LIKE ?', ["%$keyword%"]);
                });
            }
        });

        return $query;
    }
}
