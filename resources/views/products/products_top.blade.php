
@extends('layouts.app')

@section('content')


    <h1>楽天商品検索サイト</h1>
    {{-- 検索窓のフォーム --}}
    @include('products.searchform')
    
    @if (isset($items))
    <h2>&quot;<?php print htmlspecialchars($keyword, ENT_QUOTES, "UTF-8"); ?>&quot;の検索結果一覧</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>欲しい？</th>
                </tr>
            </thead>
            <tbody>
    
                @foreach ($items as $product)
                <tr>
                    <td><img src='{{$product['mediumImageUrls']}}' ></td>
                    <td>
                        <a href='{{$product['itemUrl']}}' > 
                            {{$product['itemName']}}
                        </a>
                    </td>
                    <td>{{$product['itemPrice']}}</td>
                    <td>欲しいボタン</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection