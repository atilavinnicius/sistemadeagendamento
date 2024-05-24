<?php

namespace App\Observers;

use App\Models\ScheduleStatusLog;
use App\Models\ServiceSchedule;
use Illuminate\Http\Request;

class ServiceScheduleObserver
{
    /**
     * Handle the ServiceSchendule "created" event.
     */
    public function created(ServiceSchedule $serviceSchendule): void
    {
        //
    }

    /**
     * Handle the ServiceSchendule "updated" event.
     */
    public function updated(ServiceSchedule $serviceSchedule, Request $request)
    {
        if ($serviceSchedule->isDirty('status')) {
            ScheduleStatusLog::create([
                'schedule_id' => $serviceSchedule->id,
                'description' => 'Status changed from ' . $serviceSchedule->getOriginal('status') . ' to ' . $serviceSchedule->status,
                $userId = $request->user_id, //CRIAR MIDLLEWARE JWT PARA ADD O USER ID
            ]);
        }
    }
/*
class JWTMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Adiciona o ID do usuário ao objeto Request
        $request->merge(['user_id' => $user->id]);

        return $next($request);
    }
}
*/
    /**
     * Handle the ServiceSchendule "deleted" event.
     */
    public function deleted(ServiceSchedule $serviceSchendule): void
    {
        //
    }

    /**
     * Handle the ServiceSchendule "restored" event.
     */
    public function restored(ServiceSchedule $serviceSchendule): void
    {
        //
    }

    /**
     * Handle the ServiceSchendule "force deleted" event.
     */
    public function forceDeleted(ServiceSchedule $serviceSchendule): void
    {
        //
    }
}
