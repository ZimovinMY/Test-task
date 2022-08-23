@extends('sample')

@section('title')Отображение студентов, изучающих дисциплину@endsection

@section('content')
    <h4 style="margin-left: 15px" class="text-primary"><p>Отображение студентов, изучающих дисциплину</p></h4>

    @if($errors->any())
        <div style="width: 400px; padding-left: 10px;" class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($no_exist_subject)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данная дисциплина не найдена!</h5>
        </div>
    @endif

    <form method="post" action="/ShowStudents/check">
        @csrf
        <input style="width: 400px; padding-left: 10px;" type="text" name="subject" id="subject" placeholder="Введите название дисциплины" class="form-control"><br>
        <button style="width: 100px" type="submit" class="btn btn-primary">Показать</button>
    </form>

    @if($students)
    <div class="p-4 p-md-5 mb-4 rounded text-bg-light text-primary">
        @foreach($students as $stud)
            <li>{{$stud->name}}</li>
        @endforeach
    </div>
    @endif

    @if($no_exist_student)
        <div style="width: 580px; margin-top: 20px;" class="p-4 p-md-5 mb-4 rounded text-bg-light text-primary">
            <h5>Нет студентов, изучающих данную дисциплину!</h5>
        </div>
    @endif

@endsection


