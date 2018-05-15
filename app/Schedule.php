<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function entries()
    {
        return $this->hasMany('App\Entry');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($schedule) { // before delete() method call this
            foreach ($schedule->entries as $entry) {
                $entry->delete();
            }
        });
    }
}
