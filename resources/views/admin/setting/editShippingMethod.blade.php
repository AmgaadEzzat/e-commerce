@extends('layouts.admin')
@section('content')
    <form class="form" action="{{route('update-shipping-method',$shippingMethod -> id)}}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$shippingMethod -> id}}">
        <div class="form-group">
            <label> لوجو التجار </label>
            <label id="projectinput7" class="file center-block">
                <input type="file" id="file" name="logo">
                <span class="file-custom"></span>
            </label>
            @error('logo')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-body">
            <h4 class="form-section"><i class="ft-home"></i> بيانات المتجر </h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="projectinput1"> الاسم </label>
                        <input type="text" value="{{$vendor -> name}}" id="name"
                               class="form-control"
                               placeholder="  "
                               name="name">
                        @error("name")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div id="map" style="height: 500px;width: 1000px;"></div>

        <div class="form-actions">
            <button type="button" class="btn btn-warning mr-1"
                    onclick="history.back();">
                <i class="ft-x"></i> تراجع
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="la la-check-square-o"></i> حفظ
            </button>
        </div>
    </form>
@endsection
