<?php

namespace App\Http\Controllers;
use App\Http\Requests\User\Create;
use App\Http\Requests\User\Delete;
use App\Http\Requests\User\Update;
use App\Models\Neighborhood;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class UsersController extends Controller
{/**
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $users = User::all();

            return view('backend.user.user')->with(['users' => $users]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\Create  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        try {
            $data = $request->all();

            $dataCreate  = array();
            foreach ($data as $key => $value) {
                if ($key == "password"  || $key == "password_confirmation" && $value) {
                    $value = Hash::make($value);
                }
                if ($value) {
                    $dataCreate[$key] = $value;
                }
            }
             User::create($dataCreate);
            session()->flash('success', 'User criado com sucesso.');
            return redirect()->route('user.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na criação do user.');
            return redirect()->route('user.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
       try {
           return $user;
       } catch (\Throwable $th) {
           abort(404);
       }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\Update  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, User $user)
    {
        $data = $request->all();

        $dataUpdate  = array();
        foreach ($data as $key => $value) {
            if ($key == "password" && $value) {
                $value = Hash::make($value);
            }
            if ($value) {
                $dataUpdate[$key] = $value;
            }
        }
        try {
            $user->update($dataUpdate);
            session()->flash('success', 'User actualizado com sucesso.');
            return redirect()->route('user.index');
        } catch (\Throwable $e) {

            session()->flash('error', 'Erro na actualização do user.');
            return redirect()->route('user.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        if ($user) {
            try {
                $user->delete();
                session()->flash('success', 'Usuário deletado com sucesso.');
                return redirect()->route('user.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar user.');
                return redirect()->route('user.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " Contacte o administrador do sistema."');
            return redirect()->route('user.index');
        }
    }
}
