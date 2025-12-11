<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    /** @use HasFactory<\Database\Factories\EducationFactory> */
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'degree',
        'institution',
        'location',
        'graduation_date',
        'gpa',
        'honors',
    ];

    protected function casts(): array
    {
        return [
            'graduation_date' => 'date',
        ];
    }

    /**
     * Get the resume that owns this education entry.
     */
    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
