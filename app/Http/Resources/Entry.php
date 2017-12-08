<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Entry extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'time' => $this->time,
            'colors' => [
                'red' => $this->red,
                'green' => $this->green,
                'blue' => $this->blue,
                'warmwhite' => $this->warmwhite,
                'coldwhite' => $this->coldwhite,
            ],
        ];
    }
}
