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
                $schedule = Schedule::find($this->route('id'));
                return $schedule && $this->user()->can('view', $schedule);
            }
            case 'DELETE':
            {
                $schedule = Schedule::find($this->input('id'));
                return $schedule && $this->user()->can('delete', $schedule);
            }
            case 'POST':
            {
                return $this->user()->can('create', Schedule::class);
            }
            case 'PUT':
            case 'PATCH':
            {
                $schedule = Schedule::find($this->route('id'));
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
