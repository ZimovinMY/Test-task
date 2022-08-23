@extends('sample')

@section('title')Удаление студента@endsection

@section('content')
    <h4 style="margin-left: 15px" class="text-primary"><p>Форма удаления студента</p></h4>

    @if($errors->any())
        <div style="width: 400px; padding-left: 10px;" class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($no_exist_student_delete)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данный студент не найден!</h5>
        </div>
    @endif

    <form method="post" action="/DeleteStudent/check">
        @csrf
        <input style="width: 400px; padding-left: 10px;" type="text" name="student" id="student" placeholder="Введите ФИО студента" class="form-control"><br>
        <button style="width: 85px" type="submit" class="btn btn-primary">Удалить</button>
    </form>
@endsection
