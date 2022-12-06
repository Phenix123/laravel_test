@extends('head')

@section('title')
    {{__('Add Client')}}
@endsection

@section('body')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @php
    $i = 0;
    @endphp
    <div class="container-fluid">
        <div class="row clearfix">
            <form method="post" action="{{route('clients.store')}}" id="ClientForm">
                @csrf
                <div class="container-fluid row">
                    <div class="container-sm col-sm-4">
                        <h1 class="d-flex justify-content-center">Create client</h1>
                        <div class="container rounded border border-dark bg-dark">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text" value="{{old('full_name')}}" required name="full_name" id="full_name"
                                       class="form-control" placeholder="">
                                <label for="full_name">Full name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="tel" value="{{old('phone_number')}}" required name="phone_number" id="phone_number"
                                       class="form-control" placeholder="">
                                <label for="phone_num">Phone number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select value="{{old('gender')}}" class="form-select" name="gender" id="gender">
                                    <option value="0" selected>Male</option>
                                    <option value="1">Female</option>
                                </select>
                                <label for="gender">Gender</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="address" id="address" class="form-control" placeholder="">
                                <label for="address">Address (optional)</label>
                            </div>
                        </div>
                    </div>
                    <div class="col vehicles">
                        <h1 class="d-flex justify-content-center">Add Cars</h1>
                        <div class="container tab-logic row mt-3 mb-3 car-form">
                            <div class="col">
                                <div data-name="brand" class="form-floating">
                                    <input type="text" value="{{old('brand')}}" required name="brand" id="brand" class="form-control"
                                           placeholder="">
                                    <label for="brand">Brand</label>
                                </div>
                            </div>
                            <div class="col">
                                <div data-name="model" class="form-floating">
                                    <input type="text" value="{{old('model')}}" required name="model" id="model" class="form-control"
                                           placeholder="">
                                    <label for="model">Model</label>
                                </div>
                            </div>
                            <div class="col">
                                <div data-name="color" class="form-floating">
                                    <input type="text" value="{{old('colour')}}" required name="colour" id="colour" class="form-control"
                                           placeholder="">
                                    <label for="color">Color</label>
                                </div>
                            </div>
                            <div class="col">
                                <div data-name="licence_plate" class="form-floating">
                                    <input type="text" value="{{old('state_number')}}" required name="state_number" id="state_number"
                                           class="form-control" placeholder="">
                                    <label for="licence_plate">Licence plate</label>
                                </div>
                            </div>
                            <div class="col">
                                <div data-name="is_active" class="form-floating">
                                    <select class="form-select"  value="{{old('on_parking')}}" name="on_parking" id="on_parking">
                                        <option value="1">Yes</option>
                                        <option value="0" selected>No</option>
                                    </select>
                                    <label for="is_active">Is parked</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning me-auto ms-3">Send your form</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</@endsection