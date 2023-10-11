<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProtocolType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function account(){
        if(Auth::id()){
            return redirect('/profile');
        }
    }

    public function students(){
        if(Auth::id()){
            $roleID=Auth()->user()->roleid;
            if($roleID==4){
               $users = DB::table('users')->get();
               return view('AdminDashboard', ['users' => $users]);
            }
            else{
               abort(401);
            }
        }
    }

    public function addUser(Request $request){
        if(Auth::id()){
            $roleID=Auth()->user()->roleid;
            if($roleID==4){
                $username = array($request->input('firstname'), $request->input('lastname'));
                $email = array($request->input('firstname'),'.',$request->input('lastname'),'@email.com');

                $query = DB::table('users')->insert([
                    'firstname'=>$request->input('firstname'),
                    'lastname'=>$request->input('lastname'),
                    'username'=>join("", $username),
                    'email'=>join("", $email),
                    'password'=> Hash::make('1234'),
                    'roleid'=>$request->input('role')
                ]);
                return back();
            }
            else{
                abort(401);
            }
        }       
    }

    public function deleteUser($id){
        if(Auth::id()){
            $roleID=Auth()->user()->roleid;
            if($roleID==4){
                $user = User::find($id);
                $user->delete();
                return back();
            }
            else{
                abort(401);
            }
        }
    }

    public function editUser($id){
        if(Auth::id()){
            $roleID=Auth()->user()->roleid;
            if($roleID==4){
                $user = User::find($id);

                return view('editUser', compact('user'));
            }
            else{
                abort(401);
            }
        }
    }

    public function updateUser(Request $request, $id){
        if(Auth::id()){
            $roleID=Auth()->user()->roleid;
            if($roleID==4){
                $user = User::find($id);
                $user->firstname = $request->input('firstname');
                $user->lastname = $request->input('lastname');
                $user->username = $request->input('username');
                $user->roleid = $request->input('role');
                $user->update();
                return redirect('/students');
            }
            else{
                abort(401);
            }
        }
    }

    // Home page?
    public function index(){
        return view('home');
    }

    // Admin homepage
    public function adminhome(){
        if(Auth::id()){
            $roleID = Auth()->user()->roleid;
            if($roleID==4){ return view('components.pages.adminhome'); }
            else{
                abort(401);
            }
        }
    }

    // admin protocollen
    // view pages
    public function protocoladmin(){
        if(Auth::id()){
            $roleID = Auth()->user()->roleid;
            if($roleID==4){
                $protocollen = DB::table('protocoldetail')->get();
                return view('components.pages.protocollenadmin', ['protocollen' => $protocollen]);
            }
            else{
                abort(401);
            }
        }
    }

    public function protocoledit($id){
        if(Auth::id()){
            $roleID = Auth()->user()->roleid;
            if($roleID==4){ return view('components.pages.protocollenedit', ['id' => $id]); }
            else{
                abort(401);
            }
        }
    }

    // data handlers
    public function protocoladd(Request $request){
        if(Auth::id()){
            $roleID=Auth()->user()->roleid;
            if($roleID==4){
                $name = $request->input('name');
                $protocoltypeid = $request->input('protocoltypeid');
                $icon = $request->input('icon');
                $file = $request->input('file');
                DB::table('protocoldetail')->insert([
                    'name'=>$name,
                    'protocoltypeid'=>$protocoltypeid,
                    'icon'=>$icon,
                    'file'=>$file
                ]);
                return back();
            }
            else{
                abort(401);
            }
        }
    }

    public function protocolupdate($id){
        if(Auth::id()){
            $roleID=Auth()->user()->roleid;
            if($roleID==4){
                return redirect('/account');
            }
            else{
                abort(401);
            }
        }
    }

    public function commentupdate($id, $id2, $id3) {
        $bool = 0;
        echo "<script>console.log('$id2')</script>";
        if ($id2 == "Leerkracht") {
            $bool = 1;
        }
        echo "<script>console.log('$bool')</script>";
        if (DB::table('comment')
            ->where([
                ["leerkracht", "=", $bool],
                ["dierid", "=", $id3]
            ])
            ->exists()){
                DB::table('comment')
            ->where([
                ["leerkracht", "=", $bool],
                ["dierid", "=", $id3]
            ])
            ->update(["comment"=>$id]);
            }
            else {DB::table("comment")
                ->insert(["leerkracht"=>$bool, "dierid"=>$id3, "comment"=>$id]);
            };
        return back();
    }

    // public function protocoldelete($id){
    //     if(Auth::id()){
    //         $roleID=Auth()->user()->roleid;
    //         if($roleID==4){
    //             $protocol = ProtocolType::find($id);
    //             $protocol->delete();
    //             return back();
    //         }
    //         else{
    //             abort(401);
    //         }
    //     }
    // }
}
