<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Image;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'manager_id' => 'null'
        ]);
        $user = new User(
            [
                'firstname' => $request['firstname'],
                'lastname' => $request['lastname'],
                'email' => $request['email'],
                'password' => bcrypt('password'),
                'manager_id' => isset($request->manager['key']) ? $request->manager['key'] : null
            ]
        );
        $user->assignRole($request->role['label']);
        $user->save();
    }
    public function getUsers()
    {
        // $user = User::with([''])->get();
        // return $user;
        return User::with(['roles:id,name'])->paginate(15);
    }
    public function update(Request $request)
    {
        $user = User::where('id', $request->id)->with(['roles:id,name'])->first();
        if ($user->roles[0]->name == ROLE::ROLE_MANAGER) {
            $staffs = User::where('manager_id', $user->id)->get();
            foreach ($staffs as $staff) {
                $staff->update([
                    'manager_id' => null
                ]);
            }
        }
        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'manager_id' =>  $request->manager['key'],
        ]);
        DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        $user->assignRole($request->role['label']);
    }
    public function destroy($id)
    {

        $user = User::where('id', $id)->with(['roles:id,name'])->get();
        if ($user[0]->roles[0]->name == Role::ROLE_MANAGER) {
            $items = User::where('manager_id', $id)->get();
            foreach ($items as $item) {
                $item->update([
                    'manager_id' => null
                ]);
            }
        }
        User::find($id)->delete();
    }

    public function searchUser(Request $request)
    {
        if ($request->item) {
            return User::where('firstname', 'like', '%' . $request->item . '%')
                ->orWhere('lastname', 'like', '%' . $request->item . '%')
                ->orWhere('email', 'like', '%' . $request->item . '%')
                ->with(['roles:id,name'])->paginate(15);
        } else if ($request->role) {
            return User::role($request->role['label'])->with(['roles:id,name'])->paginate(15);
        } else {
            return User::with(['roles:id,name'])->paginate(15);
        }
    }
    public function updateAccountInfo(Request $request)
    {
        $current_user = auth()->user();
        User::where('id', $current_user->id)
            ->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
            ]);
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:6|max:100',
            'new_password' => 'required|min:6|max:100',
            'confirm_password' => 'required|same:new_password'
        ]);

        $current_user = auth()->user();
        if (Hash::check($request->old_password, $current_user->password)) {
            User::where('id', $current_user->id)
                ->update([
                    'password' => bcrypt($request->new_password)
                ]);
            return response()->json(['success' => 'password successfully updated.']);
        } else {
            return response()->json(['error' => 'Old password does not match..']);
        }
    }
    public function uploadUserImage(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $data['image'] = $filename;
                $disk = Storage::disk('local')->put('public/images/' . $filename, $file, 'public');
                $find = Image::where('user_id', auth()->user()->id)->get();
                if (count($find) != 0) {
                    Image::where('user_id', auth()->user()->id)
                        ->update([
                            'image' => $disk
                        ]);
                } else {
                    Image::create([
                        'image' => $disk,
                        'user_id' => auth()->user()->id
                    ]);
                }

                return response()->json([
                    'image' => $disk
                ]);
            }
        } catch (\Throwable $th) {

            return $th;
        }
    }
    public function getImageUser()
    {
        return  DB::table('images')->where('user_id', auth()->user()->id)->get();
    }
    public function allManager()
    {
        return User::role(Role::ROLE_MANAGER)->with(['roles:id,name'])->get();
    }
    public function userDetails(Request $request)
    {

        $user = User::where('id', $request->id)->with(['roles:id,name'])->get();
        if ($user[0]->roles[0]->name == Role::ROLE_MANAGER) {
            $staff = User::where('manager_id', $user[0]->id)->with(['roles:id,name'])->get();
            return response()->json([
                'auth' => $user,
                'staff' => $staff
            ]);
        } else if ($user[0]->roles[0]->name == Role::ROLE_EMPLOYEE) {
            $manager = User::where('id', $request->manager_id)->with(['roles:id,name'])->get();

            if (count($manager) > 0) {
                return response()->json([
                    'auth' => $user,
                    'manager' => $manager
                ]);
            }
            $arr = [['firstname' => 'No Manager Assigned', 'lastname' => '']];
            return response()->json([
                'auth' => $user,
                'manager' => $arr
            ]);
        }
        return response()->json([
            'auth' => $user,
        ]);
    }
}
