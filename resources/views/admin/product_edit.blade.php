@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('add')
    <div class="row">
        <div class="col-lg-6 col-centered center-block" style="float: none;">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h2 class="box-title">Edit Product</h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <div class="box-body">
                        <form role="form" action="/admin/products/update" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('seller') ? ' has-error' : '' }}">
                                        <label for="seller">Seller:</label>
                                        <select id="seller" type="text" style="text-align: center"
                                                class="my_font form-control" tabindex="5"
                                                name="seller" required autocomplete="off">
                                            <option>Choose ...</option>
                                            @foreach($sellers as $seller)
                                                @if(!strcmp($seller,$seller_selected))
                                                    <option selected="selected">{{ $seller }}</option>
                                                @else
                                                    <option>{{ $seller }}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        @if ($errors->has('seller'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('seller') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                        <label for="category">Category:</label>
                                        <select id="category" type="text" style="text-align: center"
                                                class="my_font form-control" tabindex="6"
                                                name="category" required autocomplete="off">
                                            <option>Choose ...</option>
                                            @foreach($categories as $category)
                                                @if(!strcmp($category, $category_selected))
                                                    <option selected="selected">{{ $category }}</option>
                                                @else
                                                    <option>{{ $category }}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        @if ($errors->has('category'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type"
                                                   id="type" value="0" {{ $product->type==0 ? 'checked' : '' }}>
                                            Normal
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type"
                                                   id="type" value="1" {{ $product->type==1 ? 'checked' : '' }}>
                                            Collection
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="type"
                                                   id="type" value="2" {{ $product->type==2 ? 'checked' : '' }}>
                                            Event
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="unique_id" value="{{ $product->unique_id }}">

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="Name">Name :</label>
                                        <input id="name" type="text" style="text-align: center" placeholder="name"
                                               class="my_font form-control"
                                               name="name" tabindex="1" required value="{{ $product->name }}">

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        <label for="description">Description :</label>
                                        <input id="description" type="text" style="text-align: center"
                                               placeholder="description" tabindex="2"
                                               class="my_font form-control"
                                               name="description" required value="{{ $product->description }}">

                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                        <label for="price">Price :</label>
                                        <input id="price" type="number" style="text-align: center"
                                               class="my_font form-control" tabindex="3"
                                               name="price" required value="{{ $product->price }}">

                                        @if ($errors->has('price'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('count') ? ' has-error' : '' }}">
                                        <label for="count">Count :</label>
                                        <input id="count" type="number" style="text-align: center" tabindex="4"
                                               class="my_font form-control" value="1"
                                               name="count" required value="{{ $product->count }}">

                                        @if ($errors->has('count'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('count') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <br>
                            <div class="form-group">
                                <input type="submit" tabindex="7" name="publish"
                                       class="my_font btn center-block btn3d btn-lg btn-warning" value="Submit">
                            </div>
                            <a href="{{ url('admin/products/delete/'.$product->unique_id) }}"
                               tabindex="4" class="btn btn-danger center-block btn-lg">Delete</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection