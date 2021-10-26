<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Exports\ExcelExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\StaffLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CategoriesController extends Controller
{
    function getAll(Request $request){
        $categories = Category::withCount('adverts')->get();

        return $this->view('admin.categories.list', [
            'categories' => $categories
        ]);
    }

    function export(){
        $filename = 'categories_'.str_replace('-', '_', Carbon::now()->format('Y-m-d')).'.csv';

        return Excel::download(new ExcelExport(Category::query()->withCount('adverts')->orderBy('name', 'asc'), Category::exportHeaders()), $filename);
    }

    function add(Request $request){
        $validator = validator()->make($request->post(), [
            'name' => ['required'],
            // 'slug' => ['unique:categories,slug'],
        ],[
            'name.required' => 'Provide a category name',
            'slug.unique' => 'The category '.$request->post('name').' already exists'
        ]);

        if($validator->fails()){
            return $request->expectsJson() ?
                $this->json->error($validator->errors()->first()) :
                back()->withInput()->withErrors(['status' => $validator->errors()->first()]);
        }


        $slug = \Illuminate\Support\Str::slug($request->post('name'));

        // Check if there is a soft deleted category and restore it
        $category = Category::where('slug', $slug)->withTrashed()->first();

        if($category != null){
            if($category->trashed()){
                if($category->restore()){
                    return back()->withInput()->with(['status' => "Category ".$category->name." has been restored"]);
                }else{
                    return back()->withInput()->withErrors(['status' => 'Something went unexpectedly wrong']);
                }
            }

            return $request->expectsJson() ?
                $this->json->success("The category ".$category->name." already exists") :
                back()->withInput()->withErrors(['status' => "The category ".$category->name." already exists"]);
        }

        $category = new Category([
                'name' => $request->post('name'),
                'slug' => $slug,
            ]);

        DB::beginTransaction();
        try{
            $category->save();

            DB::commit();

            return $request->expectsJson() ?
                $this->json->success("New category ".$category->name." has been saved") :
                back()->withInput()->with(['status' => "New category ".$category->name." has been saved"]);

        }catch(Exception $e){
            DB::rollback();
            return $request->expectsJson() ?
                $this->json->error('Something went unexpectedly wrong') :
                back()->withInput()->withErrors(['status' => 'Something went unexpectedly wrong']);
        }
    }

    function delete(Request $request, $id){
        $category = Category::whereId($id)->first();

        if($category == null){
            return $request->expectsJson() ?
                $this->json->error('Category was not found in database') :
                back()->withInput()->withErrors(['status' => 'Category was not found in database']);
        }

        DB::beginTransaction();

        if($category->delete()){
            DB::commit();
            return $request->expectsJson() ?
                $this->json->success($category->name.' has been deleted from categories') :
                back()->withInput()->with(['status' => $category->name.' has been deleted from categories']);
        }

        DB::rollback();

        return $request->expectsJson() ?
            $this->json->error('Unable to delete category, something went wrong. Please retry') :
            response()->back()->withInput()->withErrors(['status' => 'Unable to delete category, something went wrong. Please retry']);
    }

}
