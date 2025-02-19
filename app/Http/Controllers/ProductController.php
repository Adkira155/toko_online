<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $product = Product::paginate(10);

        return view('index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create-product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                // => 
                // => 
                // => 
                // => 
                // => 
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $product = new Product();

            //fungsi image
            $file = $request->file('///');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('products'), $fileName);
            $product->/// = $fileName;

            $product->create(array_merge(
                $validator->validated(),
                ['///' => $fileName]
            ));
    
            return redirect()->route('////')->with(['success' => 'Data Berhasil Disimpan!']);
        }
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        //get product by ID
        $product = Product::findOrFail($id);
    
        //render view with product
        return view('show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id){

        $product = Product::findOrFail($id);
    
        //delete image
        Storage::delete('public/products'. $product->image);
    
        //delete product
        $product->delete();
    
        //redirect to index
        return redirect()->route('///')->with('success', 'Data berhasil dihapus');
    }
    
    }
    
