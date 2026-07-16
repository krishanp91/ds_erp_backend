<?php

namespace App\Http\Controllers;

use App\Dtos\TaxCategoryTaxDto;
use App\Http\Requests\TaxCategoryTaxRequest;
use App\Services\TaxCategoryTaxService;
use Illuminate\Http\JsonResponse;

class TaxCategoryTaxController extends Controller
{
    private TaxCategoryTaxService $taxCategoryTaxService;

    public function __construct(TaxCategoryTaxService $taxCategoryTaxService)
    {
        $this->taxCategoryTaxService = $taxCategoryTaxService;
    }

    /**
     * @OA\Post(
     *     path="/tax-category-taxes",
     *     summary="Create a tax category tax mapping",
     *     tags={"Tax Category Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaxCategoryTaxRequest")
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaxCategoryTaxResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function createTaxCategoryTax(TaxCategoryTaxRequest $request): JsonResponse
    {
        $taxCategoryTax = TaxCategoryTaxDto::fromRequest($request);
        $taxCategoryTax = $this->taxCategoryTaxService->createTaxCategoryTax($taxCategoryTax);

        return response()->json($taxCategoryTax, 201);
    }

    /**
     * @OA\Get(
     *     path="/tax-category-taxes",
     *     summary="Get list of tax category tax mappings",
     *     tags={"Tax Category Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/TaxCategoryTaxResponse")
     *          )
     *     )
     * )
     */
    public function getAllTaxCategoryTaxes(): JsonResponse
    {
        $taxCategoryTaxes = $this->taxCategoryTaxService->getAllTaxCategoryTaxes();

        return response()->json($taxCategoryTaxes, 200);
    }

    /**
     * @OA\Get(
     *     path="/tax-category-taxes/{id}",
     *     summary="Get tax category tax mapping by id",
     *     tags={"Tax Category Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the tax category tax mapping",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/TaxCategoryTaxResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid id")
     * )
     */
    public function getTaxCategoryTax($id): JsonResponse
    {
        $taxCategoryTax = $this->taxCategoryTaxService->getTaxCategoryTaxById($id);

        return response()->json($taxCategoryTax, 200);
    }

    /**
     * @OA\Put(
     *     path="/tax-category-taxes/{id}",
     *     summary="Update a tax category tax mapping",
     *     tags={"Tax Category Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the tax category tax mapping",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaxCategoryTaxRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaxCategoryTaxResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function updateTaxCategoryTax($id, TaxCategoryTaxRequest $request): JsonResponse
    {
        $taxCategoryTaxDto = TaxCategoryTaxDto::fromRequest($request);
        $taxCategoryTax = $this->taxCategoryTaxService->updateTaxCategoryTax($id, $taxCategoryTaxDto);

        return response()->json($taxCategoryTax, 200);
    }

    /**
     * @OA\Delete(
     *     path="/tax-category-taxes/{id}",
     *     summary="Delete tax category tax mapping",
     *     tags={"Tax Category Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the tax category tax mapping",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(response=204, description="Success"),
     *     @OA\Response(response=400, description="Invalid id")
     * )
     */
    public function deleteTaxCategoryTax($id): JsonResponse
    {
        $this->taxCategoryTaxService->deleteTaxCategoryTax($id);

        return response()->json([], 204);
    }

    /**
     * @OA\Put(
     *     path="/tax-category-taxes/{id}/active",
     *     summary="Activate a deleted tax category tax mapping",
     *     tags={"Tax Category Taxes"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the tax category tax mapping",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(response=204, description="Success"),
     *     @OA\Response(response=400, description="Invalid id")
     * )
     */
    public function activateTaxCategoryTax($id): JsonResponse
    {
        $this->taxCategoryTaxService->activateTaxCategoryTax($id);

        return response()->json([], 204);
    }
}
