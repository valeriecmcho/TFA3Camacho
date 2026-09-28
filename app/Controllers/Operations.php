<?php

namespace App\Controllers;

class Operations extends BaseController
{
	public function index(): void
	{
		echo 'Student Number: 202310616';
		echo "<br>";
		echo 'Full Name: Ann Valerie L. Camacho';
		echo "<br>";
		echo 'Degree Program: BSITBA';
		echo "<br>";
		echo 'Year Level: 4th Year';
		echo "<br>";
		echo 'Section: TW35';
	}

    public function displayinfo(string $studentNumber, string $fullName, string $degreeProgram, string $yearLevel, string $section): void
    {
        // Allow using hyphens or plus signs instead of spaces in URL
        $fullName = str_replace(['-', '+'], ' ', $fullName);
        $degreeProgram = str_replace(['-', '+'], ' ', $degreeProgram);
        $yearLevel = str_replace(['-', '+'], ' ', $yearLevel);
        $section = str_replace(['-', '+'], ' ', $section);

        echo 'Student Number: ' . $studentNumber;
        echo "<br>";
        echo 'Full Name: ' . $fullName;
        echo "<br>";
        echo 'Degree Program: ' . $degreeProgram;
        echo "<br>";
        echo 'Year Level: ' . $yearLevel;
        echo "<br>";
        echo 'Section: ' . $section;
    }

	public function compute($num1 = 0, $num2 = 0)
    {
        echo "First Number: $num1<br>";
        echo "Second Number: $num2<br><br>";

        echo "Sum: " . ($num1 + $num2) . "<br>";
        echo "Difference: " . ($num1 - $num2) . "<br>";
        echo "Product: " . ($num1 * $num2) . "<br>";

        if ($num2 != 0) {
            echo "Quotient: " . ($num1 / $num2) . "<br>";
            echo "Remainder: " . ($num1 % $num2) . "<br>";
        } else {
            echo "Quotient: Undefined (division by zero)<br>";
            echo "Remainder: Undefined (division by zero)<br>";
        }
    }
}


