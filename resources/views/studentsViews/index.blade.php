@extends('layouts.studentlayout')
@section('title','Student Dashboard')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h3 class="welcome-text text-light fw-bold m-0">Grades Table</h3>
                    <form method="GET" action="{{ route('student.cor.download') }}" class="d-flex gap-2 align-items-center">
                        <select name="school_year" class="form-select form-select-sm" style="width:auto">
                            <option value="2025-2026">2025-2026</option>
                            <option value="2024-2025">2024-2025</option>
                        </select>
                        <select name="semester" class="form-select form-select-sm" style="width:auto">
                            <option value="1st Semester">1st Semester</option>
                            <option value="2nd Semester">2nd Semester</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-file-pdf"></i> Download COR (PDF)
                        </button>
                    </form>
                </div>

                <div class="table-responsive rounded-3 shadow-sm bg-white" 
                     style="height:a calc(100vh - 230px); overflow-y: auto;">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light text-white">
                            <tr>
                                <th scope="col">Subject Code</th>
                                <th scope="col">Subject Description</th>
                                <th scope="col">Instructor</th>
                                <th scope="col">Units</th>
                                <th scope="col">Grade</th>
                                <th scope="col">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $totalWeightedGrade = 0;
                            $totalUnits = 0;
                            @endphp

                            @foreach ($enrollments as $enrollment)
                            <tr>
                                <td>{{ $enrollment->subject->code }}</td>
                                <td>{{ $enrollment->subject->name }}</td>
                                <td>{{ $enrollment->instructor }}</td>
                                <td>{{ $enrollment->subject->units }}</td>
                                <td class="fw-bold text-center">
                                    {{ $enrollment->grade->grade ?? '--' }}
                                    @php
                                    if (!empty($enrollment->grade->grade) && 
                                        is_numeric($enrollment->grade->grade) && 
                                        !empty($enrollment->subject->units) && 
                                        optional($enrollment->grade)->status !== 'INC') 
                                        
                                    {
                                        $totalWeightedGrade += (float)$enrollment->grade->grade * (int)$enrollment->subject->units;
                                        $totalUnits += (int)$enrollment->subject->units;
                                    }
                                    @endphp
                                </td>
                                <td class="fw-bold text-center {{ optional($enrollment->grade)->status == 'Passed' ? 'text-success' : 'text-danger' }}">
                                    {{ optional($enrollment->grade)->status ?? 'N/A' }}
                                </td>
                            </tr>
                            @endforeach

                            @if ($enrollments->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center text-muted">No grades available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if ($totalUnits > 0)
                <div class="mt-4 text-center">
                    <h4 class="text-light fw-bold">General Weighted Average (GWA):
                        <span class="badge bg-primary fs-5">{{ number_format($totalWeightedGrade / $totalUnits, 2) }}</span>
                    </h4>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
