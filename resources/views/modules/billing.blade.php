@extends('layouts.mainlayout')
@section('title', 'Billing & Fees')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <h3 class="text-white fw-bold mb-4">Billing & Fees Management</h3>
        <div class="row g-3 mb-4">
            <div class="col-md-4"><div class="card text-center p-3"><div class="text-muted">Total Billed</div><div class="fs-4 fw-bold">₱{{ number_format($summary['total_billed'], 2) }}</div></div></div>
            <div class="col-md-4"><div class="card text-center p-3"><div class="text-muted">Total Paid</div><div class="fs-4 fw-bold text-success">₱{{ number_format($summary['total_paid'], 2) }}</div></div></div>
            <div class="col-md-4"><div class="card text-center p-3"><div class="text-muted">Outstanding Balance</div><div class="fs-4 fw-bold text-danger">₱{{ number_format($summary['total_balance'], 2) }}</div></div></div>
        </div>
        <div class="table-responsive bg-white rounded-3 shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Student</th><th>SY / Sem</th><th>Tuition</th><th>Fees</th><th>Scholarship</th><th>Paid</th><th>Balance</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>{{ $record->student->name }}</td>
                            <td>{{ $record->school_year }} / {{ $record->semester }}</td>
                            <td>₱{{ number_format($record->tuition_amount, 2) }}</td>
                            <td>₱{{ number_format($record->fee_amount, 2) }}</td>
                            <td>₱{{ number_format($record->scholarship_amount, 2) }}</td>
                            <td>₱{{ number_format($record->paid_amount, 2) }}</td>
                            <td>₱{{ number_format($record->balance, 2) }}</td>
                            <td>{{ $record->status }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No billing records yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $records->links() }}</div>
    </div>
</div>
@endsection
