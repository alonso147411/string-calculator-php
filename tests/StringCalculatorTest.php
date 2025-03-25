<?php

declare(strict_types=1);

namespace Deg540\StringCalculatorPHP\Test;

use Deg540\StringCalculatorPHP\StringCalculator;
use Exception;
use PHPUnit\Framework\TestCase;

final class StringCalculatorTest extends TestCase
{
    private  StringCalculator $stringCalculator;
    protected function setUp(): void
    {
        parent::setUp();
        $this->stringCalculator = new StringCalculator();
    }

    /**
     * @test
     * @throws Exception
     */
    public function givenEmptyStringReturns0(): void
    {
        $this->assertEquals(0, $this->stringCalculator->add(""));
    }

    /**
     * @test
     * @throws Exception
     */
    public function givenSingleNumberReturnsItself(): void
    {
        $this->assertEquals(1, $this->stringCalculator->add('1'));
    }

    /**
     * @test
     * @throws Exception
     */
    public function givenTwoNumbersReturnsTheirSum(): void
    {
        $this->assertEquals(3, $this->stringCalculator->add('1,2'));
    }

    /**
     * @test
     * @throws Exception
     */
    public function givenNumbersSeperatedByComasReturnsSumOfNumbers(): void{
        $this->assertEquals(6, $this->stringCalculator->add('1,2,3'));
    }


    /**
     * @test
     * @throws Exception
     */
    public function givenNumbersSeperatedByComasAndLineBreakReturnsSumOfNumbers(): void
    {
        $this->assertEquals(6, $this->stringCalculator->add("1\n2,3"));
    }

    /**
     * @test
     * @throws Exception
     */
    public function givenNumbersSeperatedByCustomDelimiterReturnsSumOfNumbers(): void
    {
        $this->assertEquals(3, $this->stringCalculator->add("//;\n1;2"));
    }

    /**
     * @test
     */
    public function givenNegativeNumberThrowsException(): void
    {
        $this->expectException(Exception::class);
        $this->stringCalculator->add("-1");
        $this->expectExceptionMessage('Números negativos no permitidos -1');
    }

    /**
     * @test
     */
    public function givenMoreThanOneNegativeNumbersThrowsException(): void
    {
        $this->expectException(Exception::class);
        $this->stringCalculator->add("1,-1,3,-2,4");
        $this->expectExceptionMessage('Números negativos no permitidos: -1,-2');
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function givenNumbersGreaterThan1000AreIgnored(): void{
        $this->assertEquals(5, $this->stringCalculator->add("2,1001,3"));
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function givenDelimiterOfAnyLengthReturnsSumOfNumbers(): void
    {
        $this->assertEquals(6, $this->stringCalculator->add("//[***]\n1***2***3"));
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function givenMultipleDelimitersReturnsSumOfNumbers(): void
    {
        $this->assertEquals(8, $this->stringCalculator->add("//[*][%]\n1*2%3%1*1"));
    }

    /**
     * @test
     *
     * @throws Exception
     */
    public function givenMultipleDelimitersOfAnyLengthReturnsSumOfNumbers(): void
    {
        $this->assertEquals(6, $this->stringCalculator->add("//[**][%%][****]\n1**2%%3****0"));
    }
}
