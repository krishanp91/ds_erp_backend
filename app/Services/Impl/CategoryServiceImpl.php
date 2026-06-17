<?php

namespace App\Services\Impl;

use App\Dtos\CategoryDto;
use App\Exceptions\ErpException;
use App\Models\Category;
use App\Services\CategoryService;
use Cerbero\Dto\Dto;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CategoryServiceImpl implements CategoryService {
    public function createCategory(CategoryDto $categoryDto) : CategoryDto {
        try {
            $category = Category::create([
                'category_name' => $categoryDto->categoryName,
                'description' => $categoryDto->description,
                'parent_id' => $categoryDto->parentId,
                'active' => 'ss'
            ]);

            return CategoryDto::fromModel($category);
        } catch(QueryException $e){
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getAllCategories(): Collection {
        try {
            $categories = Category::with('children')->with('parent')->withTrashed()->get();
            $result = new Collection();
            $categories->map(function($item, $key) use ($result): Dto {
                return $result[] = CategoryDto::fromModel($item);
            });
            return collect($result);
        } catch(QueryException $e){
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getActiveCategories(): Collection {
        try {
            $categories = Category::with('children')->with('parent')->where('active', 1)->get();
            $result = new Collection();
            $categories->map(function($item, $key) use ($result): Dto {
                return $result[] = CategoryDto::fromModel($item);
            });
            return collect($result);
        } catch(QueryException $e){
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getCategoryById(int $id): CategoryDto {
        try {
            $category = Category::withTrashed()->with('children')->with('parent')->where('id', $id)->first();
            if($category == null) {
                throw new ErpException("Category not found.", 400);
            }
            return CategoryDto::fromModel($category);
        } catch(QueryException $e){
            Log::error("SQL exception thrown ".$e);
            throw new ErpException(trans("messages.erp.sql.exception.message"), 500, $e);
        } 
    }

    public function updateCategory(int $id, CategoryDto $categoryDto): CategoryDto {
        try {
            $category = Category::where('id', $id)->withTrashed()->first();
            if ($category == null) {
                throw new ErpException("Category not found.", 400);
            }

            $category->category_name = $categoryDto->categoryName;
            $category->description = $categoryDto->description;
            $category->parent_id = $categoryDto->parentId;
            $category->active = $categoryDto->active;
            $category->update();
            return CategoryDto::fromModel($category);
        } catch(QueryException $e){
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function deleteCategory(int $id): void {
        try{
            $category = Category::withTrashed()->where('id', $id)->first();
            if ($category == null) {
                throw new ErpException("Category not found.", 400);
            }
            $category->delete();
            // $category = Category::onlyTrashed()->where('id', 1)->first();
            // $category->restore();
        } catch(QueryException $e){
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function activateCatgory(int $id): void {
        try{
            $category = Category::onlyTrashed()->where('id', $id)->first();
            $category->restore();
        } catch(QueryException $e){
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}