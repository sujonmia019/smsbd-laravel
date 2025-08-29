<?php

namespace SujonMia\Smsbd\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'sms_logs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'to',
        'message',
        'provider',
        'status',
        'response',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'response' => 'array',
    ];

    /**
     * Optional: Define helper methods
     */
    public function isSent(): bool
    {
        return $this->status === 'sent';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

}
