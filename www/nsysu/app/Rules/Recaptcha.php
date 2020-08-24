<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use GuzzleHttp\Client;

class Recaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try{
            if ( ! config('services.recaptcha.api_key')) return true;
            $client = new Client;
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => config('services.recaptcha.api_key'),
                    'response' => $value,
                ],
            ]);
            $response_body = json_decode($response->getBody());
            if ($response->getStatusCode() !== 200 || !optional($response_body)->success) {
                return false;
            } else {
                return true;
            };
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'reCAPTCHA validation failed.';
    }
}
