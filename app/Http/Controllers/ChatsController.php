<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Post;
use App\Models\Chat;
use App\Models\Comment;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\NewMessage;
use App\Events\NewNotification;
use Illuminate\Support\Facades\Log;

class ChatsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $users = User::whereNotIn('id',[auth()->user()->id])->paginate(10);
        return view('chats.index',compact('users'));
    }
    public function show($id)
    {
        $chat = Chat::where('user_1',auth()->user()->id)->where('user_2',$id)->first();
        if($chat==null)
        $chat = Chat::where('user_2',auth()->user()->id)->where('user_1',$id)->first();
        if($chat==null)
        $chat = Chat::create(['user_1'=>auth()->user()->id,'user_2'=>$id]);
        $user  = User::findOrFail($id);
        $users = User::whereNotIn('id',[auth()->user()->id])->paginate(10);
        return view('chats.show',compact('user','users','chat'));
    }


    public function messageStore(Request $request)
    {

        $data = [
            'sender' => $request->user_id,
            'body' => $request->body??"",
            'chat_id' => $request->chat_id,


        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads', $filename, 'public'); // Adjust storage location as needed

            $data['file'] = $filename;
        }

        $comment = Message::create($data);
        $dataEvent = [
            'id'=>$comment->id,
            'sender' => $request->user_id,
            'body' => $request->body??"",
            'chat_id' => $request->chat_id,
            'file' => $comment->file,


        ];
        event(new NewMessage($dataEvent));

        return response()->json(['success' => 'add successful']);
    }
    public function markAsReceived(Request $request, $messageId)
    {
        $message = Message::findOrFail($messageId);

        if (!$message->received_at) {
            $message->update(['received_at' => now()]);
        }


        return response()->json(['success' => 'message marked as received']);
    }

}
