<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Goods;
use App\Models\Categories;
use DB;
use Validator;
use App\Http\Requests\StoreGoodsItem;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{
   public function index(Request $request)
    {
		
		$goods = Goods::leftJoin('categories','goods.category_id', '=', 'categories.id')
        ->select('goods.*' ,'categories.name as category_name')
        ->orderBy('goods.id', 'DESC')
        ->paginate(5);
		
       return $goods;
       //return response()->json($response);
		
    }

    public function add(Request $request)
    {
		/*
        $Post = new Post([
            'name' => $request->input('title'),
            'brief' => $request->input('brief')
        ]);*/
        
         $post = new Post;
			$post->company_id = 1;
            $post->title = $request->title;
            $post->brief = $request->brief;
            $post->updated_at = 5555555;
            $post->catalog_id =  1;
            $post->content =  'content';
            $post->tags = 'test';
            $post->slug = 'slug1';
           $post->gallery_id = 1;
           $post->order_sort = 0;
            $post->parent_post_id =  0;
            $post->catalog_slug = '';
        $post->save();
        
      /*
       $Post = new Post([
			'company_id' => 1,
            'title' => '7777',
            'brief' => '77777',
            'updated_at' => 5555555,
            'catalog_id' => 1,
            'content' => 'content',
            'tags' => 'test',
            'slug' => 'slug1',
            'gallery_id' => 1,
            'order_sort' => 0,
            'parent_post_id' => 0,
            'catalog_slug' => ''
        ]);
        $Post->save();
			*/
			if(!isset($request)){
				$text = 'net';
			}else{
				$text = 'da';
			}
			//$text1 = $request->all();
        return response()->json('test:'.$request->title);
    }
	public function getCategories()
    {
        $data = Categories::get();
        return response()->json($data);
    }
    public function show($id)
    {
		
        $Post = Goods::find($id);
        return response()->json($Post);
    }

    public function update($id, StoreGoodsItem $request)
    {
		
		//$validation_goods = new Goods();
       // $goods = Goods::find($id);
		//$validation = Validator::make($request->all(), 
			//[
			//$validation_goods->rules
           // 'name' => 'required|string|max:255|min:2',
           // 'category_id' => ['required|not_in:0']
           // ]
           // );
		/*if( $validation->fails() ) {
			$errors = $validation->messages()->toJson();
			return response()->json([ "errors" => $errors ]);
		}*/
       //$Post->update($request->all());
	/*	$goods->name = $request->name;
		$goods->description = $request->description;
		$goods->price = $request->price;
		$goods->category_id = $request->category_id;
		$goods->save();
        return response()->json('test:'.$goods->name);*/
        //return response()->json('test:');
    }

    public function destroy($id)
    {
        $Post = Post::find($id);
        $Post->delete();

        return response()->json('Post deleted!');
    }
}
