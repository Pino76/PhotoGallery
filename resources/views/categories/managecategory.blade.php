@extends('templates.layout')


@section('content')
<div class="row">
    <div class="col-6 push-2">
        <h1>Manage Category</h1>
        @include('categories.categoryform')
    </div>
</div>
@endsection


