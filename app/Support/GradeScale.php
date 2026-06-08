<?php

namespace App\Support;

class GradeScale
{
    public const SPECIAL_GRADES = [
        'INC' => 'Incomplete',
        'FDA' => 'Failure Due to Absences',
    ];

    public static function values(): array
    {
        $values = [];

        for ($grade = 1.00; $grade <= 5.00; $grade += 0.25) {
            $values[] = number_format($grade, 2, '.', '');
        }

        return array_merge($values, array_keys(self::SPECIAL_GRADES));
    }

    public static function statusFor(string $grade): string
    {
        if (array_key_exists($grade, self::SPECIAL_GRADES)) {
            return self::SPECIAL_GRADES[$grade];
        }

        return (float) $grade > 3.00 ? 'Failed' : 'Passed';
    }
}
