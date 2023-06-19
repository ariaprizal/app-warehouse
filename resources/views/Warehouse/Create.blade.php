@extends('Layouts.Sidebar')

@section('main')

<div class="container">
    <div class="row">
        <div>
            <h1 class="subheading mt-4 text-center">Purchasing Form</h1>
            <hr style="width: 100%">

            <form name="booking" class="w-100" data-animate-in="animateUp" onsubmit="{{route('submit-product')}}">
                <div class="row my-3 ">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="first_name">Surat Jalan</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                <input type="text" name="np_sj" class="form-control" id="no_sj" placeholder="Surat Jalan">
                            </div>
                            <span id="f_name" class="helpblock" style="display:none">rewwwwwww</span>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="good_stock">Good Stock</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-home"></i>
                                </span>
                                <input type="text" name="good_stock" class="form-control" id="good_stock" placeholder="Good stock">
                            </div>
                            <span id="zi_p_code" class="helpblock"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="bad_stock">Bad Stock</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-home"></i>
                                </span>
                                <input type="text" name="bad_stock" class="form-control" id="bad_stock" placeholder="Bad stock">
                            </div>
                            <span id="zi_p_code" class="helpblock"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary float-end w-25 my-3"><span class="glyphicon glyphicon-send"></span> Save</button>
                </div>
                <hr style="width: 100%">
            </form>
        </div>
    </div>
</div>

@endsection