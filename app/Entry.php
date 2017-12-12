<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Entry extends Model
{
    protected $table = 'entries';

    public function schedule()
    {
        return $this->belongsTo('App\Schedule');
    }

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getTimeAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value);
    }
}
