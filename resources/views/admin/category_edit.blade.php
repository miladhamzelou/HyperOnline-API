@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-4 col-centered center-block" style="float: none;">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h2 class="box-title">Edit Category - Level : {{ $level }}</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <form role="form" action="/admin/categories/update/{{ $level }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="unique_id" value="{{ $category2->unique_id }}">

                            @if($level!="1")
                                <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
                                    <label for="parent">Parent :</label>
                                    <select id="parent" type="text" style="text-align: center"
                                            class="my_font form-control" tabindex="1"
                                            name="parent" required>
                                        <option>Choose ...</option>
                                        @foreach($categories as $category)
                                            @if(!strcmp($category, $category_this))
                                                <option selected="selected">{{ $category }}</option>
                                            @else
                                                <option>{{ $category }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @if ($errors->has('parent'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('parent') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            @endif

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="Name">Name :</label>
                                <input id="name" type="text" style="text-align: center" placeholder="name"
                                       class="my_font form-control"
                                       name="name" tabindex="1" value="{{ $category2->name }}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <hr>
                            <br>
                            <div class="form-group">
                                <input type="submit" tabindex="3" name="publish"
                                       class="my_font btn center-block btn3d btn-lg btn-danger" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection