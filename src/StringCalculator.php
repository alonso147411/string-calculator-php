<?php

namespace Deg540\StringCalculatorPHP;


use Exception;

class StringCalculator
{
    /**
     * @throws Exception
     */
    function add(string $numbers): int
    {

        if (empty($numbers)) {
            return 0;
        }

        if (str_contains($numbers, '-')) {
            $negativeNumbers = array_filter(explode(',', $numbers), fn($num) => $num < 0);
            throw new Exception('Números negativos no permitidos: ' . implode(',', $negativeNumbers));
        }

        if (preg_match_all('/\d+/', $numbers, $matches)) {
            $numbersArray = array_filter($matches[0], fn($num) => $num <= 1000);

            return $this->getArrayWithSumOfNumbers($numbersArray);
        }

        if (str_starts_with('//', $numbers)) {
            $delimiterSection = substr($numbers, 2, strpos($numbers, '\n') - 2);
            $numbers = substr($numbers, strpos($numbers, '\n') + 1);
            $delimiters = [];
            preg_match_all('/\[(.*?)]/', $delimiterSection, $delimiters);
            if (empty($delimiters[1])) {
                $delimiters = [$delimiterSection];
            } else {
                $delimiters = $delimiters[1];
            }
            $pattern = '/[' . implode('', array_map('preg_quote', $delimiters)) . ']/';
            $numbersArray = preg_split($pattern, $numbers);

            return $this->getArrayWithSumOfNumbers($numbersArray);
        }

        if (str_contains($numbers, ',') && str_contains($numbers, '\n')) {
            $numbers = str_replace('\n', ',', $numbers);

            return $this->getArrayWithSumOfNumbers(explode(',', $numbers));
        }

        if (str_contains($numbers, ',')) {
            return $this->getArrayWithSumOfNumbers(explode(',', $numbers));
        }

        return $numbers;

    }



    /**
     * @param array $numbersArray
     * @return float|int
     */
    private function getArrayWithSumOfNumbers(array $numbersArray): int|float
    {
        return array_sum($numbersArray);
    }


}
