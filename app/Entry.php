<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $table = 'entries';

    public function schedule()
    {
        return $this->belongsTo('App\Schedule');
    }
}
