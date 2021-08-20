<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
		$list = Product::orderBy('id','desc')->paginate(15);
		return view('product.index',['details' => $list]);
	}
	
	public function addProduct(){
		return view('product.addProduct');
	}
	
	public function storeProduct(Request $req){
		$req->validate([
            'title' => 'required',
            'price' => 'required',
			'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
		$input = $req->all();
		if($req->file('image')){
			$imageName = time().'.'.$req->image->extension();
			$req->image->move(public_path('images'), $imageName);
			$input['image'] = $imageName;
		}
		$addProduct = Product::create($input);
		return redirect('/')->with('success','product added successfully');
	}
	
	public function editProduct($id){
		$list = Product::where('id', $id)->first();
		return view('product/updateProduct',['details' => $list]);
	}
	
	public function updatProduct(Request $req,Product $id){
		$req->validate([
			'title' => 'required',
			'price' => 'required'
		]);
		$updateInfo = $req->all();
		if($req->file('image')){
			$imageName = time().'.'.$req->image->extension();
			$req->file('image')->move(public_path('images'),$imageName);
			$updateInfo['image'] = $imageName;
		}
		$id->update($updateInfo);
		return redirect('/')->with('success','Product updated successfully');
	}
	
	public function deleteProduct(Product $id){
		$id->delete();
		return redirect('/')->with('success','Product deleted successfully');
	}
}
