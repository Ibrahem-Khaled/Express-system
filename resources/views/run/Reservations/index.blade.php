@extends('layouts.default')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center text-white">عرض بيانات البيان الجمركي</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>تاريخ أرضية الجمارك</th>
                    <th>المكتب</th>
                    <th>العميل</th>
                    <th>وزن البيان الجمركي</th>
                    <th>الحاويات المحجوزة</th>
                    <th>الحاويات المنتظرة</th>
                    <th>رقم البيان</th>
                </tr>
            </thead>
            <tbody>
                @forelse($statements as $statement)
                    <tr>
                        <td>
                            <x-countdown-timer :id="$statement->id" :transfer_date="$statement->expire_customs"
                                 :date_empty="$statement->expire_customs" />
                            {{-- <x-edit-modal :id="$statement->id" :date_empty="$statement->date_empty" /> --}}
                        </td>
                        <td>{{ $statement->client->name }}</td>
                        <td>{{ $statement->subclient_id }}</td>
                        <td>{{ $statement->customs_weight }} كجم</td>
                        <td>{{ $statement->container->where('status', 'transport')->count() }}</td>
                        <td>{{ $statement->container->where('status', 'wait')->count() }}</td>
                        <td>
                            <a href="{{ route('reservations.show', $statement->id) }}">
                                {{ $statement->statement_number }}</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">لا توجد بيانات متاحة</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@stop
