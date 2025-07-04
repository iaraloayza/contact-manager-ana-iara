<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactsRequest extends FormRequest
{
    public function authorize()
    {
        return true; // autoriza a requisição
    }

    public function rules()
    {
        $contactId = $this->route('contact')?->id ?? null;

        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:contacts,email,' . $contactId,
            'phone' => 'required|string|min:10',
        ];
    }
}