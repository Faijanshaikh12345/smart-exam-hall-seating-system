<?php

namespace App\View\Composers;

use App\Models\Conflict;
use App\Models\Exam;
use App\Models\SeatingArrangement;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view): void
    {
        $user = auth()->user();
        $notifications = [];

        if (! $user) {
            $view->with('headerNotifications', $notifications);

            return;
        }

        $notifications = match ($user->role) {
            'admin' => $this->adminNotifications(),
            'staff' => $this->staffNotifications(),
            'student' => $this->studentNotifications($user),
            default => [],
        };

        $view->with('headerNotifications', $notifications);
    }

    protected function adminNotifications(): array
    {
        $items = [];

        $openConflicts = Conflict::whereIn('status', ['open', 'investigating'])->count();
        if ($openConflicts > 0) {
            $items[] = [
                'icon' => 'fas fa-exclamation-triangle text-danger',
                'text' => $openConflicts.' open conflict'.($openConflicts === 1 ? '' : 's'),
                'url' => route('conflicts.index'),
            ];
        }

        $upcomingExams = Exam::where('exam_date', '>=', now()->toDateString())
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->count();
        if ($upcomingExams > 0) {
            $items[] = [
                'icon' => 'fas fa-calendar-alt text-info',
                'text' => $upcomingExams.' upcoming exam'.($upcomingExams === 1 ? '' : 's'),
                'url' => route('exams.index'),
            ];
        }

        $recentSeats = SeatingArrangement::where('created_at', '>=', now()->subDays(7))->count();
        if ($recentSeats > 0) {
            $items[] = [
                'icon' => 'fas fa-chair text-primary',
                'text' => $recentSeats.' seat'.($recentSeats === 1 ? '' : 's').' assigned this week',
                'url' => route('seating-arrangements.index'),
            ];
        }

        return $items;
    }

    protected function staffNotifications(): array
    {
        $items = [];

        $upcomingExams = Exam::where('exam_date', '>=', now()->toDateString())
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->count();
        if ($upcomingExams > 0) {
            $items[] = [
                'icon' => 'fas fa-clipboard-list text-info',
                'text' => $upcomingExams.' upcoming exam dut'.($upcomingExams === 1 ? 'y' : 'ies'),
                'url' => route('staff.exam-duties'),
            ];
        }

        $openConflicts = Conflict::whereIn('status', ['open', 'investigating'])->count();
        if ($openConflicts > 0) {
            $items[] = [
                'icon' => 'fas fa-exclamation-triangle text-danger',
                'text' => $openConflicts.' conflict'.($openConflicts === 1 ? '' : 's').' awaiting review',
                'url' => route('staff.conflicts.index'),
            ];
        }

        $seats = SeatingArrangement::whereHas(
            'exam',
            fn ($q) => $q->where('exam_date', '>=', now()->toDateString())
        )->count();
        if ($seats > 0) {
            $items[] = [
                'icon' => 'fas fa-chair text-primary',
                'text' => $seats.' seat allocation'.($seats === 1 ? '' : 's').' for upcoming exams',
                'url' => route('staff.seating'),
            ];
        }

        return $items;
    }

    protected function studentNotifications($user): array
    {
        $items = [];
        $student = $user->student;

        if (! $student) {
            return $items;
        }

        $upcoming = $student->registrations()
            ->whereHas('exam', fn ($q) => $q->where('exam_date', '>=', now()->toDateString()))
            ->count();
        if ($upcoming > 0) {
            $items[] = [
                'icon' => 'fas fa-calendar-alt text-info',
                'text' => $upcoming.' upcoming exam'.($upcoming === 1 ? '' : 's'),
                'url' => route('student.exams'),
            ];
        }

        $seats = $student->seatingArrangements()->count();
        if ($seats > 0) {
            $items[] = [
                'icon' => 'fas fa-chair text-primary',
                'text' => $seats.' seating arrangement'.($seats === 1 ? '' : 's').' assigned',
                'url' => route('student.seating'),
            ];
        } elseif ($upcoming > 0) {
            $items[] = [
                'icon' => 'fas fa-info-circle text-warning',
                'text' => 'Seat not assigned yet for your upcoming exam(s)',
                'url' => route('student.seating'),
            ];
        }

        return $items;
    }
}
