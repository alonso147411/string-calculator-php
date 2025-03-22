<?php

declare(strict_types=1);

namespace Deg540\StringCalculatorPHP\Test;

use Deg540\StringCalculatorPHP\StringCalculator;
use PHPUnit\Framework\TestCase;

final class StringCalculatorTest extends TestCase
{
    private  StringCalculator $stringCalculator;
    protected function setUp(): void
    {
        // Creamos una instancia de la clase Example antes de cada prueba
        parent::setUp();
        $this->stringCalculator = new StringCalculator();
    }

    /**
     * @test
     */
    public function givenSingleNumberReturnsItself(): void
    {
        $this->assertEquals(1, $this->stringCalculator->add('1'));
    }

    /**
     * @test
     */
    public function givenTwoNumbersReturnsTheirSum(): void
    {
        $this->assertEquals(3, $this->stringCalculator->add('1,2'));
    }

    /**
     * @test
     */
    public function givenNumbersSeperatedByComasReturnsSumOfNumbers(): void{
        $this->assertEquals(6, $this->stringCalculator->add('1,2,3'));
    }


    /**
     * @test
     */
    public function givenNumbersSeperatedByComasAndLineBreakReturnsSumOfNumbers(): void
    {
        $this->assertEquals(6, $this->stringCalculator->add("1\n2,3"));
    }

    /**
     * @test
     */
    public function givenNumbersSeperatedByCustomDelimiterReturnsSumOfNumbers(): void
    {
        $this->assertEquals(3, $this->stringCalculator->add("//;\n1;2"));
    }


    /**
     * @test
     */
    public function givenEmptyStringReturns0(): void
    {
        $this->assertEquals(0, $this->stringCalculator->add(""));
    }

    /**
     * @test
     */
    public function givenNegativeNumberThrowsException(): void
    {
        $this->expectException(\Exception::class);
        $this->stringCalculator->add("-1");
    }

    /**
     * @test
     */
    public function givenMoreThanOneNegativeNumbersThrowsException(): void
    {
        $this->expectException(\Exception::class);
        $this->stringCalculator->add("1,-1,3,-2,4");
    }

    /**
     * @test
     *
     */
    public function givenNumbersGreaterThan1000AreIgnored(): void{
        $this->assertEquals(5, $this->stringCalculator->add("2,1001,3"));
    }

    /**
     * @test
     *
     */
    public function givenDelimiterOfAnyLengthReturnsSumOfNumbers(): void
    {
        $this->assertEquals(6, $this->stringCalculator->add("//[***]\n1***2***3"));
    }

    /**
     * @test
     *
     */
    public function givenMultipleDelimitersReturnsSumOfNumbers(): void
    {
        $this->assertEquals(8, $this->stringCalculator->add("//[*][%]\n1*2%3%1*1"));
    }

    /**
     * @test
     *
     */
    public function givenMultipleDelimitersOfAnyLengthReturnsSumOfNumbers(): void
    {
        $this->assertEquals(6, $this->stringCalculator->add("//[**][%%][****]\n1**2%%3****0"));
    }
}
