<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $data = [];
        $response = '';
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();

            $products = Product::paginate(10);

            $data = [
                'user' => $user,
                'products' => $products,
//                'response' => $response,
            ];
            //products_topビューでそれらを表示
            return view('products.products_top', $data);
        }

        //welcomeビューでそれらを表示
        return view('welcome', $data);
    }
    
    public function search(Request $request)
    {
        
        // 検索する！のボタンが押された場合の処理
        if (isset( $request->keyword)) {
            $keyword = $request['keyword'];
            $response_json = $this->execute_api($keyword);
            $response = json_decode($response_json);  // JSONデータをオブジェクトにする
           // dd($response);
        
            if ($response) {
                $items = array();
                foreach ($response->Items as $item){
                    // dd($item->Item->mediumImageUrls);
                    $items[] = array(
                        
                        'mediumImageUrls' => $item->Item->mediumImageUrls[0]->imageUrl,
                        'itemName' =>  $item->Item->itemName,
                        'itemUrl' =>  $item->Item->itemUrl,
                        'itemPrice' => $item->Item->itemPrice,
                        );
                }
            }
      //dd($items);          
            //products_topビューでそれらを表示
            return view('products.products_top', ['items' => $items,'keyword' => $request['keyword']]);
            
        }
    }
    
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
        ]);

        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->products()->create([
            
            'imageUrl' => $request-mediumImageUrls,
            'productUrl' => $request->itemUrl,
            'productname' => $request->itemName,
            'productprice' => $request->itemPrice,
            
        ]);
        
        // メッセージを作成
        // $want_product = new Message;
        // $message->title = $request->title;    // 追加
        // $message->content = $request->content;
        // $message->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
