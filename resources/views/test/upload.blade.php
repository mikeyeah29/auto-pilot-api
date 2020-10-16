@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Test Image Upload</h1>

    <form action="{{ route('test.post.upload') }}" method="POST" enctype="multipart/form-data">
        {{ @csrf_field() }}
        <input name="avatar" type="file" />
        <button type="submit">Submit</button>
    </form>

</div>
@endsection
