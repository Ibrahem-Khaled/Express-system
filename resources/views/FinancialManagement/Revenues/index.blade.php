
@extends('layouts.default')

@section('content')


    <div class="container mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">كشف الشهري</th>
                    <th scope="col">اجمالي عدد الحاويات</th>
                    <th scope="col">كشف السنوي</th>
                    <th scope="col">اجمالي المطلوب من المكتب</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td><a href="{{ route('getAccountStatement', $user->id) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->container->whereIn('status', ['transport','done'])->count() }}</td>
                        <td><a href="{{ route('getAccountYears', $user->id) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->container->sum('price') }}</td>
                    </tr>
                @endforeach
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>


@stop
