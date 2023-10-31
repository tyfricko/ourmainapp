<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function createFollow(User $user) {
        // You cannot follow yourself
        if ($user->id == auth()->user()->id) {
            return back()->with('failure', 'You cannot follow yourself!');
        }
        // you cannotn follow you are alreday following
        $existCheck = Follow::where([['user_id', '=', auth()->user()->id],['followeduser', '=', $user->id]])->count();

        if ($existCheck){
            return back()->with('failure', 'You are alredy following that user!');
        }

        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        return back()->with('success', 'User soucessfully followed.');
    }

    public function removeFollow(User $user) {
        Follow::where([['user_id', '=', auth()->user()->id],['followeduser', '=', $user->id]])->delete();
        return back()->with('success', 'User soucefully unfollowed.');
    }
}
