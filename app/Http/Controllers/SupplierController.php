<?php

namespace App\Http\Controllers;

use App\Dtos\SupplierDto;
use App\Http\Requests\SupplierRequest;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    private SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    /**
     * @OA\Post(
     *     path="/suppliers",
     *     summary="Create a supplier",
     *     tags={"Suppliers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SupplierRequest")
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/SupplierResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function createSupplier(SupplierRequest $request): JsonResponse
    {
        $supplier = SupplierDto::fromRequest($request);
        $supplier = $this->supplierService->createSupplier($supplier);

        return response()->json($supplier, 201);
    }

    /**
     * @OA\Get(
     *     path="/suppliers",
     *     summary="Get list of suppliers",
     *     tags={"Suppliers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/SupplierResponse"
     *              )
     *          )
     *     )
     * )
     */
    public function getAllSuppliers(): JsonResponse
    {
        $suppliers = $this->supplierService->getAllSuppliers();

        return response()->json($suppliers, 200);
    }

    /**
     * @OA\Get(
     *     path="/suppliers/active",
     *     summary="Get list of active suppliers",
     *     tags={"Suppliers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/SupplierResponse"
     *              )
     *          )
     *     )
     * )
     */
    public function getActiveSuppliers(): JsonResponse
    {
        $suppliers = $this->supplierService->getActiveSuppliers();

        return response()->json($suppliers, 200);
    }

    /**
     * @OA\Get(
     *     path="/suppliers/next-code",
     *     summary="Get next supplier code",
     *     tags={"Suppliers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="supplierCode",
     *                  type="string",
     *                  example="SUP00001",
     *                  description="Next available supplier code"
     *              )
     *          )
     *     )
     * )
     */
    public function getNextSupplierCode(): JsonResponse
    {
        $supplierCode = $this->supplierService->getNextSupplierCode();

        return response()->json(['supplierCode' => $supplierCode], 200);
    }

    /**
     * @OA\Get(
     *     path="/suppliers/{id}",
     *     summary="Get supplier by id",
     *     tags={"Suppliers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the supplier",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         allowEmptyValue=false,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/SupplierResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid supplier id")
     * )
     */
    public function getSupplier($id): JsonResponse
    {
        $supplier = $this->supplierService->getSupplierById($id);

        return response()->json($supplier, 200);
    }

    /**
     * @OA\Put(
     *     path="/suppliers/{id}",
     *     summary="Update a supplier",
     *     tags={"Suppliers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the supplier",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         allowEmptyValue=false,
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SupplierRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/SupplierResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function updateSupplier($id, SupplierRequest $request): JsonResponse
    {
        $supplierDto = SupplierDto::fromRequest($request);
        $supplier = $this->supplierService->updateSupplier($id, $supplierDto);

        return response()->json($supplier, 200);
    }

    /**
     * @OA\Delete(
     *     path="/suppliers/{id}",
     *     summary="Delete supplier",
     *     tags={"Suppliers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the supplier",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         allowEmptyValue=false,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=204,
     *          description="Success"
     *     ),
     *     @OA\Response(response=400, description="Invalid supplier id")
     * )
     */
    public function deleteSupplier($id): JsonResponse
    {
        $this->supplierService->deleteSupplier($id);

        return response()->json([], 204);
    }

    /**
     * @OA\Put(
     *     path="/suppliers/{id}/active",
     *     summary="Activate a deleted supplier",
     *     tags={"Suppliers"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the supplier",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         allowEmptyValue=false,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=204,
     *          description="Success"
     *     ),
     *     @OA\Response(response=400, description="Invalid supplier id")
     * )
     */
    public function activateSupplier($id): JsonResponse
    {
        $this->supplierService->activateSupplier($id);

        return response()->json([], 204);
    }
}
