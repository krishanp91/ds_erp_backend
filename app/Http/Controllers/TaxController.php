<?php

namespace App\Http\Controllers;

use App\Dtos\TaxDto;
use App\Http\Requests\TaxRequest;
use App\Services\TaxService;
use Illuminate\Http\JsonResponse;

class TaxController extends Controller
{
    private TaxService $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    /**
     * @OA\Post(
     *     path="/taxes",
     *     summary="Create a tax",
     *     tags={"Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaxRequest")
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaxResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function createTax(TaxRequest $request): JsonResponse
    {
        $tax = TaxDto::fromRequest($request);
        $tax = $this->taxService->createTax($tax);

        return response()->json($tax, 201);
    }

    /**
     * @OA\Get(
     *     path="/taxes",
     *     summary="Get list of taxes",
     *     tags={"Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/TaxResponse")
     *          )
     *     )
     * )
     */
    public function getAllTaxes(): JsonResponse
    {
        $taxes = $this->taxService->getAllTaxes();

        return response()->json($taxes, 200);
    }

    /**
     * @OA\Get(
     *     path="/taxes/active",
     *     summary="Get list of active taxes",
     *     tags={"Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/TaxResponse")
     *          )
     *     )
     * )
     */
    public function getActiveTaxes(): JsonResponse
    {
        $taxes = $this->taxService->getActiveTaxes();

        return response()->json($taxes, 200);
    }

    /**
     * @OA\Get(
     *     path="/taxes/{id}",
     *     summary="Get tax by id",
     *     tags={"Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the tax",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/TaxResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid tax id")
     * )
     */
    public function getTax($id): JsonResponse
    {
        $tax = $this->taxService->getTaxById($id);

        return response()->json($tax, 200);
    }

    /**
     * @OA\Put(
     *     path="/taxes/{id}",
     *     summary="Update a tax",
     *     tags={"Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the tax",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaxRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaxResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function updateTax($id, TaxRequest $request): JsonResponse
    {
        $taxDto = TaxDto::fromRequest($request);
        $tax = $this->taxService->updateTax($id, $taxDto);

        return response()->json($tax, 200);
    }

    /**
     * @OA\Delete(
     *     path="/taxes/{id}",
     *     summary="Delete tax",
     *     tags={"Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the tax",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(response=204, description="Success"),
     *     @OA\Response(response=400, description="Invalid tax id")
     * )
     */
    public function deleteTax($id): JsonResponse
    {
        $this->taxService->deleteTax($id);

        return response()->json([], 204);
    }

    /**
     * @OA\Put(
     *     path="/taxes/{id}/active",
     *     summary="Activate a deleted tax",
     *     tags={"Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the tax",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(response=204, description="Success"),
     *     @OA\Response(response=400, description="Invalid tax id")
     * )
     */
    public function activateTax($id): JsonResponse
    {
        $this->taxService->activateTax($id);

        return response()->json([], 204);
    }
}
