@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Tests</h1>

    <p>these are features / functions / routes I wanted to make a prototype of before including in to the project. They can be used for future reference for how a particular thing works</p>

    <ul>
    	<li>
    		<a href="{{ route('test.get.upload') }}">Image Upload</a>
    	</li>
    </ul>

</div>
@endsection
