<?php

namespace App\Services;

use App\Models\Service;
use App\Models\ServicePhoto;
use App\Models\ServicePhotoPerfil;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ServiceService
{
    public function createService(array $serviceData)
    {
        $service = Service::create($serviceData);

        if (isset($serviceData['photos'])) {
            $this->addServicePhotos($service, $serviceData['photos']);
        }

        if (isset($serviceData['perfil_photo'])) {
            $this->addPerfilPhoto($service, $serviceData['perfil_photo']);
        }

        return $service;
    }

    protected function addServicePhotos(Service $service, array $photos)
    {
        foreach ($photos as $photo) {
            $path = $photo->store('public/services');
            ServicePhoto::create([
                'service_id' => $service->id,
                'path' => $path,
            ]);
        }
    }

    protected function addPerfilPhoto(Service $service, $perfilPhoto)
    {
        $fileName = $service->id . '_' . $service->title . '_' . number_format($perfilPhoto->getSize() / 1024, 2) . ' KB';
        $extension = $perfilPhoto->getClientOriginalExtension();
        $finalFileName = $fileName . '.' . $extension;
        $path = $perfilPhoto->storeAs('public/services/perfil', $finalFileName);
        ServicePhotoPerfil::create([
            'service_id' => $service->id,
            'path' => $path,
        ]);
    }

    public function getAllServices()
    {
        return Service::all();
    }

    public function getServiceById($id): ?Service
    {
        return Service::find($id);
    }
    public function updateService(Service $service, array $serviceData)
    {

        $service->update($serviceData);

        if (isset($serviceData['photos'])) {
            $this->updateServicePhotos($service, $serviceData['photos'], $serviceData['photos_to_delete']);
        }

        if (isset($serviceData['perfil_photo'])) {
            $this->updatePerfilPhoto($service, $serviceData['perfil_photo']);
        }
    }

    protected function updateServicePhotos(Service $service, array $photos, array $photosToDelete)
    {

        foreach ($photos as $photo) {
            $fileName = $service->id . '_' . str_replace(' ', '_', $service->title) . '_' . number_format($photo->getSize() / 1024, 2) . 'KB';
            $extension = $photo->getClientOriginalExtension();
            $finalFileName = $fileName . '.' . $extension;
            $path = $photo->storeAs('public/services', $finalFileName);

            ServicePhoto::create([
                'service_id' => $service->id,
                'path' => $path,
            ]);
        }

        foreach ($photosToDelete as $photoId) {
            $photo = ServicePhoto::find($photoId);

            if ($photo) {
                Storage::delete($photo->path);
                $photo->delete();
            }
        }
    }




    protected function updatePerfilPhoto(Service $service, $perfilPhoto)
    {
        if ($perfilPhoto) {
            if ($service->perfilPhoto) {
                Storage::delete($service->perfilPhoto->path);
                $service->perfilPhoto->delete();
            }
            $fileName = $service->id . '_' . $service->title . '_' . number_format($perfilPhoto->getSize() / 1024, 2) . ' KB';
            $extension = $perfilPhoto->getClientOriginalExtension();
            $finalFileName = $fileName . '.' . $extension;
            $path = $perfilPhoto->storeAs('public/services/perfil', $finalFileName);
            ServicePhotoPerfil::create([
                'service_id' => $service->id,
                'path' => $path,
            ]);
        }
    }



    public function deleteService($id): void
    {
        $service = Service::find($id);
        if (!$service) {
            throw new Exception('Service not found.');
        }

        $service->delete();
    }
}
