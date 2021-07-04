{!! Form::open(['route' => 'products.search']) !!}
    <div class="form-group">
        <label for="keyword">検索キーワード：</label>
        {!! Form::text('keyword', NULL, ['class' => 'form-control']) !!}
        {!! Form::submit('検索', ['class' => 'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}