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

    private function getRomanNumberToDecimalNumber(string $romanNumber)
    {
        //Usamos os whereIn para pegar valores específicos no db, já que já temos cadastrados conjuntos de numeros romanos
        //e algarismo unitários, por assim dizer
        $maps = $this->entity
            ->whereIn('roman_numeral', ['m', 'd', 'c', 'l', 'x', 'v', 'i'])
            ->get();

        //O valor decimal é inicializado como zero;
        $decimalNumber = 0;

        //Verificando o tamanho da string do numero romano
        $romanNumberLength = strlen($romanNumber);
        for ($i = 0; $i < $romanNumberLength; $i++) {
            $algarism = $romanNumber[$i];

            //declaramos uma function anonima para ficar responsável por lidar com a busca do valor real em
            //relação ao algarismo romano da vez
            $getCurrentNumber = function ($algarism) use ($maps) {
                foreach ($maps as $map) {
                    if ($map->roman_numeral == $algarism) {
                        $value = $map->decimal_value;
                        return $value;
                    }
                }
            };

            $currentNumber = $getCurrentNumber($algarism);

            //Isso verifica se existe mais um caractere do algarismo romano informado
            if ($i + 1 < $romanNumberLength) {
                $nextAlgarism = $romanNumber[$i + 1];
                $nextCurrentNumber = $getCurrentNumber($nextAlgarism);

                //Se o valor o decimal atual for menor que o valor do próximo, vamos subtrair do valor atual
                if ($nextCurrentNumber < $currentNumber) {
                    $decimalNumber = $decimalNumber - $nextCurrentNumber;
                } else {
                    //Se nao for, vamos fazer a adição ao valor atual
                    $decimalNumber = $decimalNumber + $nextCurrentNumber;
                }
            } else {

                //Se não existir mais caracteres no algarismo informado, realizamos a atribuição do valor encontrado até o momento
                $decimalNumber = $decimalNumber + $currentNumber;
            }
        }
        return $decimalNumber;
    }
}
