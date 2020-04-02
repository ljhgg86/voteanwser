<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;


class CategoriesController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$categories = Category::where('delflag',false)->orderBy('id', 'desc')->get();

        if ($categories->count()==0){
            return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false,
                    'categories' => [],
                ],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }


        return response()->json([
            'status' => true,
            'data'=>[
                'successflag' => true,
                'categories' => $categories,
            ],
            'message' => '成功',
        ])->setStatusCode(200);

	}

    public function categories()
    {
        $categories = Category::where('delflag',false)->orderBy('id', 'desc')->get();

        if ($categories->count()==0){
            return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false,
                    'categories' => [],
                ],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }


        return response()->json([
            'status' => true,
            'data'=>[
                'successflag' => true,
                'categories' => CategoryResource::collection($categories),
            ],
            'message' => '成功',
        ])->setStatusCode(200);

    }

    public function show(Category $category)
    {
        if ($category->delflag) {
            return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false
                ],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        return response()->json([
            'status' => true,
            'data'=>[
                'successflag' => true,
                'category' => $category,
            ],
            'message' => '成功',
        ])->setStatusCode(200);
    }


	public function store(CategoryRequest $request)
	{
		$this->authorize();

        $category = Category::create($request->all());

        return response()->json([
            'status' => true,
            'data'=>[
                'successflag' => true,
                'category' => $category,
            ],
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function edit(Category $category)
	{
        $this->authorize();

        if ($category->delflag){
            return response()->json([
                'status' => false,
                'data'=>[
                    'successflag' => false
                ],
                'message' => '访问对象不存在',
            ])->setStatusCode(400);
        }

        return response()->json([
            'status' => true,
            'data'=>[
                'successflag' => true,
                'category' => $category,
            ],
            'message' => '成功',
        ])->setStatusCode(200);
	}

	public function update(CategoryRequest $request, Category $category)
	{
		$this->authorize();

        $category->update($request->all());

        return response()->json([
            'status' => true,
            'data'=>[
                'successflag' => true,
                'category' => $category,
            ],
            'message' => '成功',
        ])->setStatusCode(200);;
	}

	public function destroy(Category $category)
	{
		$this->authorize();

        $category->delflag = true;
        $category->save();

        return response()->json([
            'status' => true,
            'data'=>[
                'successflag' => true

            ],
            'message' => '删除成功',
        ])->setStatusCode(200);
	}
}