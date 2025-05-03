<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'position',
        'description',
        'location',
        'salary_range',
        'application_date',
        'status',
        'contact_name',
        'contact_email',
        'contact_phone',
        'notes',
    ];

    protected $casts = [
        'application_date' => 'date',
    ];

    /**
     * Get the user that owns the job application.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reminders for the job application.
     */
    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }
}
