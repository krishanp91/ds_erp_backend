<?php

namespace App\Http\Controllers;

use App\Dtos\TaxCategoryDto;
use App\Http\Requests\TaxCategoryRequest;
use App\Services\TaxCategoryService;
use Illuminate\Http\JsonResponse;

class TaxCategoryController extends Controller
{
    private TaxCategoryService $taxCategoryService;

    public function __construct(TaxCategoryService $taxCategoryService)
    {
        $this->taxCategoryService = $taxCategoryService;
    }

    /**
     * @OA\Post(
     *     path="/tax-categories",
     *     summary="Create a tax category",
     *     tags={"Tax Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaxCategoryRequest")
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaxCategoryResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function createTaxCategory(TaxCategoryRequest $request): JsonResponse
    {
        $taxCategory = TaxCategoryDto::fromRequest($request);
        $taxCategory = $this->taxCategoryService->createTaxCategory($taxCategory);

        return response()->json($taxCategory, 201);
    }

    /**
     * @OA\Get(
     *     path="/tax-categories",
     *     summary="Get list of tax categories",
     *     tags={"Tax Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/TaxCategoryResponse")
     *          )
     *     )
     * )
     */
    public function getAllTaxCategories(): JsonResponse
    {
        $taxCategories = $this->taxCategoryService->getAllTaxCategories();

        return response()->json($taxCategories, 200);
    }

    /**
     * @OA\Get(
     *     path="/tax-categories/active",
     *     summary="Get list of active tax categories",
     *     tags={"Tax Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/TaxCategoryResponse")
     *          )
     *     )
     * )
     */
    public function getActiveTaxCategories(): JsonResponse
    {
        $taxCategories = $this->taxCategoryService->getActiveTaxCategories();

        return response()->json($taxCategories, 200);
    }

    /**
     * @OA\Get(
     *     path="/tax-categories/{id}",
     *     summary="Get tax category by id",
     *     tags={"Tax Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the tax category",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/TaxCategoryResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid tax category id")
     * )
     */
    public function getTaxCategory($id): JsonResponse
    {
        $taxCategory = $this->taxCategoryService->getTaxCategoryById($id);

        return response()->json($taxCategory, 200);
    }

    /**
     * @OA\Put(
     *     path="/tax-categories/{id}",
     *     summary="Update a tax category",
     *     tags={"Tax Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the tax category",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaxCategoryRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaxCategoryResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function updateTaxCategory($id, TaxCategoryRequest $request): JsonResponse
    {
        $taxCategoryDto = TaxCategoryDto::fromRequest($request);
        $taxCategory = $this->taxCategoryService->updateTaxCategory($id, $taxCategoryDto);

        return response()->json($taxCategory, 200);
    }

    /**
     * @OA\Delete(
     *     path="/tax-categories/{id}",
     *     summary="Delete tax category",
     *     tags={"Tax Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the tax category",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(response=204, description="Success"),
     *     @OA\Response(response=400, description="Invalid tax category id")
     * )
     */
    public function deleteTaxCategory($id): JsonResponse
    {
        $this->taxCategoryService->deleteTaxCategory($id);

        return response()->json([], 204);
    }

    /**
     * @OA\Put(
     *     path="/tax-categories/{id}/active",
     *     summary="Activate a deleted tax category",
     *     tags={"Tax Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the tax category",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         example=1
     *     ),
     *     @OA\Response(response=204, description="Success"),
     *     @OA\Response(response=400, description="Invalid tax category id")
     * )
     */
    public function activateTaxCategory($id): JsonResponse
    {
        $this->taxCategoryService->activateTaxCategory($id);

        return response()->json([], 204);
    }
}
