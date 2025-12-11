<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    /** @use HasFactory<\Database\Factories\ResumeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'template_id',
        'name',
        'full_name',
        'email',
        'phone',
        'address',
        'linkedin_url',
        'github_url',
        'website_url',
        'professional_summary',
        'skills',
    ];

    protected function casts(): array
    {
        return [
            'phone' => 'encrypted',
            'address' => 'encrypted',
            'skills' => AsCollection::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the resume.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the template used for this resume.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Get all work experiences for this resume.
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class)->orderBy('start_date', 'desc');
    }

    /**
     * Get all education entries for this resume.
     */
    public function education(): HasMany
    {
        return $this->hasMany(Education::class)->orderBy('graduation_date', 'desc');
    }

    /**
     * Get all projects for this resume.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to only include resumes for a specific user.
     */
    public function scopeForUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    /**
     * Scope a query to get recent resumes.
     */
    public function scopeRecent($query, int $limit = 5)
    {
        return $query->latest()->limit($limit);
    }
}
