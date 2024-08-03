<?php

namespace App\Http\Controllers;

use App\Models\ConversaoModel;
use Illuminate\Http\Request;
use App\Http\Requests\ConversaoRequest;

class ConversaoController extends Controller
{

    public function index()
    {
        return view('conversao');
    }

    public function verificarConversao(ConversaoRequest $request)
    {

        $validatedData = $request->validated();


        if (is_numeric($validatedData['numero'])) {
            $validatedData['tipo'] = 'romano';
            return $this->converterDecimalParaRomano($validatedData['numero']);
        } else {
            $validatedData['tipo'] = 'decimal';
            return $this->converterRomanoParaDecimal($validatedData['numero']);

        }

        

    }


    public function converterRomanoParaDecimal($romano)
    {
        $decimal = $this->romanoParaDecimal($romano);
        $this->salvarConversao(request()->ip(), $romano, $decimal);

        return view('conversao', ['romano' => $romano, 'decimal' => $decimal]);
    }

    public function converterDecimalParaRomano($numero)
    {
        $decimal = intval($numero);

        $romano = $this->decimalParaRomano($decimal);
        // dd($romano);
        $this->salvarConversao(request()->ip(), $decimal, $romano);

        return view('conversao', ['decimal' => $decimal, 'romano' => $romano]);
    }


    public function romanoParaDecimal($romano)
    {
        $romano = strtoupper($romano); // Converte todas as letras para maiúsculas
        $pattern = '/^(?=[MDCLXVI])M*(C[MD]|D?C{0,3})(X[CL]|L?X{0,3})(I[XV]|V?I{0,3})$/';
        if (!preg_match($pattern, $romano)) {
            return redirect()->back()->withInput()->withErrors(['numero' => 'O valor deve ser uma letra romana válida']);
        }
        $numeros = [
            'I' => 1,
            'V' => 5,
            'X' => 10,
            'L' => 50,
            'C' => 100,
            'D' => 500,
            'M' => 1000
        ];

        $decimal = 0;
        $romano = str_split(strrev($romano)); // Reverte a string para começar a partir do último caractere e transforma em array
        $tamanho = count($romano); // Guarda o tamanho do array

        for ($i = 0; $i < $tamanho; $i++) {
            $atual = $romano[$i];
            $proximo = isset($romano[$i + 1]) ? $numeros[$romano[$i + 1]] : 0; // Verifica se existe próximo caractere

            if ($proximo === 0 || $numeros[$atual] >= $proximo) {
                $decimal += $numeros[$atual];
            } else {
                $decimal -= $numeros[$atual];
            }
        }

        return $decimal;
    }

    private function decimalParaRomano($decimal)
    {

        $numeros = [1000 => 'M', 900 => 'CM', 500 => 'D', 400 => 'CD', 100 => 'C', 90 => 'XC', 50 => 'L', 40 => 'XL', 10 => 'X', 9 => 'IX', 5 => 'V', 4 => 'IV', 1 => 'I'];
        $romano = '';

        while ($decimal > 0) {
            foreach ($numeros as $num => $letra) {
                if ($decimal >= $num) {
                    $romano .= $letra;
                    $decimal -= $num;
                    break;
                }
            }
        }

        return $romano;
    }

    private function salvarConversao($ip, $entrada, $saida)
    {

        if(!is_string($saida) || empty($saida)){
            $saida = '0';
        }
        ConversaoModel::create([
            'ip' => $ip,
            'numero_decimal' => $entrada,
            'numero_romano' => $saida,
        ]);
    }
    public function historico()
    {
        $conversao = ConversaoModel::orderBy('id', 'desc')->get();

        return view('conversao.historico', ['conversao' => $conversao]);
    }
}
