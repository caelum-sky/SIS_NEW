<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Registration</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #000; margin: 18px 22px; }
        .header { text-align: center; margin-bottom: 10px; }
        .header .gov { font-size: 10px; margin: 0; }
        .header .school { font-size: 14px; font-weight: bold; margin: 4px 0 2px; text-transform: uppercase; }
        .header .location { font-size: 10px; margin: 0 0 6px; }
        .header .title { font-size: 12px; font-weight: bold; margin: 0; text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; }
        table.bordered th, table.bordered td { border: 1px solid #000; padding: 3px 4px; }
        table.bordered th { text-align: center; font-weight: bold; background: #f5f5f5; }
        .student-row td { border: 1px solid #000; padding: 4px 6px; vertical-align: top; }
        .student-row .lbl { font-weight: bold; font-size: 8px; display: block; }
        .student-row .val { font-size: 9px; }
        .left { text-align: left; }
        .center { text-align: center; }
        .right { text-align: right; }
        .section-title { font-weight: bold; margin: 10px 0 4px; font-size: 9px; text-transform: uppercase; }
        .two-col { width: 100%; margin-top: 8px; }
        .two-col td { vertical-align: top; width: 50%; padding-right: 6px; }
        .totals-row td { font-weight: bold; }
        .summary td { padding: 2px 4px; }
        .footer { margin-top: 14px; font-size: 7px; color: #444; border-top: 1px solid #999; padding-top: 6px; text-align: center; }
        .signature { margin-top: 20px; }
        .signature td { width: 50%; text-align: center; padding-top: 24px; font-size: 9px; }
        .line { border-top: 1px solid #000; width: 180px; margin: 0 auto 3px; }
    </style>
</head>
<body>
    <div class="header">
        <p class="gov">Republic of the Philippines</p>
        <p class="school">{{ $schoolName }}</p>
        <p class="location">{{ $schoolLocation }}</p>
        <p class="title">Certificate of Registration (COR)</p>
    </div>

    <table class="student-row" style="margin-bottom: 8px;">
        <tr>
            <td style="width: 28%;">
                <span class="lbl">Name</span>
                <span class="val">{{ $student->name }}</span>
            </td>
            <td style="width: 18%;">
                <span class="lbl">ID No.</span>
                <span class="val">{{ $student->student_number ?? 'N/A' }}</span>
            </td>
            <td style="width: 22%;">
                <span class="lbl">Course / Yr</span>
                <span class="val">{{ $courseYear }}</span>
            </td>
            <td style="width: 20%;">
                <span class="lbl">Period</span>
                <span class="val">{{ $period }}</span>
            </td>
            <td style="width: 12%;">
                <span class="lbl">Date</span>
                <span class="val">{{ $corDate }}</span>
            </td>
        </tr>
    </table>

    <table class="bordered subjects">
        <thead>
            <tr>
                <th style="width:4%">Code</th>
                <th style="width:9%">Subject Code</th>
                <th style="width:26%">Subject Description</th>
                <th style="width:6%">Units</th>
                <th style="width:6%">TF</th>
                <th style="width:6%">Lab</th>
                <th style="width:16%">Schedule</th>
                <th style="width:14%">Instructor</th>
                <th style="width:9%">Section</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $index => $enrollment)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="center">{{ $enrollment->subject->code }}</td>
                    <td class="left">{{ $enrollment->subject->name }}</td>
                    <td class="center">{{ number_format((float) $enrollment->subject->units, 2) }}</td>
                    <td class="center">{{ number_format((float) $enrollment->tf_units, 2) }}</td>
                    <td class="center">{{ number_format((float) $enrollment->lab_units, 2) }}</td>
                    <td class="center">{{ $enrollment->schedule ?? '-' }}</td>
                    <td class="left">{{ $enrollment->instructor ?? '-' }}</td>
                    <td class="center">{{ $enrollment->section ?? '-' }}</td>
                </tr>
            @endforeach
            <tr class="totals-row">
                <td colspan="3" class="right">TOTAL</td>
                <td class="center">{{ number_format($totalUnits, 2) }}</td>
                <td class="center">{{ number_format($totalTf, 2) }}</td>
                <td class="center">{{ number_format($totalLab, 2) }}</td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>

    <table class="two-col">
        <tr>
            <td>
                <div class="section-title">Assessment</div>
                <table class="bordered">
                    <tr>
                        <td class="left">Tuition Fees ({{ number_format($totalUnits, 2) }} units @ {{ number_format($tuitionRate, 2) }})</td>
                        <td class="right" style="width: 28%;">{{ number_format($tuitionFees, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="left" style="font-weight: bold;">Other Fees</td>
                    </tr>
                    @foreach($otherFees as $label => $amount)
                        <tr>
                            <td class="left" style="padding-left: 12px;">{{ $label }}</td>
                            <td class="right">{{ number_format($amount, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="left" style="font-weight: bold;">Total Other Fees</td>
                        <td class="right" style="font-weight: bold;">{{ number_format($totalOtherFees, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="left" style="font-weight: bold;">Total Assessment</td>
                        <td class="right" style="font-weight: bold;">{{ number_format($totalAssessment, 2) }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <div class="section-title">Summary</div>
                <table class="bordered summary">
                    <tr>
                        <td class="left">Current Assessment</td>
                        <td class="right" style="width: 35%;">{{ number_format($currentAssessment, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="left">Discounts / Scholarships</td>
                        <td class="right">{{ number_format($discounts, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="left">Previous Balance</td>
                        <td class="right">{{ number_format($previousBalance, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="left" style="font-weight: bold;">Current Receivable</td>
                        <td class="right" style="font-weight: bold;">{{ number_format($currentReceivable, 2) }}</td>
                    </tr>
                </table>

                <div class="section-title">Payment Schedule</div>
                <table class="bordered">
                    <thead>
                        <tr>
                            <th>Due Date / Term</th>
                            <th style="width: 35%;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentSchedule as $row)
                            <tr>
                                <td class="left">{{ $row['due'] }}</td>
                                <td class="right">{{ number_format($row['amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <table class="signature">
        <tr>
            <td>
                <div class="line"></div>
                Registrar / Authorized Signatory
            </td>
            <td>
                <div class="line"></div>
                Student Signature
            </td>
        </tr>
    </table>

    <div class="footer">
        Generated on {{ $generatedAt->format('F d, Y h:i A') }} - System-generated COR. Reference: public/img/sample-cor.png
    </div>
</body>
</html>