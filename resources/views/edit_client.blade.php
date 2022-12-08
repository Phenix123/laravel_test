@extends('head')

@section('title')
    {{__('Edit Client')}}
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
    <div class="container">

        <form method="post" action="{{route('clients.update', $cur_client->id)}}" >
        @csrf
        @method('patch')
            <label for="full_name">Full name</label>
            <input type="text"
                   value="{{$cur_client->full_name}}"
                   required name="full_name"
                   id="full_name"
                   class="form-control" placeholder="">
           <label for="gender">Gender</label>
            <select class="form-select" name="gender" id="gender">
                <option value="0" {{$cur_client->gender ? '' : 'selected'}}>Male</option>
                <option value="1" {{$cur_client->gender ? 'selected' : ''}}>Female</option>
            </select>
           <label for="phone_number">Phone number</label>
            <input type="tel"
                   value="{{$cur_client->phone_number}}"
                   required name="phone_number"
                   id="phone_number"
                   class="form-control" placeholder="">
           <label for="address">Address</label>
            <input type="text"
                   value="{{$cur_client->address}}"
                   id="address" name="address"
                   class="form-control" placeholder="">

            <button type="submit" class="btn btn-warning me-auto mt-3">Edit</button>
        </form>

        <form action="{{route('clients.delete', $cur_client->id)}}" method="post">
            @csrf
            @method('delete')
            <input class="btn btn-danger mt-1" type="submit" value="Delete Client"/>
        </form>

        <form method="post" action="{{route('cars.store')}}" class="mt-3 p-1" style="border: 3px solid black; border-radius: 3px;" >
            @csrf
            @method('post')
            <input type = "hidden" value="{{$cur_client->id}}" name="client_id" id="client_id">
            <label for="brand">Brand</label>
            <input type="text"
                   value="{{old('brand')}}"
                   id="brand" name="brand"
                   class="form-control" placeholder="">

            <label for="model">Model</label>
            <input type="text"
                   value="{{old('model')}}"
                   id="model" name="model"
                   class="form-control" placeholder="">

            <label for="colour">Colour</label>
            <input type="text"
                   value="{{old('colour')}}"
                   id="colour" name="colour"
                   class="form-control" placeholder="">

            <label for="state_number">State Number</label>
            <input type="text"
                   value="{{old('state_number')}}"
                   id="state_number" name="state_number"
                   class="form-control" placeholder="">

            <label for="on_parking">Location</label>
            <select value="{{old('on_parking')}}" class="form-select" name="on_parking" id="on_parking">
                <option value="0" selected>Not on parking</option>
                <option value="1" >On parking</option>
            </select>
            <button type="submit" class="btn btn-warning me-auto mt-3 mb-2">Add Car</button>
        </form>

        @foreach($cars as $car)
        <form method="post" action="{{route('cars.update', $car->id)}}" class="mt-3 p-1" style="border: 3px solid black; border-radius: 3px;" >
            @csrf
            @method('patch')
            <label for="brand">Brand</label>
            <input type="text"
                   value="{{$car->brand}}"
                   id="address" name="brand"
                   class="form-control" placeholder="">

            <label for="model">Model</label>
            <input type="text"
                   value="{{$car->model}}"
                   id="address" name="model"
                   class="form-control" placeholder="">

            <label for="colour">Colour</label>
            <input type="text"
                   value="{{$car->colour}}"
                   id="address" name="colour"
                   class="form-control" placeholder="">

            <label for="state_number">State Number</label>
            <input type="text"
                   value="{{$car->state_number}}"
                   id="address" name="state_number"
                   class="form-control" placeholder="">

            <label for="on_parking">Location</label>
            <select class="form-select" name="on_parking" id="on_parking">
                <option value="0" {{$car->on_parking ? '' : 'selected'}}>Not on parking</option>
                <option value="1" {{$car->on_parking ? 'selected' : ''}}>On parking</option>
            </select>
            <button type="submit" class="btn btn-warning me-auto mt-3 mb-2">Edit Car</button>
        </form>
        @endforeach

    </div>
    <script>

        //Код jQuery, установливающий маску для ввода телефона элементу input
        //1. После загрузки страницы,  когда все элементы будут доступны выполнить...
        $(document).ready(function () {
            $("#phone_number").inputmask("9(999)999-99-99");
        });
    </script>
@endsection