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



    <div id="StudDelete">
        <v-app>
            <v-main>
                <v-form v-model="valid">
                    <v-row>
                        <v-col sm="4">
                            <v-alert
                                :value="no_exist_student"
                                color="red"
                                type="error"
                                dismissible
                                v-model="show_alert_no_student">
                                Данный студент не найден!
                            </v-alert>
                            <v-text-field
                                solo
                                label="Введите ФИО студента"
                                v-model = "FIO"
                                :rules="FIO_rules"
                                :counter="40"
                                required>
                            </v-text-field>
                            <v-btn
                                @click.stop = "check_rules">
                                <!-- @click.stop="confirm_delete = true" -->
                                Удалить
                            </v-btn>
                            <v-dialog
                                v-model="confirm_delete"
                                max-width="500"
                            >
                                <v-card>
                                    <v-card-title class="text-h5">
                                        Подтвердите удаление
                                    </v-card-title>

                                    <v-card-text>
                                        Вся информация связанная с данным студентом будет удалена. Вы действительно хотите удалить данного студента?
                                    </v-card-text>

                                    <v-card-actions>
                                        <v-spacer></v-spacer>

                                        <v-btn
                                            color="red darken-1"
                                            text
                                            @click="confirm_delete = false"
                                        >
                                            Отмена
                                        </v-btn>

                                        <v-btn
                                            color="green darken-1"
                                            text
                                            @click="confirm_delete = false;SendFIO()"
                                        >
                                            Удалить
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
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
            el: '#StudDelete',
            vuetify: new Vuetify(),
            data(){
                return{
                    confirm_delete: false,
                    FIO:'',
                    no_exist_student: false,
                    show_alert_no_student: false,
                    valid: false,
                    FIO_rules: [
                        v => !!v || 'ФИО не должно быть пустым',
                        v => v.length <= 40 || 'ФИО не должно быть длиннее 40 символов',
                    ]
                }
            },
            methods:{
                SendFIO(){
                    let data = new FormData()
                    data.append('FIO',this.FIO)
                    fetch('SendDeleteFIO',{
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
                            else{
                                this.no_exist_student = true
                                this.show_alert_no_student = true
                            }
                        })
                },
                check_rules(){
                    if (this.FIO && this.FIO.length <= 40){
                        this.confirm_delete = true
                    }
                    else {
                        this.confirm_delete = false
                    }
                },
            }
        })
    </script>

    @if($no_exist_student_delete)
        <div style="width: 400px; padding-left: 20px;" class="alert alert-warning">
            <h5>Данный студент не найден!</h5>
        </div>
    @endif
@endsection
