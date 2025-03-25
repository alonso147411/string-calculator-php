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

        if (empty($numbers))
        {
            return 0;
        }

        if (str_contains($numbers, '-')) {
            $negativeNumbers = array_filter(explode(',', $numbers), fn($num) => $num < 0);
            throw new Exception('Números negativos no permitidos: ' . implode(',', $negativeNumbers));
        }

        if (preg_match_all('/\d+/', $numbers, $matches)) {
            $numbersArray = array_filter($matches[0], fn($num) => $num <= 1000);
            return array_sum($numbersArray);
        }


        if ($numbers[0] == '/' && $numbers[1] == '/') {
            $delimiterSection = substr($numbers, 2, strpos($numbers, "\n") - 2);
            $numbers = substr($numbers, strpos($numbers, "\n") + 1);
            $delimiters = [];
            preg_match_all('/\[(.*?)]/', $delimiterSection, $delimiters);
            if (empty($delimiters[1])) {
                $delimiters = [$delimiterSection];
            } else {
                $delimiters = $delimiters[1];
            }
            $pattern = '/[' . implode('', array_map('preg_quote', $delimiters)) . ']/';
            $numbersArray = preg_split($pattern, $numbers);
            return array_sum($numbersArray);
        }


        if ($this->getContainsComaInString($numbers) && str_contains($numbers, "\n")) {
            $numbers = str_replace("\n", ',', $numbers);
            return $this->getSumNumbersSeparatedByComas($numbers);
        }

        if ($this->getContainsComaInString($numbers)) {
            return $this->getSumNumbersSeparatedByComas($numbers);
        }


        return $numbers;

    }

    /**
     * @param string $numbers
     * @return float|int
     */
    private function getSumNumbersSeparatedByComas(string $numbers): int|float
    {
        return array_sum(explode(',', $numbers));
    }

    /**
     * @param string $numbers
     * @return bool
     */
    private function getContainsComaInString(string $numbers): bool
    {
        return str_contains($numbers, ',');
    }


}
