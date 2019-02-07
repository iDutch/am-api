<?php

namespace App\Http\Requests;

use App\Schedule;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch($this->method()) {
            case 'GET':
            {
                $schedule = $this->route('schedule');
                return $schedule && $this->user()->can('view', $schedule);
            }
            case 'DELETE':
            {
                if (is_array($this->input('id'))) {
                    foreach ($this->input('id') as $id) {
                        $schedule = Schedule::find($id);
                        if (!$schedule || !$this->user()->can('delete', $schedule)) {
                            return false;
                        }
                    }
                    return true;
                } else {
                    $schedule = Schedule::find($this->input('id'));
                    return $schedule && $this->user()->can('delete', $schedule);
                }
            }
            case 'POST':
            {
                return $this->user()->can('create', Schedule::class);
            }
            case 'PUT':
            case 'PATCH':
            {
                $schedule = $this->route('schedule');
                return $schedule && $this->user()->can('update', $schedule);
            }
            default:break;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required',
                ];
            }
            default:break;
        }
    }
}
