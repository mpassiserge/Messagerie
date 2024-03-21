<?php

namespace App\Repository;

use App\Models\User;
use App\Models\messagerie;
use Illuminate\Database\Eloquent\Builder;



class ConversationRepository{
    /**
     * @var user
     */
    private $user;

    public function __construct(User $user, messagerie $message )
    {

        $this->user = $user;
        $this->message = $message;

    }

    public function getConversations(int $userId) {

    return $this->user->newQuery()
   ->select('name', 'id')
   ->where('id', '!=', $userId)
   ->get();

    }

    public function createMessage(string $content, int $from, int $to) {
       return  $this->message->newQuery()->create([
            'content' => $content,
            'from_id' => $from,
            'to_id' => $to,
            'create_at' => now()
        ]);
    }

    public function getMessagesFor(int $from, int $to): builder
    {
        return $this->message->newQuery()->whereRaw("((from_id = $from AND to_id = $to) OR (from_id = $to AND to_id = $from))")
        ->orderby('created_at', 'DESC');

    }
    public function unreadcount(int $userId) {
        return $this->message->newQuery()
        ->where('to_id', $userId)
        ->groupBy('from_id')
        ->selectRaw('from_id ,COUNT(id) as count')
        ->whereRaw('read_at IS NULL')
        ->get()
        ->pluck('count','from_id');
    }


    public function readAllFrom(int $from, int $to){
        return $this->message->newQuery()
        ->where('from_id', $from)
        ->where('to_id', $to)
        ->update(['read_at' => now()]);
    }

}







?>
