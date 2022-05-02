<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\User;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $offset = $request->has('offset') ? $request->query('offset') : 0;
        $limit = $request->has('limit') ? $request->query('limit') : 10;
//        return response(Product::offset($request->offset)->limit($request->limit), 200);

        $qb = User::query();
        if ($request->has('q'))
            $qb ->where('name', 'like', '%'. $request->query('q'). '%');

        if ($request->has('sortBy'))
            $qb ->orderBy($request->query('sortBy'), $request->query('sort', 'DESC'));

        $data = $qb->offset($offset)->limit($limit)->get();

        // dönüş yaparken sadece index kısmında full name dönsün istiyorsak bu şekilde tanımlayabilirz
        $data->each(function($item){
           $item->setAppends(['full_name']);
        });
        // daha kısa bir yöntemle
//        $data->each->setAppends(['full_name']);

        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return Response
     */
    public function store(UserStoreRequest $request)
    {
        // validator sınıfıyla istek içindeki verileri doğruluyoruz
//        $validator = Validator::make( $request->all(),[
//           'email'=>'required|email|unique:users',
//           'name'=>'required|string|max:50',
//           'password'=>'required'
//        ]);

//        if( $validator->fails())
//            return Response('hatalı bilgi girdiniz');

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response([
            'data' => $user,
            'message' => 'User Created'
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
       return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response([
            'data' => $user,
            'message' => 'User Updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response([
            'message' => 'user Deleted'
        ], 200);
    }
    public function custom1(){

//        $user2 = User::find(2);
//        return new UserResource($user2);

        //wrapping işlemini sadece bir metotta yapmak istiyorsak
        // UserResource::withoutWrapping();


        // birden fazla kayıt döneceğimiz zaman collection kullanıyoruz.
         $users = User::all();
        // return UserResource::collection($users);

//        return new UserCollection($users);

        // yukarıdaki kodda userscollection kullanarak ek kolon eklemiştik farklı dosya açmayıp doğrudan
        // da ek kolon ekleyebiliyoruyz.

        return UserResource::collection($users)->additional([
            'meta'=>[
                'total_users'=> $users->count(),
                'custom' => 'value'
            ]
        ]);
    }
}

