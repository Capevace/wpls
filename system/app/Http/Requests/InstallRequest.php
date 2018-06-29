<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstallRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'db_host' => 'required|string',
            'db_port' => 'required|integer',
            'db_database' => 'required|string',
            'db_user' => 'required|string',
            'db_pass' => 'required|string',
            'envato_api_key' => 'required|string',
            'app_url' => 'required|url',
            'admin_username' => 'required|string',
            'admin_password' => 'required|string'
        ];
    }
}
