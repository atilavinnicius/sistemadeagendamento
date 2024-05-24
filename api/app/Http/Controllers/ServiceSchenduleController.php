<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceSchenduleRequest;
use App\Models\ServiceSchedule;

class ServiceSchenduleController extends Controller
{
    public function index()
    {
        $schedules = ServiceSchedule::all();
        return response()->json($schedules);
    }

    public function store(ServiceSchenduleRequest $request)
    {
        $validatedData = $request->validated();
        $schedule = ServiceSchedule::create($validatedData);
        return response()->json($schedule, 201);
    }

    public function show($id)
    {
        $schedule = ServiceSchedule::findOrFail($id);
        return response()->json($schedule);
    }

    public function update(ServiceSchenduleRequest $request, $id)
    {
        $schedule = ServiceSchedule::findOrFail($id);
        $validatedData = $request->validated();
        $schedule->update($validatedData);
        return response()->json($schedule, 200);
    }

    public function destroy($id)
    {
        $schedule = ServiceSchedule::findOrFail($id);
        $schedule->delete();
        return response()->json(null, 204);
    }
}
