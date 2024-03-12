<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $doctors = DB::table('doctors')
            ->when($request->input('name'), function ($query, $doctor_name) {
                return $query->where('doctor_name', 'like', '%' . $doctor_name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.doctors.index', compact('doctors'));
    }

    //create doctor
    public function create()
    {
        return view('pages.doctors.create');
    }

    //store doctor
    public function store(Request $request)
    {
        $request->validate([
            'doctor_name' => 'required',
            'doctor_specialist' => 'required',
            'doctor_phone' => 'required',
            'doctor_email' => 'required|email',
            'sip' => 'required',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',

        ]);

        $photo = $request->file('photo');
        $photo->storeAs('public/doctors', $photo->hashName());

        DB::table('doctors')->insert([
            'doctor_name' => $request->doctor_name,
            'doctor_specialist' => $request->doctor_specialist,
            'doctor_phone' => $request->doctor_phone,
            'doctor_email' => $request->doctor_email,
            'sip' => $request->sip,
            'photo'     => $photo->hashName(),
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully');
    }

    //show doctor
    public function show($id)
    {
        $doctor = DB::table('doctors')->where('id', $id)->first();
        return view('pages.doctors.show', compact('doctor'));
    }

    //edit doctor
    public function edit($id)
    {
        //$doctor = DB::table('doctors')->where('id', $id)->first();
        $doctor = Doctor::find($id);
        return view('pages.doctors.edit', compact('doctor'));
    }

    //update doctor
    public function update(Request $request, $id)
    {

        $request->validate([
            'doctor_name' => 'required',
            'doctor_specialist' => 'required',
            'doctor_phone' => 'required',
            'doctor_email' => 'required|email',
            'sip' => 'required',
        ]);

        DB::table('doctors')->where('id', $id)->update([
            'doctor_name' => $request->doctor_name,
            'doctor_specialist' => $request->doctor_specialist,
            'doctor_phone' => $request->doctor_phone,
            'doctor_email' => $request->doctor_email,
            'sip' => $request->sip,
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully');
    }


    //delete doctor
    public function destroy($id)
    {
        DB::table(('doctors'))->where('id', $id)->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor delete successfully');
    }
}
