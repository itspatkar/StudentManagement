<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use App\Imports\StudentImport;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Skill;
use App\Models\State;
use App\Models\City;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\isNull;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::paginate(8);
        $cities = City::all();
        $data = compact('students', 'cities');

        return view('index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::all();
        $cities = City::all();
        $skills = Skill::all();
        $data = compact('states', 'cities', 'skills');

        return view('student.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' =>  'required|email',
            'gender' => 'required',
            'dob' => 'required|date',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'photo' => 'required',
            'skills' => 'required',
            'certificates' => 'required'
        ]);

        $student = new Student;
        $student->name = $request['name'];
        $student->email = $request['email'];
        $student->gender = $request['gender'];
        $student->dob = $request['dob'];
        $student->address = $request['address'];
        $student->state = $request['state'];
        $student->city = $request['city'];

        $imageName = time() . "-profile-image." . $request->file('photo')->getClientOriginalExtension();
        echo $request->file('photo')->storeAs('public/images', $imageName);
        $student->photo = $request['photo'];

        $student->skills = implode(',', $request['skills']);

        if ($request->hasFile('certificates')) {
            $files = $request->file('certificates');
            foreach ($files as $file) {
                // $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . "-certificate-file." . $extension;
                $destinationPath = 'public/uploads/';
                echo $file->storeAs($destinationPath, $fileName);
                $student->certificates = implode(',', $request['certificates']);
            }
        }

        $student->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $students = Student::all();
        $skills = Skill::all();
        $states = State::all();
        $cities = City::all();

        if ($students->contains($id)) {
            $student = $students->find($id);
            $data = compact('student', 'skills', 'states', 'cities');

            return view('student.show', $data);
        } else {
            return "<h2>Id not found!</h2>";
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (isNull(Student::find($id))) {
            $student = Student::find($id);
            $skills = Skill::all();
            $states = State::all();
            $cities = City::all();
            $data = compact('student', 'skills', 'states', 'cities');

            return view('student.edit', $data);
        } else {
            return "<h2>Id not found!</h2>";
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' =>  'required|email',
            'gender' => 'required',
            'dob' => 'required|date',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'photo' => 'required',
            'skills' => 'required',
            'certificates' => 'required'
        ]);

        $student = Student::find($id);
        $student->name = $request['name'];
        $student->email = $request['email'];
        $student->gender = $request['gender'];
        $student->dob = $request['dob'];
        $student->address = $request['address'];
        $student->state = $request['state'];
        $student->city = $request['city'];
        $student->photo = $request['photo'];
        $student->skills = $request['skills'];
        $student->certificates = $request['certificates'];
        $student->save();

        return redirect()->route('editStudent', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Student::all()->contains($id)) {
            Student::find($id)->delete();
        } else {
            return "<h2>Id not found!</h2>";
        }

        return redirect()->back();
    }

    public function truncate()
    {
        Student::truncate();

        return redirect()->back();
    }

    public function getCity(Request $request)
    {
        $data['cities'] = City::all()->where('state_id', $request->state_id);
        return response()->json($data);
    }

    public function pdf(string $id)
    {
        $students = Student::all();
        $skills = Skill::all();
        $states = State::all();
        $cities = City::all();

        if ($students->contains($id)) {
            $student = $students->find($id);
            $data = compact('student', 'skills', 'states', 'cities');

            $pdf = PDF::loadView('student.print', $data);
            $docname = $student->id . "_" . $student->name . '_Info.pdf';

            return $pdf->download($docname);
        } else {
            return "<h2>Id not found!</h2>";
        }

        return redirect()->back();
    }

    public function importpage()
    {
        return view('student.importpage');
    }

    public function import(Request $request)
    {
        Excel::import(new StudentImport,  $request->file('sheet'));

        return back()->with('success', 'Students imported successfully.');
    }

    public function export()
    {
        return Excel::download(new StudentExport, 'students.xlsx');
    }
}
