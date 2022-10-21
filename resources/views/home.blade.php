@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <example-component :recipes="{{ $recipes }}"></example-component>
    </div>
</div>
@endsection
