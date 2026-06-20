<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Collection;

class CorPdfGenerator
{
    private array $commands = [];

    public function generate(array $data): string
    {
        $this->commands = [];

        /** @var Student $student */
        $student = $data['student'];
        /** @var Collection $enrollments */
        $enrollments = $data['enrollments'];

        $this->text(250, 755, 10, 'Republic of the Philippines');
        $this->text(214, 741, 12, strtoupper((string) $data['schoolName']));
        $this->text(235, 727, 10, (string) $data['schoolLocation']);
        $this->text(224, 709, 11, 'Certificate of Registration (COR)');

        $this->text(48, 684, 9, 'Name:');
        $this->text(78, 684, 9, $student->name);
        $this->text(48, 670, 9, 'ID No:');
        $this->text(82, 670, 9, $student->student_number ?: (string) $student->id);
        $this->text(260, 670, 9, 'Course/Yr:');
        $this->text(312, 670, 9, (string) $data['courseYear']);
        $this->text(410, 684, 9, 'Period:');
        $this->text(450, 684, 9, (string) $data['period']);
        $this->text(410, 670, 9, 'Date:');
        $this->text(442, 670, 9, (string) $data['corDate']);

        $this->line(38, 658, 574, 658);
        $headers = [
            [40, 'Code'],
            [78, 'Subject Code'],
            [152, 'Subject Description'],
            [315, 'Units'],
            [350, 'TF'],
            [382, 'Lab'],
            [415, 'Schedule'],
            [500, 'Instructor'],
            [560, 'Section'],
        ];

        foreach ($headers as [$x, $label]) {
            $this->text($x, 646, 8, $label);
        }
        $this->line(38, 640, 574, 640);

        $y = 628;
        foreach ($enrollments as $index => $enrollment) {
            $this->text(43, $y, 8, (string) ($index + 1));
            $this->text(78, $y, 8, $this->fit($enrollment->subject->code, 12));
            $this->text(152, $y, 8, $this->fit($enrollment->subject->name, 28));
            $this->text(320, $y, 8, number_format((float) $enrollment->subject->units, 1));
            $this->text(352, $y, 8, number_format((float) $enrollment->tf_units, 1));
            $this->text(386, $y, 8, number_format((float) $enrollment->lab_units, 1));
            $this->text(415, $y, 8, $this->fit($enrollment->schedule ?: 'TBA', 16));
            $this->text(500, $y, 8, $this->fit($enrollment->instructor ?: 'TBA', 12));
            $this->text(560, $y, 8, $this->fit($enrollment->section ?: '-', 8));
            $y -= 14;
        }

        $this->line(38, $y + 7, 574, $y + 7);
        $this->text(250, $y - 5, 8, 'Total Units:');
        $this->text(320, $y - 5, 8, number_format((float) $data['totalUnits'], 1));
        $this->text(352, $y - 5, 8, number_format((float) $data['totalTf'], 1));
        $this->text(386, $y - 5, 8, number_format((float) $data['totalLab'], 1));

        $assessmentY = $y - 35;
        $this->text(245, $assessmentY, 10, 'Assessment');
        $this->text(430, $assessmentY, 10, 'Amount');
        $this->text(500, $assessmentY, 10, 'Total');
        $this->text(58, $assessmentY - 24, 9, 'Tuition Fees');
        $this->text(92, $assessmentY - 38, 8, 'Tuition Fee');
        $this->text(320, $assessmentY - 38, 8, number_format((float) $data['totalUnits'], 1).' x '.number_format((float) $data['tuitionRate'], 2).'/unit');
        $this->text(435, $assessmentY - 38, 8, number_format((float) $data['tuitionFees'], 2));
        $this->text(505, $assessmentY - 38, 8, number_format((float) $data['tuitionFees'], 2));

        $feeY = $assessmentY - 65;
        $this->text(58, $feeY, 9, 'Other Fees');
        foreach ($data['otherFees'] as $label => $amount) {
            $feeY -= 13;
            $this->text(92, $feeY, 8, $this->fit($label, 32));
            $this->text(435, $feeY, 8, number_format((float) $amount, 2));
        }
        $feeY -= 24;
        $this->text(58, $feeY, 9, 'Total Assessment');
        $this->text(505, $feeY, 9, number_format((float) $data['totalAssessment'], 2));

        $summaryY = $feeY - 30;
        $this->line(38, $summaryY + 14, 260, $summaryY + 14);
        $this->text(72, $summaryY, 9, 'Summary');
        $this->text(145, $summaryY, 9, 'Amount');
        $this->text(58, $summaryY - 16, 8, 'Current Assessment');
        $this->text(160, $summaryY - 16, 8, number_format((float) $data['currentAssessment'], 2));
        $this->text(58, $summaryY - 30, 8, 'Discounts/Scholarships');
        $this->text(160, $summaryY - 30, 8, number_format((float) $data['discounts'], 2));
        $this->text(58, $summaryY - 44, 8, 'Previous Balance');
        $this->text(160, $summaryY - 44, 8, number_format((float) $data['previousBalance'], 2));
        $this->text(58, $summaryY - 58, 8, 'Current Receivable');
        $this->text(160, $summaryY - 58, 8, number_format((float) $data['currentReceivable'], 2));

        $this->line(282, $summaryY + 14, 574, $summaryY + 14);
        $this->text(370, $summaryY, 9, 'Payment Schedule');
        $this->text(490, $summaryY, 9, 'Amount');
        $paymentY = $summaryY - 16;
        foreach ($data['paymentSchedule'] as $row) {
            $this->text(295, $paymentY, 8, $this->fit($row['due'], 30));
            $this->text(492, $paymentY, 8, number_format((float) $row['amount'], 2));
            $paymentY -= 14;
        }

        $this->text(205, 42, 7, 'System-generated COR - Generated '.$data['generatedAt']->format('Y-m-d H:i'));

        return $this->buildPdf(implode("\n", $this->commands));
    }

    private function text(int $x, int $y, int $size, string $text): void
    {
        $this->commands[] = sprintf('BT /F1 %d Tf %d %d Td (%s) Tj ET', $size, $x, $y, $this->escape($text));
    }

    private function line(int $x1, int $y1, int $x2, int $y2): void
    {
        $this->commands[] = sprintf('%d %d m %d %d l S', $x1, $y1, $x2, $y2);
    }

    private function fit(?string $text, int $max): string
    {
        $text = trim((string) $text);

        return strlen($text) > $max ? substr($text, 0, max(0, $max - 3)).'...' : $text;
    }

    private function escape(string $text): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }

    private function buildPdf(string $stream): string
    {
        $objects = [
            "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n",
            "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n",
            "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>\nendobj\n",
            "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n",
            "5 0 obj\n<< /Length ".strlen($stream)." >>\nstream\n".$stream."\nendstream\nendobj\n",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $xref = strlen($pdf);
        $pdf .= "xref\n0 ".(count($objects) + 1)."\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdf .= "trailer\n<< /Size ".(count($objects) + 1)." /Root 1 0 R >>\n";
        $pdf .= "startxref\n".$xref."\n%%EOF";

        return $pdf;
    }
}
