<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecruitmentPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'role', 
        'title', 
        'address', 
        'job_type', 
        'salary', 
        'description', 
        'job_requirements', 
        'educational_requirements', 
        'experience_requirements',
        'expired_at',
    ];

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function allApplications()
    {
        return Application::all();
    }

    public function scopeTypesFillter($query, $types) {
        if(count($types) === 0) return $query;
        $query = $query->where('id', '<', 0);
        foreach ($types as $type) {
            $query->orWhere('job_type', 'LIKE', "%$type%"); 
        }
    }

    public function scopeCompaniesFillter($query, $companies)
    {
        if (count($companies) === 0)
            return $query;
        $query = $query->whereIn('user_id', $companies);
    }

    public function scopeExperiencesFillter($query, $experiences)
    {
        if (count($experiences) === 0)
            return $query;

        $query = $query->where('id', '<', 0);
        foreach ($experiences as $experience) {
            $query->orWhere('experience_requirements', 'LIKE', "%$experience%");
        }
    }

    public function scopeUpdatedAfter($query, $date)
    {
        if(!$date) return $query;
        return $query->where('updated_at', '>', $date);
    }

    public function scopeSearch($query, $search)
    {
        if($search === '') return $query;
        $keywords = explode(',', $search);
        $query->where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere(function ($query) use ($keyword) {
                    $query->where('role', 'LIKE', "%$keyword%")
                        ->orWhere('title', 'LIKE', "%$keyword%")
                        ->orWhere('address', 'LIKE', "%$keyword%")
                        ->orWhere('job_type', 'LIKE', "%$keyword%")
                        ->orWhere('salary', 'LIKE', "%$keyword%");
                });
            }
        });
    }
}
