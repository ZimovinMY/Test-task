@extends('sample')

@section('title')Проставление оценки студенту за дисциплину@endsection

@section('content')
    <h4 style="margin-left: 15px" class="text-primary"><p>Форма проставления оценки студенту за дисциплину</p></h4>

    @if($errors->any())
        <div style="width: 400px; padding-left: 10px;" class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="/GradingStudent/check">
        @csrf
        <input style="width: 400px; padding-left: 10px;" type="text" name="student" id="student" placeholder="Введите ФИО студента" class="form-control"><br>
        <input style="width: 400px; padding-left: 10px;" type="text" name="subject" id="subject" placeholder="Введите название дисциплины" class="form-control"><br>
        <input style="width: 400px; padding-left: 10px;" type="number" min="0" max="5" name="grade" id="grade" placeholder="Введите оценку" class="form-control"><br>
        <button style="width: 100px" type="submit" class="btn btn-primary">Добавить</button>
    </form>
@endsection
