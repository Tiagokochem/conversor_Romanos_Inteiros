<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\ConversaoController;

class ConversaoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Assumindo que qualquer usuário pode fazer essa solicitação
    }

    public function rules()
    {
        return [
            'numero' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'numero.required' => 'O número é obrigatório.',
        ];
    }

   
    protected function passedValidation()
    {
        parent::passedValidation();

        $numero = $this->input('numero');

        if (preg_match('/^(?=[MDCLXVI])M*(C[MD]|D?C{0,3})(X[CL]|L?X{0,3})(I[XV]|V?I{0,3})$/', $numero)) {
            $this->merge(['numero' => app(ConversaoController::class)->romanoParaDecimal($numero)]);
        } else {
            $this->merge(['numero' => (int)$numero]);
        }

        
    }

    

}
