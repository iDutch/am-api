<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrossbarClient extends Model
{
    protected $table = 'crossbar_clients';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'is_admin',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
