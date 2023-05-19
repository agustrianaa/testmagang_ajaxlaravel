<?php

namespace App\Http\Controllers;
use App\Models\Program;
use App\Models\program as ModelsProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProgramAzaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Program::orderBy('sumber_dana', 'asc');
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi',function($data){
            return view('program.tombol')->with('data', $data);
        })
        ->make(true);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'sumber_dana'=>'required',
            'program'=>'required',
            'keterangan'=>'required',
        ],[
            'sumber_dana.required' => 'Sumber Dana Wajib Diisi',
            'program.required' => 'Program Wajib Diisi',
            'keterangan.required' => 'Keterangan Wajib Diisi',
        ]);

        if($validasi->fails()){
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'sumber_dana' => $request-> sumber_dana,
                'program' => $request-> program,
                'keterangan' => $request-> keterangan,
            ];
            Program::create($data);
            return response()->json(['success' => "Berhasil Menyimpan Data"]);
        }
        }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Program::where('id', $id)->first();
        return response()->json(['result'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(),[
            'sumber_dana'=>'required',
            'program'=>'required',
            'keterangan'=>'required',
        ],[
            'sumber_dana.required' => 'Sumber Dana Wajib Diisi',
            'program.required' => 'Program Wajib Diisi',
            'keterangan.required' => 'Keterangan Wajib Diisi',
        ]);

        if($validasi->fails()){
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'sumber_dana' => $request-> sumber_dana,
                'program' => $request-> program,
                'keterangan' => $request-> keterangan,
            ];
            Program::where('id', $id)->update($data);
            return response()->json(['success' => "Berhasil Melakukan Update Data"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        program::where('id', $id)->delete();
    }
}
