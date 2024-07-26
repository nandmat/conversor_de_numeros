<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Exception;

class MapController extends Controller
{

    protected $entity;

    public function __construct(Map $map)
    {
        $this->entity = $map;
    }

    public function getResult(string $argument, string $type)
    {
        try {
            switch ($type) {
                case 'roman_to_decimal':
                    $result = $this->getRomanNumberToDecimalNumber(strtolower($argument));
                    break;
                case 'decimal_to_roman':
                    $decimalNumber = intval($argument);
                    $result = $this->getDecimalNumberToRomanNumber($decimalNumber);
                    break;
            }

            return response()->json([
                'type' => $type,
                'result' => $result
            ]);
        } catch (Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * O lop vai ser o que realmente precisamos para controlar a conversão do decimal para romano,
     * atraés dele podemos verificar a subitração do valor do numero decimal e se seu valor ainda é correspondente dentro
     * da logica.
     *
     */

    private function getDecimalNumberToRomanNumber(int $decimalNumber)
    {
        //Pegando os valores previamente cadastrados no banco de dados através de um Seeder
        $maps = $this->entity->all();
        //Declarando a variável que vai receber os valores referentes ao algarismo romano desejado
        $romanNumberal = '';
        foreach ($maps as $map) {

            while ($decimalNumber >= $map->decimal_value) {
                $romanNumberal = $romanNumberal . $map->roman_numeral;
                $decimalNumber = $decimalNumber - $map->decimal_value;
            }
        }

        return strtoupper($romanNumberal);
    }

    /**
     * aqui precisamos pegar valores especificos no db, pois cadastramos valores unicos para fazer funcionar
     * na parte de converter de numero romano para numeral
     */

    private function getRomanNumberToDecimalNumber(string $romanNumber)
    {
        // Pegando valores específicos no banco de dados
        $maps = $this->entity
            ->whereIn('roman_numeral', ['m', 'd', 'c', 'l', 'x', 'v', 'i'])
            ->get()
            ->keyBy('roman_numeral');

        $decimalNumber = 0;
        $romanNumberLength = strlen($romanNumber);

        for ($i = 0; $i < $romanNumberLength; $i++) {
            $algarism = $romanNumber[$i];
            $currentNumber = isset($maps[$algarism]) ? $maps[$algarism]->decimal_value : 0;

            // Verifica se existe mais um caractere do algarismo romano informado
            if ($i + 1 < $romanNumberLength) {
                $nextAlgarism = $romanNumber[$i + 1];
                $nextCurrentNumber = isset($maps[$nextAlgarism]) ? $maps[$nextAlgarism]->decimal_value : 0;

                // Se o valor atual for menor que o valor do próximo, subtrai
                if ($nextCurrentNumber > $currentNumber) {
                    $decimalNumber -= $currentNumber;
                } else {
                    $decimalNumber += $currentNumber;
                }
            } else {
                // Se não existir mais caracteres, adiciona o valor atual
                $decimalNumber += $currentNumber;
            }
        }

        return $decimalNumber;
    }
}
