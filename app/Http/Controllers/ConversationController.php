<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repository\ConversationRepository;
use Illuminate\Auth\AuthManager;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     /**
      * @var r
      */

      private $r;


     public function __construct(ConversationRepository $repository, AuthManager $auth){
        $this->r = $repository;
        $this->auth = $auth;
     }


    public function index()
    {
        return view('conversations/index', ['users' => $this->r->getConversations(Auth::user()->id),
        'unread' => $this->r->unreadcount($this->auth->user()->id)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, StoreMessageRequest $request)
    {
        $this->r->createMessage(
            $request->get('content'),
            $this->auth->user()->id,
            $user->id
        );

        return redirect(route('conversations.show', ['user' => $user->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $unread = $this->r->unreadcount($this->auth->user()->id);

        if(isset($unread[$user->id])){

            $this->r->readAllFrom($user->id, $this->auth->user()->id);
           unset($unread[$user->id]);
        }




        return view('conversations/show', 
        ['users' => $this->r->getConversations(Auth::user()->id),
    'user' => $user,
    
    'messages' => $this->r->getMessagesFor($this->auth->user()->id, $user->id)->paginate(3),
    'unread' => $this->r->unreadcount($this->auth->user()->id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
