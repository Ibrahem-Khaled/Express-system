@extends('layouts.default')

@section('content')
    <form action="{{ route('empty') }}" class="row align-items-center" method="GET">
        <div class="col">
            <input type="text" name="query" class="form-control" placeholder="Search...">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-success">Search</button>
        </div>
    </form>
    <div class="container mt-5">
        <div class="container mt-5">
            <div class="table-container overflow-auto mt-4 p-3" style=" overflow: auto; position: relative;">
                <h3 class="text-center mb-4" style="position: sticky; top: 0; z-index: 0;">{{ count($containerPort) }}
                    الحاويات المحملة</h3>
                <table id="example" class="table table-striped" style="width:100%">
                    <thead class="bg-aqua" style="position: sticky; top: 0; z-index: 0;">
                        <tr>
                            <th scope="col" class="text-center">العميل</th>
                            <th scope="col" class="text-center">مكتب التخليص</th>
                            <th scope="col" class="text-center">التاريخ</th>
                            <th scope="col" class="text-center">السيارة</th>
                            <th scope="col" class="text-center">السائق</th>
                            <th scope="col" class="text-center">حجم الحاوية</th>
                            <th scope="col" class="text-center">رقم الحاوية</th>
                            <th scope="col" class="text-center">رقم البيان</th>
                            <th scope="col" class="text-center">الحالة</th>
                            <th scope="col" class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($containerPort as $item)
                            <tr>
                                <td class="text-center">{{ $item->customs->subclient_id }}</td>
                                <td class="text-center">{{ $item->client->name }}</td>
                                <td class="text-center">{{ $item->created_at }}</td>
                                @if ($item->rent_id == null)
                                    <td class="text-center">{{ $item->car->number ?? 0 }}</td>
                                    <td class="text-center">{{ $item->driver->name ?? 0 }}</td>
                                @else
                                    <td class="text-center">{{ $item->rent->name }}</td>
                                    <td class="text-center">{{ $item->rent->name }}</td>
                                @endif
                                <td class="text-center">{{ $item->size }}</td>
                                <td class="text-center">{{ $item->number }}</td>
                                <td class="text-center">{{ $item->customs->statement_number }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $item->id }}">محملة</button>

                                    <div class="modal fade" id="updateModal{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="updateModalLabel{{ $item->id }}"
                                        aria-hidden="true">

                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateModalLabel{{ $item->id }}">تحديث
                                                        الحالة</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('updateEmpty', $item->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="status" value="done">
                                                        <div class="form-group">
                                                            <label for="user">اختر المستخدم</label>
                                                            <select class="form-control" id="user" name="user_id"
                                                                required>
                                                                @foreach ($driver as $user)
                                                                    <option value="{{ $user->id }}">
                                                                        {{ $user->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="car">اختر السيارة</label>
                                                            <select class="form-control" id="car" name="car_id"
                                                                required>
                                                                @foreach ($cars as $car)
                                                                    <option value="{{ $car->id }}">
                                                                        {{ $car->number }}-{{ $car?->driver?->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="price">السعر</label>
                                                            <input type="number" class="form-control" id="price"
                                                                name="price" value="20" required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">إغلاق</button>
                                                            <button type="submit" class="btn btn-primary">تحديث</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="container mt-5">
            <div class="table-container overflow-auto mt-4 p-3" style=" overflow: auto; position: relative;">
                <h3 class="text-center mb-4" style="position: sticky; top: 0; z-index: 0;">{{ count($done) }} الحاويات
                    الفارغة</h3>
                <table id="example2" class="table table-striped" style="width:100%">
                    <thead class="bg-aqua" style="position: sticky; top: 0; z-index: 0;">
                        <tr>
                            <th scope="col" class="text-center">العميل</th>
                            <th scope="col" class="text-center">مكتب التخليص</th>
                            <th scope="col" class="text-center">سيارة المحملة</th>
                            <th scope="col" class="text-center">سائق المحملة</th>
                            <th scope="col" class="text-center">سيارة الفارغ</th>
                            <th scope="col" class="text-center">سائق الفارغ</th>
                            <th scope="col" class="text-center">حجم الحاوية</th>
                            <th scope="col" class="text-center">رقم الحاوية</th>
                            <th scope="col" class="text-center">رقم البيان</th>
                            <th scope="col" class="text-center">الحالة</th>
                            <th scope="col" class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($done as $item)
                            <tr>
                                <td class="text-center">{{ $item->customs->subclient_id }}</td>
                                <td class="text-center">{{ $item->client->name }}</td>
                                @if ($item->rent_id == null)
                                    <td class="text-center">{{ $item->car->number ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $item->driver->name ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $item->tipsEmpty->car->number ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $item->tipsEmpty->user->name ?? 'N/A' }}</td>
                                @else
                                    <td class="text-center">{{ $item->rent->name }}</td>
                                    <td class="text-center">اسم شركة الايجار</td>
                                @endif
                                <td class="text-center">{{ $item->size }}</td>
                                <td class="text-center">{{ $item->number }}</td>
                                <td class="text-center">{{ $item->customs->statement_number }}</td>
                                <td class="text-center">
                                    <form id="confirmationForm{{ $item->id }}"
                                        action="{{ route('updateEmpty', $item->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="transport">
                                        <button type="button" class="btn btn-warning"
                                            onclick="showConfirmation({{ $item->id }})">فارغ</button>
                                    </form>
                                </td>
                                <td class="text-center">{{ $item->id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function showConfirmation(itemId) {
            if (confirm("هل انت متاكد من هذا الطلب?")) {
                document.getElementById("confirmationForm" + itemId).submit();
            } else {
                return false;
            }
        }
    </script>
@stop
