<?php

namespace App\Http\Controllers;

use App\Dtos\CategoryDto;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    /**
     * @OA\Post(
     *     path="/categories",
     *     summary="Create a category",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *     ),
     *     @OA\Response(
     *          response=200, 
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function createCategory(CategoryRequest $request): JsonResponse {
        $category = CategoryDto::fromRequest($request);
        $category = $this->categoryService->createCategory($category);
        return response()->json($category, 201);
    }

    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="Get list of categories",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="active",
     *         in="query",
     *         description="Filter categories by active state. When true, only active (active=1) categories are returned; when false, only inactive (active=0) categories are returned. When omitted or empty, all categories are returned.",
     *         required=false,
     *         allowEmptyValue=true,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *          response=200, 
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/CategoryResponse"
     *              )
     *          )
     *     )
     * )
     */
    public function getAllCategories(Request $request): JsonResponse {
        $categories = $this->categoryService->getAllCategories($request->query('active'));
        return response()->json($categories, 200);
    }

    /**
     * @OA\Get(
     *     path="/categories/active",
     *     summary="Get list of categories",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200, 
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/CategoryResponse"
     *              )
     *          )
     *     )
     * )
     */
    public function getActiveCategories() {
        $categories = $this->categoryService->getActiveCategories();
        return response()->json($categories, 200);
    }

    /**
     * @OA\Get(
     *     path="/categories/{id}",
     *     summary="Get category by it's id",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the category",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         allowEmptyValue=false,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=200, 
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid category id")
     * )
     */
    public function getCategory($id) {
        $category = $this->categoryService->getCategoryById($id);
        return response()->json($category, status: 200);
    }

    /**
     * @OA\Put(
     *     path="/categories/{id}",
     *     summary="Update a category",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the category",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         allowEmptyValue=false,
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *     ),
     *     @OA\Response(
     *          response=200, 
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function updateCategory($id, CategoryRequest $request) {
        $categoryDto = CategoryDto::fromRequest($request);
        $category = $this->categoryService->updateCategory($id, $categoryDto);
        return response()->json($category, 200);
    }

    /**
     * @OA\Delete(
     *     path="/categories/{id}",
     *     summary="Delete category",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the category",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         allowEmptyValue=false,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=201, 
     *          description="Success"
     *     ),
     *     @OA\Response(response=400, description="Invalid category id")
     * )
     */
    public function deleteCategory($id) {
        $this->categoryService->deleteCategory($id);
        return response()->json([], 204);
    }

    /**
     * @OA\Put(
     *     path="/categories/{id}/active",
     *     summary="Activate a deleted category",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the category",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         allowEmptyValue=false,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=201, 
     *          description="Success"
     *     ),
     *     @OA\Response(response=400, description="Invalid category id")
     * )
     */
    public function activateCategory($id) {
        $this->categoryService->activateCatgory($id);
        return response()->json([], 204);
    }
}
