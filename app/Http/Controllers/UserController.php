<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeDislikeRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserListRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserLikeDislikeHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if ($user && Hash::check($request->password, $user->password)) {
            
            $data['token'] = $user->createToken('Sarika')->accessToken;
            $data['message'] = 'You are login successfully';

            return $this->sendResponse($data);
        }
        return $this->sendError('Invalid Credential', 404);
    }

    public function userList(Request $request) {
        $user_id = auth('api')->user()->id ?? 0;

        $users = User::select('*')        
        ->selectRaw('ROUND((ST_Distance_Sphere(Point('.$request->longitude.', '.$request->latitude.'),Point(`longitude`, `latitude`))) / 1000, 2) as distance');
        /* select(
            DB::raw("*, (ROUND(3959 * ACOS(COS(RADIANS($request->latitude)) * COS(RADIANS(latitude)) * COS(RADIANS($request->longitude) - RADIANS(longitude)) + SIN(RADIANS($request->latitude)) * SIN(RADIANS(latitude))))) AS distance")
        ); */
        
        if($user_id) {
            $already_liked_disliked_users = UserLikeDislikeHistory::where('like_from_user', $user_id)->get(['like_to_user'])->pluck('like_to_user');
            $users = User::whereNot('id', $user_id)->whereNotIn('id', $already_liked_disliked_users);
        }

        
        # filter user by age rage
        if($request->age_range) { // age_range = [25-40]
            $users->whereBetween('age', $request->age_range);
        } else if($request->location) {
            $users->where('location', 'like', $request->location);
        } 
        
        $users = $users->paginate(10);

        return UserResource::collection($users);
    }


    public function userLikeDisLike(LikeDislikeRequest $request) { // swipe left/right & like/dislike
        $user_id = auth('api')->user()->id;

        $like_dislike = UserLikeDislikeHistory::where('like_from_user', $user_id)
                        ->where('like_to_user', $request->liked_user_id)
                        ->first();

        if(!$like_dislike) { // if already liked or disliked 
            $like_dislike = new UserLikeDislikeHistory();
            $like_dislike->like_from_user = $user_id;
            $like_dislike->like_to_user = $request->liked_user_id;
            $like_dislike->status = $request->status; // 1=like, 0=dislike
        } else {
            $like_dislike->status = (int)!$like_dislike->status; // if already like and send 1(like) then do dislike same for status 0
        }
        $like_dislike->save();
        $msg = 'disliked successfully';
        
        if($like_dislike->status == 1) {
            $msg = 'liked successfully';
            $user = User::find($like_dislike->like_to_user);
            $user->update([
                'mail_like_counter' => ($user->mail_like_counter >= 50 ? 0 : $user->mail_like_counter+1)
            ]);
        }
        return $this->sendResponse(['message' => $msg]);
    }

    public function likedList() { // list of liked users whom i like
        $user_id = auth('api')->user()->id;
        
        $users = UserLikeDislikeHistory::with('toUserDetail:id,name,picture')
                    ->where('like_from_user', $user_id)
                    ->where('status', 1)
                    ->get();

        return $this->sendResponse($users);
    }

    public function likeDislikeList($type) { // list of users who like/dislike me
        //$type 1 to get like list  & 0 for dislike list 
        $user_id = auth('api')->user()->id;
        
        $liked_disliked_users = UserLikeDislikeHistory::where('like_to_user', $user_id)
                ->where('status', ($type == 1 ? 1 : 0))
                ->get()
                ->pluck('like_from_user');
        
        $users = User::whereIn('id', $liked_disliked_users)->paginate(10);

        return UserResource::collection($users);
    }
}
