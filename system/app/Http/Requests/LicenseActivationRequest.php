<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LicenseActivationRequest extends FormRequest
{
    use JsonValidatorErrors;

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
        $this->sanitize();

        return [
            'license'   => 'required|max:512',
            'slug'      => 'required|max:256',
            'site'      => 'required|max:512',
            'site-meta' => 'json'
        ];
    }

    /**
     * Sanitize the requests input.
     * @return void
     */
    public function sanitize()
    {
        $input = $this->all();

        if (array_key_exists('site', $input))
            $input['site'] = $input['site']; // TODO normalize site url

        if (!array_key_exists('site-meta', $input))
            $input['site-meta'] = '{}';

        $this->replace($input);     
    }
}
