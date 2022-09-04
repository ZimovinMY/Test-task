@extends('sample')

@section('title')Создание студента@endsection

@section('content')
    <h4 style="margin-left: 15px" class="text-primary"><p>Форма создания студента</p></h4>

    @if($errors->any())
        <div style="width: 400px; padding-left: 10px;" class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($exist_student_creation)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данная запись уже существует!</h5>
        </div>
    @endif

    <form method="post" action="/StudentCreation/check">
        @csrf
        <input style="width: 400px; padding-left: 10px;" type="text" name="student" id="student" placeholder="Введите ФИО студента" class="form-control"><br>
        <input style="width: 400px; padding-left: 10px;" type="text" name="year" id="year" placeholder="Введите год рождения" class="form-control"><br>
        <button style="width: 85px" type="submit" class="btn btn-primary">Создать</button>
    </form>

    <div id="StudCreation">
        <v-app>
            <v-main>
                <v-form v-model="valid">
                <v-row>
                    <v-col sm="4">
                        <v-alert
                            :value="exist_student"
                            color="red"
                            type="error">
                            Данная запись уже существует!
                        </v-alert>
                        <v-text-field
                            solo
                            label="Введите ФИО студента"
                            v-model = "FIO"
                            :rules="FIO_rules"
                            :counter="40"
                            required>
                        </v-text-field>
                        <v-text-field
                            solo
                            label="Введите дату рождения"
                            v-model = "year"
                            type="number"
                            :rules="year_rules"
                            :counter="5"
                            required>
                        </v-text-field>
                        <v-btn
                            @click="SendFIO">
                            Создать
                        </v-btn>
                    </v-col>
                </v-row>
                </v-form>
            </v-main>
        </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        new Vue({
            el: '#StudCreation',
            vuetify: new Vuetify(),
            data(){
                return{
                    FIO:'',
                    year:'',
                    exist_student: false,
                    valid: false,
                    FIO_rules: [
                        v => !!v || 'ФИО не должно быть пустым',
                        v => v.length <= 40 || 'ФИО не должно быть длиннее 40 символов',
                    ],
                    year_rules: [
                        v => !!v || 'Год рождения не должен быть пустым',
                        v => v.length <= 5 || 'Год не должен быть длиннее 5 символов',
                    ]
                }
            },
            methods:{
                SendFIO(){
                    let data = new FormData()
                    data.append('FIO',this.FIO)
                    data.append('year',this.year)

                    fetch('SendCreationFIO',{
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        body: data
                    })

                        .then((response)=>{
                            return response.json()
                        })
                            .then((data)=>{
                                if(data){
                                    window.location.replace("/")
                                }
                                if(!data){
                                    this.exist_student = true
                                }
                            })
                },
            }
        })
    </script>

@endsection
