<?php namespace App\Http\Controllers;
use DB,Request;
use Mail,Cart;
class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$product = DB::table('products')->select('*')->orderBy('id','desc')->skip(0)->take(5)->get();
		$latest = DB::table('products')->select('*')->orderBy('id','desc')->skip(0)->take(5)->get();
		return view('simpleone.home',compact('product','latest'));
	}
	public function loaisanpham($id){
		if($type==""){
			$product_cate = DB::table('products')->select('*')->where('cate_id',$id)->paginate(9);	
		}elseif($type=="name"){
			$product_cate = DB::table('products')->select('*')->where('cate_id',$id)->orderBy('name','desc')->paginate(9);	
		}elseif($type=="price"){
			$product_cate = DB::table('products')->select('*')->where('cate_id',$id)->orderBy('price','desc')->paginate(9);	
		}
		

		$cate = DB::table('cates')->select('*')->where('id',$id)->first();
		// print_r($cate);
		$menu_cate = DB::table('cates')->select('*')->where('parent_id',$cate->parent_id)->get();
		$latest = DB::table('products')->select('*')->where('cate_id',$id)->orderBy('id','desc')->limit(5)->get();
		return view('simpleone.cate',compact('product_cate','menu_cate','latest'));
	}
	public function chitietsanpham($id){
		$product_detail = DB::table('products')->where('id',$id)->first();
		$image = DB::table('product_images')->select('*')->where('product_id',$id)->get();
		$product_cate = DB::table('products')->select('*')->where('cate_id',$product_detail->cate_id)->Where('id','<>',$id)->limit(4)->get();
		return view('simpleone/product',compact('product_detail','image','product_cate'));
	}
	public function getLienhe(){
		return view('simpleone.contact');
	}
	public function postLienhe(Request $request){
		$data = ['hoten'=>Request::input('name'),'tinnhan'=>Request::input('message')];
		Mail::send('emails.blanks',$data,function($message){
			$message->from('trongtri0705@gmail.com','Nguyen Trong Tri');
			$message->to('ng.trongtri.00@gmail.com','Christ')->subject('This is mail');
		});
		echo "<script>
			alert('Tks');
			window.location = '";
			echo url('/');
			echo "';
		</script>
		";
	}
	public function muahang($id){
		$product_buy = DB::table('products')->where('id',$id)->first();
		Cart::add(array('id'=>$id,'name'=>$product_buy->name,'qty'=>1,'price'=>$product_buy->price,'options'=>array('img'=>$product_buy->image)));
		$content = Cart::content();
		return redirect()->route('giohang');
	}
	public function giohang(){
		$content = Cart::content();
		$total = Cart::total();
		return view('simpleone.shopping',compact('content','total'));
	}
	public function xoasp($id){
		Cart::remove($id);
		return redirect()->route('giohang');
	}
	public function capnhat($id){
		if(Request::ajax()){
			$id = Request::get('id');
			$qty = request::get('qty');
			Cart::update($id,$qty);
			echo "oke";
		}
	}
}
