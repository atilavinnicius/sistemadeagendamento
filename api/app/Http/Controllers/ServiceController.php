<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        try {
            $services = $this->serviceService->getAllServices();
            return response()->json($services);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar serviços.', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(ServiceRequest $request)
    {
        try {
            $service = $this->serviceService->createService($request->validated());
            return response()->json($service, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $service = $this->serviceService->getServiceById($id);
            if (!$service) {
                return response()->json(['error' => 'Serviço não encontrado.'], 404);
            }
            return response()->json($service);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar serviço.'], 500);
        }
    }

    public function update(ServiceRequest $request, $id)
    {
        try {
            $service = $this->serviceService->getServiceById($id);

            if (!$service) {
                return response()->json(['error' => 'Service not found.'], 404);
            }

            $this->serviceService->updateService($service, $request->validated());

            return response()->json($service);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $this->serviceService->deleteService($id);
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
