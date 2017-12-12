<?php

namespace App\Http\Requests;

use App\Entry;
use Illuminate\Foundation\Http\FormRequest;

class EntryRequest extends FormRequest
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
                $entry = Entry::find($this->route('id'));
                return $entry && $this->user()->can('view', $entry);
            }
            case 'DELETE':
            {
                $entry = Entry::find($this->route('id'));
                return $entry && $this->user()->can('view', $entry);
            }
            case 'POST':
            {
                return $this->user()->can('create', Entry::class);
            }
            case 'PUT':
            case 'PATCH':
            {
                $entry = Entry::find($this->route('id'));
                return $entry && $this->user()->can('view', $entry);
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
                    'time' => 'required|date_format:H:i',
                    'red' => 'required|integer',
                    'green' => 'required|integer',
                    'blue' => 'required|integer',
                    'warmwhite' => 'required|integer',
                    'coldwhite' => 'required|integer',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'time' => 'required|date_format:H:i',
                    'red' => 'required|integer',
                    'green' => 'required|integer',
                    'blue' => 'required|integer',
                    'warmwhite' => 'required|integer',
                    'coldwhite' => 'required|integer',
                ];
            }
            default:break;
        }
    }
}
