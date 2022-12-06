@extends('head')

@section('title')
    {{__('All Clients')}}
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
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">ФИО</th>
                <th scope="col">Авто</th>
                <th scope="col">Номер</th>
                <th scope="col" style="white-space: nowrap; width: 1px">Редактировать</th>
                <th scope="col" style="white-space: nowrap; width: 1px">Удалить</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($clients as $client)
                <tr>

                    <td>{{ $client->full_name }}</td>
                    <td>{{ $client->brand }}  {{$client->model}}</td>
                    <td>{{ $client->state_number}}</td>
                    <td>
                        <a href=" {{route('clients.update', $client->id)}}" class="btn btn-primary">Edit</a>
                    </td>
                    <td>

                        <form action="{{route('cars.delete', $client->cars_id)}}" method="post">
                            @csrf
                            <input class="btn btn-danger" type="submit" value="Delete"/>
                            @method('delete')
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $clients->links() }}
        </div>
    </div>


@endsection