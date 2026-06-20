<?php

namespace App\Http\Controllers;

use App\Models\InterviewSchedule;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InterviewScheduleController extends Controller
{
    public function index()
    {
        $month = Carbon::createFromFormat('Y-m', request('month', now()->format('Y-m')))
            ->startOfMonth();
        $calendarStart = $month->copy()->startOfWeek();
        $calendarEnd = $month->copy()->endOfMonth()->endOfWeek();

        $interviews = InterviewSchedule::with(['student:id,name,email,course'])
            ->whereBetween('starts_at', [$calendarStart, $calendarEnd])
            ->orderBy('starts_at')
            ->get()
            ->groupBy(fn (InterviewSchedule $schedule) => $schedule->starts_at->toDateString());

        $days = [];
        for ($day = $calendarStart->copy(); $day <= $calendarEnd; $day->addDay()) {
            $days[] = $day->copy();
        }

        $students = Student::query()
            ->where(function ($query) {
                $query->where('year_level', '1')
                    ->orWhere('enrollment_status', 'pending')
                    ->orWhere('enrollment_status', 'first_time');
            })
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'course', 'year_level', 'enrollment_status']);

        return view('interviews.index', [
            'students' => $students,
            'interviews' => $interviews,
            'weeks' => array_chunk($days, 7),
            'month' => $month,
            'previousMonth' => $month->copy()->subMonth()->format('Y-m'),
            'nextMonth' => $month->copy()->addMonth()->format('Y-m'),
        ]);
    }

    public function events(Request $request)
    {
        $start = $request->date('start');
        $end = $request->date('end');

        $query = InterviewSchedule::with(['student:id,name,email', 'scheduler:id,name']);

        if ($start && $end) {
            $query->where('starts_at', '<', $end)->where('ends_at', '>', $start);
        }

        $events = $query->get()->map(fn (InterviewSchedule $schedule) => [
            'id' => $schedule->id,
            'title' => $schedule->title,
            'start' => $schedule->starts_at->toIso8601String(),
            'end' => $schedule->ends_at->toIso8601String(),
            'extendedProps' => [
                'student_id' => $schedule->student_id,
                'student_name' => $schedule->student?->name,
                'mode' => $schedule->mode,
                'location' => $schedule->location,
                'status' => $schedule->status,
                'notes' => $schedule->notes,
            ],
        ]);

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'title' => ['required', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'mode' => ['required', Rule::in(['on-site', 'online', 'hybrid'])],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['scheduled', 'completed', 'cancelled', 'rescheduled'])],
            'notes' => ['nullable', 'string'],
        ]);

        InterviewSchedule::create([
            ...$validated,
            'scheduled_by' => auth()->id(),
        ]);

        return redirect()->route('interviews.index')->with('success', 'Interview scheduled successfully.');
    }

    public function update(Request $request, InterviewSchedule $interview)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'title' => ['required', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'mode' => ['required', Rule::in(['on-site', 'online', 'hybrid'])],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['scheduled', 'completed', 'cancelled', 'rescheduled'])],
            'notes' => ['nullable', 'string'],
        ]);

        $interview->update($validated);

        return redirect()->route('interviews.index')->with('success', 'Interview updated successfully.');
    }

    public function destroy(InterviewSchedule $interview)
    {
        $interview->delete();

        return redirect()->route('interviews.index')->with('success', 'Interview removed.');
    }
}
