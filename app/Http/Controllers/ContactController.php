<?php

namespace App\Http\Controllers;
use App\Models\Feedbacks;
use App\Models\Message;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getTopicList(Request $request) {
        $topicList = Topic::all();
        return response()->json([
            'data' => [
                'list' => $topicList,
            ],
            'code' => SUCCESS_CODE,
            'message' => SUCCESS_MESSAGE
        ]);
    }

    public function getMessageList(Request $request) {
        $id = Auth::user()->id;
        $topic = $request->topic;
        $messageList = Message::where('topic', '=', $topic)->where(function($query) use ($id) {
            $query->where('created_by', '=', $id)->orWhere('to', '=', $id);
        })->get();
        return response()->json([
            'data' => [
                'list' => $messageList,
            ],
            'code' => SUCCESS_CODE,
            'message' => SUCCESS_MESSAGE
        ]);
    }

    public function createMessage(Request $request) {
        $id = Auth::user()->id;
        $to = $request['to'];
        $content = $request['content'];
        $topic = $request['topic'];
        $message = new Message();

        $message->to = $to;
        $message->content = $content;
        $message->created_by = $id;
        $message->topic = $topic;
        $message->save();

        return response()->json([
            'code' => SUCCESS_CODE,
            'message' => SUCCESS_MESSAGE
        ]);
    }

    public function createFeedback(Request $request) {
        $id = Auth::user()->id;
        $topic = $request['topic'];
        $content = $request['content'];
        $feeling_status = $request['feeling_status'];
        $feedback = new Feedbacks();

        $feedback->content = $content;
        $feedback->feeling_status = $feeling_status;
        $feedback->topic = $topic;
        $feedback->created_by = $id;
        $feedback->save();

        return response()->json([
            'code' => SUCCESS_CODE,
            'message' => SUCCESS_FEEDBACK_CREATE,
        ]);
    }
}
