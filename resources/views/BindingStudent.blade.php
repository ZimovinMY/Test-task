@extends('sample')

@section('title')Привязка студента к дисциплине@endsection

@section('content')
    <h4 style="margin-left: 15px" class="text-primary"><p>Форма привязки студента к дисциплине</p></h4>

    @if($errors->any())
        <div style="width: 400px; padding-left: 10px;" class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($no_stud_binding)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данный студент не найден!</h5>
        </div>
    @endif

    @if($no_subj_binding)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данная дисциплина не найдена!</h5>
        </div>
    @endif

    @if($exist_binding)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данная запись уже существует!</h5>
        </div>
    @endif

    <form method="post" action="/BindingStudent/check">
        @csrf
        <input style="width: 400px; padding-left: 10px;" type="text" name="subject" id="subject" placeholder="Введите название дисциплины" class="form-control"><br>
        <input style="width: 400px; padding-left: 10px;" type="text" name="student" id="student" placeholder="Введите ФИО студента" class="form-control"><br>
        <button style="width: 100px" type="submit" class="btn btn-primary">Добавить</button>
    </form>
@endsection
