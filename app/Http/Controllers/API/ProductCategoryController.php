<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('id');
        $show_product = $request->input('show_product');

        // Check wether data is exist
        if ($id) {
            // Relation with 2 tables in Product Model
            $category = ProductCategory::with(['products'])->find($id);

            // If product available
            if ($category) {
                return ResponseFormatter::success(
                    $category,
                    'Data list kategori berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data kategori tidak tersedia',
                    404
                );
            }
        }

        // Get all data
        $category = ProductCategory::query();

        // Filter data
        if ($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_product) {
            $category->with('products');
        }

        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data list kategori berhasil diambil'
        );
    }
}
