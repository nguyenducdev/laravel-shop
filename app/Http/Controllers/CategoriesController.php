<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\Repository;
use App\Repositories\Eloquent\CategoryRepository as Category;
use App\Http\Requests\AddCategoriesRequest;
use App\Http\Requests\EditCategoriesRequest;
use File;

class CategoriesController extends Controller
{
    private $category;
    
    public function __construct(Category $category) {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = $this->category->all();

        return view("admin.categories.index", [
            'category'      => $category,
            'page_title'    => 'Category'
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = $this->category->all(['id','title']);
        return view("partials.admin.categories.popup_add_categories", [
            'page_title'    => 'Category',
            'category'      => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCategoriesRequest $request)
    {
        $result = [
            'error'     => 0,
            'message'   => '',
        ];

        if(!isset($request->status)) {
            $status = 0;
        } else {
            $status = $request->status;
        }

        $category = $this->category->create([
            'parent_id'     => $request->parent_id,
            'title'         => $request->title,
            'description'   => $request->description,
            'status'        => $status
        ]);

        $destinationPath = 'media/categories/img/';
        $extension       = $request['image']->getClientOriginalExtension();
        $fileName        = $category->id . '_Categories.' . $extension;

        $url_save = $destinationPath . $fileName;

        $category->update([
            'image' => $url_save,
        ]);

        if (!File::exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $request['image']->move($destinationPath, $fileName);

        if (!isset($category->id)) {
            $result['error']    = 1;
            $result['message']  = 'Add Categories false.';
        }

        $result['message'] = 'Add Categories successfully.';
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $list_category = $this->category->all(['id', 'title']);
        $category = $this->category->find($id);
        return view("partials.admin.categories.popup_edit_categories", [
            'category' => $category,
            'list_category' => $list_category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCategoriesRequest $request, $id)
    {

        $result = [
            'error' => 0,
            'message' => '',
        ];

        if(!isset($request->status)) {
            $status = 0;
        } else {
            $status = $request->status;
        }

        $category = $this->category->find($id);
        $category->update([
            'parent_id'     => $request->parent_id,
            'title'         => $request->title,
            'description'   => $request->description,
            'status'        => $status
        ]);

        if (isset($request->image)) {

            $destinationPath = 'media/categories/img/';
            $extension       = $request['image']->getClientOriginalExtension();
            $fileName        = $category->id . '_Categories.' . $extension;

            $url_save = $destinationPath . $fileName;

            $category->update([
                'image' => $url_save,
            ]);

            if (!File::exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            // File::delete( $destinationPath . $request['url_image']);
            $request['image']->move($destinationPath, $fileName);
        }

        $result['message'] = 'Add Categories successfully.';
        return response()->json($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);
        File::delete("media/categories/img/10_Categories.png");
        $category->delete();

        return redirect('/admin/category')->with('status', 'Category delete successfully!');
    }
}
