<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user,$role;
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::latest('id')->paginate(5);
        if ($request->has('keyword') && $request->input('keyword') !== '') {
            $keyword = $request->input('keyword');
            $users = $this->user->search($keyword)->latest('id')->paginate(5);
        }
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles =   $this->role->all()->groupBy('group');
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $dataCreate = $request->all();
        $dataCreate['password'] = Hash::make($request->password);
        $dataCreate['image'] = $this->user->saveImage($request);

        $user =$this ->user ->create($dataCreate);
        $user ->images()->create(['url' =>$dataCreate['image']]);
        $user->roles()->attach($dataCreate['role_ids']?? []);
        return to_route('users.index')->with(['message'=> 'Thêm mới thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user= $this->user->findOrFail($id)->load('roles');
        $roles =   $this->role->all()->groupBy('group');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $dataUpdate = $request->except('password');
        $user =$this->user->findOrFail($id)->load('roles');
        if ($request->password) {
            $dataUpdate['password'] = Hash::make($request->password);
        }
        $currentImage = $user->images ->count() >0 ? $user->images->first()->url : '';
        $dataUpdate['image'] = $this->user->updateImage($request, $currentImage);
        $user->update($dataUpdate);
        $user ->images()->delete();
        $user ->images()->create(['url' =>$dataUpdate['image']]);
        $user->roles()->sync($dataUpdate['role_ids'] ?? []);
        return to_route('users.index')->with(['message'=> 'Cập nhật thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user =$this->user->findOrFail($id)->load('roles');
        $user->images()->delete();
        $imageName = $user->images->count() >0 ? $user->images->first()->url : '';
        $this->user->deleteImage($imageName);
        $user->delete();
        return to_route('users.index')->with(['message'=> 'Xóa thành công']);
    }
}
