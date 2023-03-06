<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CategoryProduct extends Controller
{
    public function CheckAuth(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/laravel/php/dashboard');
        }else{
            return Redirect::to('/laravel/php/admin')->send();
        }
    }

    public function add_category_product()
    {
        $this->CheckAuth();
        return view('admin.add_category_product');
    }

    public function all_category_product()
    {
        $this->CheckAuth();
        $all_category_product = DB::table('tbl_category_product')->orderby('category_id','asc')-> get();
        $manager_category_product = view('admin.all_category_product')->with('all_category_product',$all_category_product);
        return view ('admin_layout')->with('admin.all_category_product',$manager_category_product);
    }

    public function save_category_product(Request $request)
    {
        $this->CheckAuth();
        $data = array();
        $data['category_name'] = $request->category_name;
        $data['category_desc'] = $request->category_desc;
        $data['category_status'] = $request->category_status;
        DB::table('tbl_category_product')-> insert($data);
        Session::put('message','Success');
        return Redirect::to('/laravel/php/add-category-product');
    }

    public function active_category_product($category_id)
    {
        $this->CheckAuth();
        DB::table('tbl_category_product')->where('category_id',$category_id)-> update(['category_status'=>0]);

        return Redirect::to('/laravel/php/all-category-product');
    }

    public function inactive_category_product($category_id)
    {
        $this->CheckAuth();
        DB::table('tbl_category_product')->where('category_id',$category_id)-> update(['category_status'=>1]);

        return Redirect::to('/laravel/php/all-category-product');
    }

    public function edit_category_product($category_id)
    {
        $this->CheckAuth();
        $edit_category_product = DB::table('tbl_category_product')-> where('category_id',$category_id)->get();
        $manager_category_product = view('admin.edit_category_product')->with('edit_category_product',$edit_category_product);
        return view ('admin_layout')->with('admin.edit_category_product',$manager_category_product);
    }

    public function update_category_product(Request $request, $category_id)
    {
        $this->CheckAuth();
        $data = array();
        $data['category_name'] = $request->category_name;
        $data['category_desc'] = $request->category_desc;
        DB::table('tbl_category_product')->where('category_id',$category_id)-> update($data);
        return Redirect::to('/laravel/php/all-category-product');
    }

    public function delete_category_product($category_id)
    {
        $this->CheckAuth();
        DB::table('tbl_category_product')->where('category_id',$category_id)-> delete();
        return Redirect::to('/laravel/php/all-category-product');
    }
    
}
