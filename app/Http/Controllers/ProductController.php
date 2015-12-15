<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\Cate;
use Auth;
use Input;
use File;
use App\ProductImage;
use App\Http\Requests\ProductRequest;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
            $product_detail = Product::find($id)->pimages->toArray();
            foreach ($product_detail as $key ) {
                # code...
                File::delete('resources/upload/detail/'.$key['image']);
            }
            $Product = Product::find($id);
            File::delete('resources/upload/images/'.$Product->image);
            $Product->delete($id);
            return redirect()->route('admin.product.list')->with('success','successfully deleted');
        
    }
    public function getDelimg($id){
        if(Request::ajax()){
            $idHinh = (int)Request::get('idHinh');
            $imgdel = ProductImage::find($idHinh);
            if(!empty($imgdel)){
                $img= 'resources/upload/detail/'.$imgdel->image;
                if(File::exists($img)){
                    File::delete($img);
                }
                $imgdel->delete();
            }
            return "Oke";
        }
    }
    public function getAdd(){ 
        $parent = Cate::select('*')->get()->toArray();
        // $cate = Product::find($id);
        return view('admin.product.add',compact('parent'));
    }
    public function postAdd(ProductRequest $request){
        $product = new Product();
        $product->cate_id = $request->sltParent;
        $product->name = $request->txtName;
        $product->alias = changeTitle($request->txtAlias);       
        if($product->alias==""){$product->alias=changeTitle(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $product->name));}
         $product->price = $request->txtPrice;
        $product->intro = $request->txtIntro;
        $product->order = $request->txtOrder;
        $file = $request->file('fImages')->getClientOriginalName();
        $product->image = $file;
        $request->file('fImages')->move('resources/upload/images/',$file);
        // $product->parent_id = $request->txtParent;
        $product->content = htmlentities($request->txtContent);
        $product->keywords = $request->txtKeywords;
        $product->description = $request->txtDescription;
        $product->user_id = Auth::user()->id;
        $product->save();
        $product_id = $product->id;
        if(Input::hasFile('fProductDetail')){
            foreach (Input::file('fProductDetail') as $file) {
                # code...
                $product_img = new ProductImage();
                if(isset($file)){
                    $product_img->image = $file->getClientOriginalName();
                    $product_img->product_id = $product_id;
                    $file->move('resources/upload/detail/',$file->getClientOriginalName());
                    $product_img->save();
                }
            }
        }
        return redirect()->route('admin.product.list')->with('success','Posted completely!');;
    }
     public function getEdit($id)
    {
        //
        $product = Product::findOrFail($id)->toArray();
        $cate = Cate::select('*')->get()->toArray();
        $product_img = Product::find($id)->pImages;
        return view('admin.product.edit',compact('cate','product','id','product_img'));
    }
    public function postEdit(Request $request, $id){
        
        $product=Product::find($id);
        // $product->cate_id = $request->sltParent;
        $product->name = Request::input('txtName');
        $product->alias = changeTitle(Request::input('txtAlias'));
        if($product->alias==""){$product->alias=changeTitle(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $product->name));}
        $product->order = Request::input('txtOrder');
        // $cate->parent_id = $request->txtParent;
        $product->cate_id = Request::input('sltParent');
        $product->keywords = Request::input('txtKeywords');
        $product->description = Request::input('txtDescription');
        $product->content = Request::input('txtContent');
        $product->user_id = 1;
        
        $img_cur = 'resource/upload/images/'.Request::input('img_cur');
        if(Request::file('fImages')){
            $file_name = Request::file('fImages')->getClientOriginalName();
            $product->image = $file_name;
            Request::file('fImages')->move('resources/upload/images/',$file_name);
            if(File::exists($img_cur)){
                File::delete($img_cur);
            }
        }else{
            echo "no file";
        } 
        $product->save();
        if(!empty(Request::file('fEditDetail'))){
            foreach (Request::file('fEditDetail') as $file) {
        # code...
                $product_img = new ProductImage();
                if(isset($file)){
                    $product_img->image = $file->getClientOriginalName();
                    $product_img->product_id = $id;
                    $file->move('resources/upload/detail/',$file->getClientOriginalName());
                }
                $product_img->save();
            }
           
        }
        return redirect()->route('admin.product.list')->with('success','Edited completely!');
    }
    public function getList(){
        $data = Product::select('*')->orderBy('id','desc')->get()->toArray();
        return view('admin.product.list',compact('data'));
    }
}
