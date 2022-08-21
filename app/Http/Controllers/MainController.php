<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function main() {
        return view('main');
    }

    public function StudentCreation() {
        return view('StudentCreation');
    }

    public function StudentCreation_check(Request $stud_request) {
        $valid = $stud_request->validate([
            'student' => 'required|min:4|max:50'
        ]);
    }

    public function SubjectCreation() {
        return view('SubjectCreation');
    }

    public function SubjectCreation_check(Request $subj_request) {
        $valid = $subj_request->validate([
            'subject' => 'required|min:4|max:50'
        ]);
    }

    public function BindingStudent() {
        return view('BindingStudent');
    }

    public function BindingStudent_check(Request $bind_request) {
        $valid = $bind_request->validate([
            'subject' => 'required|min:4|max:50',
            'student' => 'required|min:4|max:50'
        ]);
    }

    public function ShowStudents() {
        return view('ShowStudents');
    }

    public function ShowStudents_check(Request $show_request) {
        $valid = $show_request->validate([
            'subject' => 'required|min:4|max:50'
        ]);
    }

    public function GradingStudent() {
        return view('GradingStudent');
    }

    public function GradingStudent_check(Request $grade_request) {
        $valid = $grade_request->validate([
            'student' => 'required|min:4|max:50',
            'subject' => 'required|min:4|max:50',
            'grade' => 'required'
        ]);
    }
}
