<?php

namespace App\Http\Controllers;

use App\Dtos\ProductDto;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @OA\Post(
     *     path="/products",
     *     summary="Create a product",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProductRequest")
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ProductResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function createProduct(ProductRequest $request): JsonResponse
    {
        $product = ProductDto::fromRequest($request);
        $product = $this->productService->createProduct($product);

        return response()->json($product, 201);
    }

    /**
     * @OA\Get(
     *     path="/products",
     *     summary="Get list of products",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/ProductResponse"
     *              )
     *          )
     *     )
     * )
     */
    public function getAllProducts(): JsonResponse
    {
        $products = $this->productService->getAllProducts();

        return response()->json($products, 200);
    }

    /**
     * @OA\Get(
     *     path="/products/active",
     *     summary="Get list of active products",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/ProductResponse"
     *              )
     *          )
     *     )
     * )
     */
    public function getActiveProducts(): JsonResponse
    {
        $products = $this->productService->getActiveProducts();

        return response()->json($products, 200);
    }

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     summary="Get product by id",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the product",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         allowEmptyValue=false,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/ProductResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid product id")
     * )
     */
    public function getProduct($id): JsonResponse
    {
        $product = $this->productService->getProductById($id);

        return response()->json($product, 200);
    }

    /**
     * @OA\Put(
     *     path="/products/{id}",
     *     summary="Update a product",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the product",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         allowEmptyValue=false,
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProductRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ProductResponse")
     *     ),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function updateProduct($id, ProductRequest $request): JsonResponse
    {
        $productDto = ProductDto::fromRequest($request);
        $product = $this->productService->updateProduct($id, $productDto);

        return response()->json($product, 200);
    }

    /**
     * @OA\Delete(
     *     path="/products/{id}",
     *     summary="Delete product",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the product",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         allowEmptyValue=false,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=204,
     *          description="Success"
     *     ),
     *     @OA\Response(response=400, description="Invalid product id")
     * )
     */
    public function deleteProduct($id): JsonResponse
    {
        $this->productService->deleteProduct($id);

        return response()->json([], 204);
    }

    /**
     * @OA\Put(
     *     path="/products/{id}/active",
     *     summary="Activate a deleted product",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id of the product",
     *         @OA\Schema(type="integer"),
     *         required=true,
     *         allowEmptyValue=false,
     *         example=1
     *     ),
     *     @OA\Response(
     *          response=204,
     *          description="Success"
     *     ),
     *     @OA\Response(response=400, description="Invalid product id")
     * )
     */
    public function activateProduct($id): JsonResponse
    {
        $this->productService->activateProduct($id);

        return response()->json([], 204);
    }
}
