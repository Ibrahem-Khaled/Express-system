@extends('layouts.default')

@section('content')

    <div class="col-md-12">
        <h1 class="text-success" style="text-align: right">كشف حساب {{ $user->name }}</h1>
    </div>

    <div class="container mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">اجمالي سعر النقل</th>
                    <th scope="col">سعر النقل</th>
                    <th scope="col">سعر امر النقل</th>
                    <th scope="col">عدد الحاويات</th>
                    <th scope="col">العميل</th>
                    <th scope="col">رقم البيان</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
            <form action="{{ route('updateContainerPrice') }}" method="POST">
                @csrf
                <tbody>
                    @php
                        $totalPrice = 0;
                        $totalWithdrawPrice = 0;
                    @endphp
                    @foreach ($customs as $custom)
                        @php
                            $transportContainers = $custom->container->whereIn('status', ['transport', 'done', 'rent']);
                        @endphp
                        @if ($transportContainers->isNotEmpty())
                            <input type="hidden" value="{{ $custom->id }}" name="id[]" />
                            <tr>
                                @php
                                    $containerPrice = $custom->container
                                        ->whereIn('status', ['transport', 'done', 'rent'])
                                        ->sum('price');
                                    $withdrawPrice = $custom->container
                                        ->flatMap(fn($c) => $c->daily)
                                        ->where('type', 'withdraw')
                                        ->sum('price');
                                    $totalPrice += $containerPrice;
                                    $totalWithdrawPrice += $withdrawPrice;
                                @endphp

                                <td>{{ $containerPrice }}</td>
                                <td>
                                    <div class="input-group mb-3">
                                        @if (auth()->user()?->userinfo?->job_title == 'administrative')
                                            <input type="text"
                                                value="{{ $containerPrice / $custom->container->whereIn('status', ['transport', 'done', 'rent'])->count() }}"
                                                class="custom-form-control" placeholder="سعر الحاوية"
                                                aria-label="سعر الحاوية" aria-describedby="basic-addon2" disabled>
                                        @else
                                            <input type="text" name="price[]"
                                                value="{{ $containerPrice / $custom->container->whereIn('status', ['transport', 'done', 'rent'])->count() }}"
                                                class="custom-form-control" placeholder="سعر الحاوية"
                                                aria-label="سعر الحاوية" aria-describedby="basic-addon2">
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $withdrawPrice }}</td>
                                <td>{{ $custom->container->whereIn('status', ['transport', 'done', 'rent'])->count() }}
                                </td>
                                <td scope="row">{{ $custom->subclient_id }}</td>
                                <td scope="row">
                                    <a href="{{ route('showContainer', $custom->id) }}">
                                        {{ $custom->statement_number }}
                                    </a>
                                </td>
                                <th scope="row">{{ $custom->id }}</th>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                <button type="submit" class="btn btn-primary">تاكيد سعر الحاوية</button>
            </form>
        </table>

        <table class="table mt-5">
            <thead>
                <tr>
                    <th scope="col">التفاصيل</th>
                    <th scope="col">المبلغ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <h6 class="text-dark">{{ $totalPrice }}</h6>
                    </td>
                    <td>
                        <h6 class="text-primary">مجموع سعر الحاويات</h6>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h6 class="text-dark">{{ $totalWithdrawPrice }}</h6>
                    </td>
                    <td>
                        <h6 class="text-dark">مجموع اوامر النقل</h6>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h6 class="text-dark">{{ $totalWithdrawPrice + $totalPrice }}</h6>
                    </td>
                    <td>
                        <h6 class="text-dark">الاجمالي</h6>
                    </td>
                </tr>
                <tr>
                    <td>
                        @php
                            $sumWith = ($totalWithdrawPrice + $totalPrice) * 0.15;
                        @endphp
                        <h6 class="text-dark">{{ $sumWith }}</h6>
                    </td>
                    <td>
                        <h6 class="text-success">(% 15) القيمة المضافة</h6>
                    </td>
                </tr>

                <tr>
                    <td>
                        <h6 class="text-dark">{{ $totalWithdrawPrice + $totalPrice + $sumWith }}</h6>
                    </td>
                    <td>
                        <h6 class="text-danger">الاجمالي شامل القيمة المضافة</h6>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

@stop
