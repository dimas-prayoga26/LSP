<?php

namespace App\Http\Controllers;

use App\Models\{Asesi, Kelas, User};
use Illuminate\Support\Facades\{DB,Storage};
use App\Http\Requests\{StoreAsesiRequest, UpdateAsesiRequest};

class AsesiController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.asesi.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAsesiRequest $request)
    {
        $validated = $request->validated();

        $faker = \Faker\Factory::create('id_ID');
        try {
            DB::beginTransaction();
            $validated['password'] = bcrypt($validated['nim']);
            $validated['username'] = strtolower(explode(" ",$validated['name'])[0]);

            $photo = $request->file('photo');
            $gender = $request->input('jenis_kelamin');
            $kelas = Kelas::firstWhere('uuid', $validated['kelas_id']);
            if(empty($kelas)) {
                return response()->json(['status' => 'error', 'message' => 'Data kelas tidak ditemukan'], 404);
            }
            $validated['kelas_id'] = $kelas['id'];

            if($photo && !empty($photo)) {
                $validated['photo'] = $photo->store('profilePicture');
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'username' => $validated['username'] . $faker->numerify('####'),
                'phone' => $validated['phone'],
                'jenis_kelamin' => empty($gender) ? null : $validated['jenis_kelamin'],
                'address' => $validated['address'],
                'photo' => empty($photo) ? null : $validated['photo'],
                'role' => 'Asesi'
            ]);
            if ($user) {
                $asesi = Asesi::create([
                    'user_id' => (int) $user['id'],
                    'nim' => $validated['nim'],
                    'kelas_id' => $validated['kelas_id']
                ]);
                if($asesi) {
                    DB::commit();
                    return response()->json(['status' => 'success', 'message' => 'Data asesi berhasil ditambahkan'], 200);
                } else {
                    DB::rollBack();
                    return response()->json(['status' => 'error', 'message' => 'Data asesi gagal disimpan'], 500);
                }
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Data asesi gagal disimpan'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        $asesi = Asesi::with(['user','kelas'])
        ->firstWhere('uuid', $uuid);
        if(!empty($asesi)) {
            return response()->json(['status' => 'success', 'data' => $asesi], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data asesi tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAsesiRequest $request, $uuid)
    {
        $validated = $request->validated();
        $data = Asesi::with('user')->firstWhere('uuid',$uuid);
        if(empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'Data asesi tidak ditemukan'], 404);
        }

        try {
            DB::beginTransaction();
            $photo = $request->file('photo');
            $password = $request->input('password');
            $gender = $request->input('jenis_kelamin');

            if($photo && !empty($photo)) {
                if($data->user['photo'] != null && Storage::exists($data->user['photo'])) {
                    Storage::delete($data->user['photo']);
                }
                $validated['photo'] = $photo->store('profilePicture');
            }

            if(!empty($password)) {
                $validated['password'] = bcrypt($password);
            }

            $user = User::whereId((int)$data['user_id'])->first();

            $kelas = Kelas::firstWhere('uuid', $validated['kelas_id']);
            if(empty($kelas)) {
                return response()->json(['status' => 'error', 'message' => 'Data kelas tidak ditemukan'], 404);
            }
            $validated['kelas_id'] = $kelas['id'];

            $asesiUpdate = $data->update([
                'nim' => $validated['nim'],
                'kelas_id' => $validated['kelas_id'],
                'status' => $validated['status_assesmen']
            ]);
            $userUpdate = $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => empty($password) ? $data->user['password'] : $validated['password'],
                'username' => $validated['username'],
                'phone' => $validated['phone'],
                'jenis_kelamin' => empty($gender) ? null : $validated['jenis_kelamin'],
                'address' => $validated['address'],
                'photo' => empty($photo) ? $data->user['photo'] : $validated['photo'],
                'status' => $validated['status']
            ]);
            if ($asesiUpdate && $userUpdate) {
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Data asesi berhasil diubah'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Data asesi gagal diubah'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        try {
            DB::beginTransaction();
            $data = Asesi::with('user')->firstWhere('uuid',$uuid);
            if(empty($data)) {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Data asesi tidak ditemukan'], 404);
            }
            if($data->user['photo'] != null && Storage::exists($data->user['photo'])) {
                Storage::delete($data->user['photo']);
            }
            if($data->delete() && User::destroy($data['user_id'])) {
                DB::commit();
                return response()->json(['status' => 'success','message' => 'Data asesi berhasil dihapus'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Data asesi gagal dihapus'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data asesi gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = Asesi::with(['user'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = Asesi::with(['user'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
