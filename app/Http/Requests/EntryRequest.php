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
                if (is_array($this->input('id'))) {
                    foreach ($this->input('id') as $id) {
                        $entry = Entry::find($id);
                        if (!$entry || !$this->user()->can('delete', $entry)) {
                            return false;
                        }
                    }
                    return true;
                } else {
                    $entry = Entry::find($this->input('id'));
                    return $entry && $this->user()->can('delete', $entry);
                }
            }
            case 'POST':
            {
                return $this->user()->can('create', Entry::class);
            }
            case 'PUT':
            case 'PATCH':
            {
                $entry = Entry::find($this->route('id'));
                return $entry && $this->user()->can('update', $entry);
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
                    'red' => 'required|integer|min:0|max:100',
                    'green' => 'required|integer|min:0|max:100',
                    'blue' => 'required|integer|min:0|max:100',
                    'warmwhite' => 'required|integer|min:0|max:100',
                    'coldwhite' => 'required|integer|min:0|max:100',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'time' => 'required|date_format:H:i',
                    'red' => 'required|integer|min:0|max:100',
                    'green' => 'required|integer|min:0|max:100',
                    'blue' => 'required|integer|min:0|max:100',
                    'warmwhite' => 'required|integer|min:0|max:100',
                    'coldwhite' => 'required|integer|min:0|max:100',
                ];
            }
            default:break;
        }
    }
}
