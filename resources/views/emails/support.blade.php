@extends('beautymail::templates.widgets')

@section('content')
    @include('beautymail::templates.widgets.articleStart')

    <h4 class="secondary" style="text-align: center; direction: rtl;"><strong>{{ $title }}</strong></h4>
    <p style="text-align: justify; direction: rtl;">{{ $body }}</p>

    @include('beautymail::templates.widgets.articleEnd')
@stop