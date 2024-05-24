<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Models\ServicePhoto;
use App\Models\ServicePhotoPerfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['photos', 'perfilPhoto'])->get();
        return response()->json($services);
    }

    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->validated());

        if ($request->has('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('public/services');
                ServicePhoto::create([
                    'service_id' => $service->id,
                    'path' => $path,
                ]);
            }
        }

        if ($request->has('perfil_photo')) {
            $path = $request->file('perfil_photo')->store('public/services/perfil');
            ServicePhotoPerfil::create([
                'service_id' => $service->id,
                'path' => $path,
            ]);
        }

        return response()->json($service->load(['photos', 'perfilPhoto']), 201);
    }

    public function show(Service $service)
    {
        return response()->json($service->load(['photos', 'perfilPhoto']));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        if ($request->has('photos')) {
            foreach ($service->photos as $photo) {
                Storage::delete($photo->path);
                $photo->delete();
            }

            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('public/services');
                ServicePhoto::create([
                    'service_id' => $service->id,
                    'path' => $path,
                ]);
            }
        }

        if ($request->has('perfil_photo')) {
            if ($service->perfilPhoto) {
                Storage::delete($service->perfilPhoto->path);
                $service->perfilPhoto->delete();
            }

            $path = $request->file('perfil_photo')->store('public/services/perfil');
            ServicePhotoPerfil::create([
                'service_id' => $service->id,
                'path' => $path,
            ]);
        }

        return response()->json($service->load(['photos', 'perfilPhoto']));
    }

    public function destroy(Service $service)
    {
        foreach ($service->photos as $photo) {
            Storage::delete($photo->path);
        }

        if ($service->perfilPhoto) {
            Storage::delete($service->perfilPhoto->path);
        }

        $service->delete();
        return response()->json(null, 204);
    }
}
