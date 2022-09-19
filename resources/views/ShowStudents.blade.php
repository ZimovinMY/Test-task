@extends('sample')

@section('title')Отображение студентов, изучающих дисциплину@endsection

@section('content')

    <div id="ShowStudents">
        <v-app>
            <v-main>
                <h4 style="margin-left: 15px" class="text-primary"><p>Отображение студентов, изучающих дисциплину</p></h4>
                <v-form v-model="valid">
                    <v-row>
                        <v-col sm="4">
                            <h5 class="text-primary">Выбор дисциплины</h5>
                            <v-alert
                                :value="no_exist_subject"
                                color="red"
                                type="error"
                                dismissible
                                v-model="show_alert_subj">
                                Данная дисциплина не найдена!
                            </v-alert>
                            <v-alert
                                :value="no_exist_student"
                                color="red"
                                type="error"
                                dismissible
                                v-model="show_alert_stud">
                                Нет студентов, изучающих данную дисциплину!
                            </v-alert>


                            <v-autocomplete
                                no-data-text="Нет предметов для выбора"
                                solo
                                label="Выберите название дисциплины"
                                v-model = "subject"
                                :items = "selection_subjects"
                                clearable
                                @change="SendSubject">
                            </v-autocomplete>
                            <br>
                            <h5 class="text-primary">Выбор студента из таблицы</h5>
                            <v-autocomplete
                                no-data-text="Нет студентов для выбора"
                                solo
                                label="Выберите ФИО студента"
                                v-model = "FIO"
                                :items = "selection_students"
                                clearable
                                @change="SendFIO">
                            </v-autocomplete>
                         </v-col>
                     </v-row>
                 </v-form>
                 <br>
                 <v-data-table
                     v-model="selected"
                     :headers="headers"
                     :items="show_students"
                     :single-select= true
                     show-select
                     class="elevation-1">
                     <template v-slot:top>
                         <v-col>
                         <v-btn
                             @click="DeleteStudents"
                             small>
                             Удалить выбранное
                         </v-btn>
                         </v-col>
                     </template>
                     <template
                         v-slot:item._actions="{ item }">
                             <v-btn
                                 icon @click = "ShowDialogChange(item)">
                                 <v-icon>
                                     mdi-pencil
                                 </v-icon>
                             </v-btn>
                             <v-btn icon @click = "ShowDialogDelete(item)">
                                 <v-icon>
                                     mdi-delete
                                 </v-icon>
                             </v-btn>
                     </template>
                 </v-data-table>
                <v-dialog
                    v-model="dialog_change"
                    max-width="500px">
                    <v-card>
                        <v-card-title class="text-h5 grey lighten-2">
                            Изменение оценок за КМ
                        </v-card-title>
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="12"
                                    sm="6"
                                >
                                    <v-text-field
                                        v-model="KM[0]"
                                        label="Оценка за КМ №1">
                                    </v-text-field>
                                </v-col>

                                <v-col
                                    cols="12"
                                    sm="6"
                                >
                                    <v-text-field
                                        v-model="KM[1]"
                                        label="Оценка за КМ №2">
                                    </v-text-field>

                                </v-col>

                                <v-col
                                    cols="12"
                                    sm="6"
                                >
                                    <v-text-field
                                        v-model="KM[2]"
                                        label="Оценка за КМ №3">
                                    </v-text-field>

                                </v-col>

                                <v-col
                                    cols="12"
                                    sm="6"
                                >
                                    <v-text-field
                                        v-model="KM[3]"
                                        label="Оценка за КМ №4">
                                    </v-text-field>
                                </v-col>
                            </v-row>

                            <v-divider></v-divider>
                        </v-container>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="red darken-1"
                                text
                                @click="dialog_change = false">
                                Отмена
                            </v-btn>
                            <v-btn
                                color="green darken-1"
                                text
                                @click="ChangeString()">
                                Изменить
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-dialog
                    v-model="dialog_delete"
                    width="500">
                    <v-card>
                        <v-card-title class="text-h5 grey lighten-2">
                            Подтвердите удаление
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                Вся информация связанная с изучением данной дисциплины студентом будет удалена. Вы действительно хотите удалить строку?
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="red darken-1"
                                text
                                @click="dialog_delete = false">
                                Отмена
                            </v-btn>

                            <v-btn
                                color="green darken-1"
                                text
                                @click="DeleteString()">
                                Удалить
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
             </v-main>
         </v-app>
     </div>

     <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

     <script>
         new Vue({
             el: '#ShowStudents',
             vuetify: new Vuetify(),
             data(){
                 return{
                     KM:[null,null,null,null],
                     IdStudToDelete: '',
                     IdSubjToDelete: '',
                     IdStudToChange: '',
                     IdSubjToChange: '',
                     dialog_change: false,
                     dialog_delete: false,
                     show_alert_subj: false,
                     show_alert_stud: false,
                     selection_subjects: [],
                     selection_students: [],
                     selected: [],
                     headers: [
                         {
                             text: 'ID Студента',
                             align: 'start',
                             value: 'id_student',
                         },
                         { text: 'ФИО студента', value: 'name' },
                         { text: 'ID Предмета', value: 'id_subject' },
                         { text: 'Предмет', value: 'subject' },
                         { text: 'КМ1', value: 'km1' },
                         { text: 'КМ2', value: 'km2' },
                         { text: 'КМ3', value: 'km3' },
                         { text: 'КМ4', value: 'km4' },
                         { text: 'Изменить/удалить', value: '_actions'},
                     ],
                     students_: [],
                     students: [],
                     show_students: [],
                     subject:'',
                     FIO:'',
                     no_exist_subject: false,
                     no_exist_student: false,
                     valid: false,
                     subject_rules: [
                         v => !!v || 'Дисциплина не должна быть пустой',
                         v => v.length <= 40 || 'Дисциплина не должна быть длиннее 40 символов',
                     ],
                 }
             },
             methods:{
                 ShowDialogChange(item){
                     this.IdStudToChange = ''
                     this.IdSubjToChange = ''
                     this.IdStudToChange = item.id_student
                     this.IdSubjToChange = item.id_subject
                     this.KM[0] = item.km1
                     this.KM[1] = item.km2
                     this.KM[2] = item.km3
                     this.KM[3] = item.km4
                     this.dialog_change = true;
                 },
                 ShowDialogDelete(item){
                     this.IdStudToDelete = ''
                     this.IdSubjToDelete = ''
                     this.IdStudToDelete = item.id_student
                     this.IdSubjToDelete = item.id_subject
                     this.dialog_delete = true;
                 },
                 DeleteString(){
                     let data = new FormData()
                     data.append('id_student',this.IdStudToDelete)
                     data.append('id_subject',this.IdSubjToDelete)
                     fetch('DeleteString',{
                         method: 'POST',
                         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                         body: data
                     })
                         .then((response)=>{
                             return response.json()
                         })
                         .then((data)=>{
                             if(data){
                                 this.dialog_delete = false
                                 this.SendSubject();
                             }
                         })
                 },
                 ChangeString(){
                     let data = new FormData()
                     data.append('id_student',this.IdStudToChange)
                     data.append('id_subject',this.IdSubjToChange)
                     for (var i = 0; i < this.KM.length; i++) {
                         data.append('KM[]', this.KM[i]);
                     }
                     fetch('ChangeString',{
                         method:'POST',
                         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                         body:data
                     })
                         .then((response)=>{
                             return response.json()
                         })
                         .then((data)=>{
                             if(data){
                                 this.dialog_change = false
                                 this.SendSubject();
                             }
                         })
                 },
                 Students_fill(){
                     let this_ = this
                     this.students=[]

                     let id_stud=this.students_[0].id_student
                     let row={id_student: '', name: '',id_subject: '',subject:'', km1: '0' ,km2: '0' ,km3: '0', km4: '0'}
                     this.students_.forEach(function fun (curVal){
                         if(curVal.id_student===id_stud)
                         {
                             //
                         }
                         else{
                             this_.students.push(row)
                             row={id_student: '', name: '',id_subject: '',subject:'', km1: '0' ,km2: '0' ,km3: '0', km4: '0'}
                             id_stud=curVal.id_student
                         }
                         row['id_student']=curVal.id_student
                         row['name']=curVal.name
                         row['id_subject']=curVal.id_subject
                         row['subject']=curVal.subject
                         if(curVal.KM_num == 1 && curVal.grade != null){
                             row['km1']=curVal.grade
                         }
                         else if(curVal.KM_num == 2 && curVal.grade != null){
                             row['km2']=curVal.grade
                         }
                         else if(curVal.KM_num == 3 && curVal.grade != null){
                             row['km3']=curVal.grade
                         }
                         else if(curVal.KM_num == 4 && curVal.grade != null){
                             row['km4']=curVal.grade
                         }

                     })
                     this_.students.push(row)
                     this.show_students = this_.students
                     this.ShowSelectionStudents()
                 },
                 SendSubject(){
                     this.show_students = []
                     if (this.subject){
                         let data = new FormData()
                         data.append('subject',this.subject)

                         fetch('ShowTable',{
                             method: 'POST',
                             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                             body: data
                         })

                             .then((response)=>{
                                 return response.json()
                             })
                             .then((data)=>{
                                 if(data[1]==1){
                                     this.no_exist_subject = true
                                     this.show_alert_subj = true
                                 }
                                 if(data[1]==2){
                                     this.no_exist_student = true
                                     this.students = []
                                     this.show_alert_stud = true
                                 }
                                 if(data[1]==0){
                                     array = Object.values(data[0])
                                     this.students_ = array
                                     this.show_alert_subj = false
                                     this.show_alert_stud = false
                                     this.Students_fill()
                                 }
                             })
                     }
                 },
                 SendFIO(){
                     if ((this.FIO == '') || (this.FIO == null)) {
                         this.show_students = this.students
                     }
                     else{
                         this.show_students = this.students.filter(student => student.name == this.FIO)
                     }
                 },
                 DeleteStudents(){
                     let data = new FormData()
                     let result = this.selected.map(({ id_student }) => id_student);
                     console.log(result)
                     ides = result[0]
                     data.append('id_student',ides)
                     fetch('SendDeleteID',{
                         method:'POST',
                         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                         body:data
                     })
                         .then((response)=>{
                             return response.json()
                         })
                             .then((data)=>{
                                 if(data){
                                     this.SendSubject();
                                 }
                             })
                 },
                 ShowSelectionSubjects(){
                     let data = new FormData()
                     fetch('GetTableSubjects',{
                         method:'GET',
                         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                     })
                         .then((response)=>{
                             return response.json()
                         })
                         .then((data)=>{
                             this.selection_subjects = data.map(({ subject }) => subject)
                         })
                 },
                 ShowSelectionStudents(){
                     this.selection_students = this.students.map(({ name }) => name)

                 }
             },
             mounted: function (){
                 this.ShowSelectionSubjects();
                 this.ShowSelectionStudents();
             }
         })
     </script>

@endsection


