<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Manager extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'manager';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'uuid',
        'username','nickname','email','phone',
        'password',
        'token',
        'token_expire','avatar','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
       //'email_verified_at' => 'datetime',
    ];

    static public function admincheck($request,$type='login'){
        $messages = [
            'username.required' => '用户名必填',
            'username.alpha_num' => '用户名只能是字母和数字',
            'password.required' => '密码必填',
            'password.alpha_num' => '密码只能是字母和数字',
        ];
        if($type=='login') {
            $post = $request->validate([
                //'username' => 'required|between:4,32|alpha_num',
                'username' => 'required',
                'password' => 'required|between:6,64|alpha_num',
            ], $messages);
        }else if($type=='doadd'){
            $post = $request->validate([
                'username' => 'required|between:4,32|alpha_num|unique:user',
                'nickname' => 'nullable|string',
                'phone' => 'nullable|numeric|regex:/^1[0-9]{10}$/|unique:user',
                'email' => 'nullable|email:filter|unique:user',
                'password' => 'required|between:6,64|alpha_num',
            ], $messages);
        }else if($type=='doedit'){
            $post = $request->validate([
                'username' => 'nullable|between:4,32|alpha_num',
                'nickname' => 'nullable|string',
                'phone' => 'nullable|numeric|regex:/^1[0-9]{10}$/',
                'email' => 'nullable|email:filter',
                'password' => 'nullable|alpha_num',
            ], $messages);
        }else{
            $post = [];
        }
        return $post;
    }

    public function role()
    {
        return $this->belongsToMany(Role::class,'user_role','user_id','role_id');
    }

    public function userinfo()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function useruni()
    {
        return $this->hasOne(UserUni::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function (User $user) {
            UserUni::create(['user_id'=>$user->id]);
            UserInfo::create(['user_id'=>$user->id]);
        });

        static::deleted(function (User $user) {
            UserUni::destroy($user->id);
            UserInfo::destroy($user->id);
            self::delAvatar($user->avatar);
        });
    }

    static public function delAvatar($avatar) {
        if($avatar){
            Storage::delete($avatar);
        }
    }

    public function urlAvatar($avatar,$path) {
        $path = Common\Image::avatar($avatar,$path);
        $this->avatar = $path;
        return $this->save();
    }

    public function generateToken() {
        $this->api_token = Str::random(64);
        $this->api_token_expire = time()+120*60;
        $this->save();
        return $this->api_token;
    }

    public function api_login() {
        $this->api_token = Str::random(64);
        $this->api_token_expire = TIMESTAMP+120*60;
        $this->lastlogin = TIMESTAMP;
        $this->save();
        return $this->api_user_data();
    }

    static public function api_reg(string $type='',string $val='') {
        $data = [];
        if($type =='phone'){
            $data['phone'] = $val;
        }
        $data['username'] = Str::lower(Str::random(8));
        $old = Str::random(8);
        $data['nickname'] = Str::random(4);
        $data['password'] = Hash::make($old);
        $data['api_token'] = Str::random(64);
        $data['api_token_expire'] = time()+120*60;
        $data['lastlogin'] = TIMESTAMP;
        $user = self::create($data);
        if($user){
            //通知
            return $user;
        }else{
            Common::resJson([
                'code'=> 10026,
                'msg' => '注册错误',
                'data' => $user->api_user_data()
            ]);
        }
    }

    public function api_user_data() {
        return ['api_token'=>Crypt::encryptString($this->api_token),
            'user_id'=>$this->id,
            'username'=>$this->username,
            'nickname'=>$this->nickname,
            'avatar'=>Common::filePath($this->avatar)
        ];
    }

    public function api_changepw($password) {
        $this->password = Hash::make($password);
        $this->api_token = Str::random(64);
        $this->api_token_expire = time()+120*60;
        $this->save();
        return $this;
    }

    public function logout() {
        $this->api_token = null;
        $this->api_token_expire = 0;
        return $this->save();
    }

    public function register($post) {
        $this->username = Str::lower(Str::random(10));
        $this->phone = $post['phone'];
        $this->password = Hash::make($post['password']);
        $this->api_token = Str::random(64);
        $this->api_token_expire = time()+120*60;
        $this->save();
        return $this;
    }

    public function updatecredit($user_id,$credit)
    {
        DB::transaction(function () {
            DB::update('update users set votes = 1');
            DB::delete('delete from posts');
        },2);
    }

}
