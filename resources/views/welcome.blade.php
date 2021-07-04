@extends('layouts.app')

@section('content')
    @if (Auth::check())
        {{ Auth::user()->name }}
        <div class="row">
            <h1>楽天商品検索サイト</h1>
            <div class="col-sm-8">
            {{-- 検索トップ --}}
            @include('products.products_top')
            </div>
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>楽天商品検索サイト</h1>
                {{-- ユーザ登録ページへのリンク --}}
                {!! link_to_route('signup.get', '今すぐユーザー新規登録!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection