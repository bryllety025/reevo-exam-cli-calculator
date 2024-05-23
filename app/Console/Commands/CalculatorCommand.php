<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CalculatorCommand extends Command
{
    protected $signature = 'calculator';
    protected $description = 'CLI Calculator';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $input = $this->ask('Please input your numbers in the format "{number1} {operation} {number2}" for basic operations or "{number} sqrt" for square roots:');

        $result = $this->calculate($input);
        $this->info($result);
        
    }

    private function calculate($input)
    {
        $input = trim($input);
        $parts = explode(' ', $input);

        if (count($parts) == 2 && strtolower($parts[1]) == 'sqrt') {
            $number = $parts[0];
            if(!(is_int($number) || is_numeric($number)))
                return "Error: $number is not a number.";

            if ($number < 0) 
                return "Error: Cannot compute square root of a negative number.";
            
            return sqrt($number);
        } elseif (count($parts) == 3) {
            $num1 = $parts[0];
            $operator = $parts[1];
            $num2 = $parts[2];

            if(!(is_int($num1) || is_numeric($num1)))
                return "Error: $num1 is not a number.";

            if(!(is_int($num2) || is_numeric($num2)))
                return "Error: $num2 is not a number.";

            switch ($operator) {
                case '+':
                    return $num1 + $num2;
                case '-':
                    return $num1 - $num2;
                case '*':
                    return $num1 * $num2;
                case '/':
                    if ($num2 == 0) 
                        return "Error: Division by zero.";
                    
                    return $num1 / $num2;
                default:
                    return "Error: Unsupported operator '$operator'.";
            }
        } else {
            return "Invalid input format.";
        }
    }
}