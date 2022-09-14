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
                 </v-data-table>
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
                     show_alert_subj: false,
                     show_alert_stud: false,
                     selection_subjects: [],
                     selection_students: [],
                     selected: [],
                     headers: [
                         {
                             text: 'ID Студента',
                             align: 'start',
                             value: 'id',
                         },
                         { text: 'ФИО студента', value: 'name' },
                         { text: 'Предмет', value: 'subject' },
                         { text: 'КМ1', value: 'km1' },
                         { text: 'КМ2', value: 'km2' },
                         { text: 'КМ3', value: 'km3' },
                         { text: 'КМ4', value: 'km4' },
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
                 Students_fill(){
                     let this_ = this
                     this.students=[]

                     let id_stud=this.students_[0].id
                     let row={id: '', name: '',subject:'', km1: '0' ,km2: '0' ,km3: '0', km4: '0'}
                     this.students_.forEach(function fun (curVal){
                         if(curVal.id===id_stud)
                         {
                             //
                         }
                         else{
                             this_.students.push(row)
                             row={id: '', name: '',subject:'', km1: '0' ,km2: '0' ,km3: '0', km4: '0'}
                             id_stud=curVal.id
                         }
                         row['id']=curVal.id
                         row['name']=curVal.name
                         row['subject']=curVal.subject
                         if(curVal.KM_num == 1){
                             row['km1']=curVal.grade
                         }
                         else if(curVal.KM_num == 2){
                             row['km2']=curVal.grade
                         }
                         else if(curVal.KM_num == 3){
                             row['km3']=curVal.grade
                         }
                         else if(curVal.KM_num == 4){
                             row['km4']=curVal.grade
                         }

                     })
                     this_.students.push(row)
                     this.show_students = this_.students
                     this.ShowSelectionStudents()
                 },
                 SendSubject(){
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
                     let result = this.selected.map(({ name }) => name);
                     names = result[0]
                     data.append('FIO',names)
                     fetch('SendDeleteFIO',{
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


