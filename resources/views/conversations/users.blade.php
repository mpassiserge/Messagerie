<div class="col-md-3" >

    <div class="list-group" >
    
    
     @foreach($users as $user)
     
      
       
        
       <a href="{{ route('conversations.show', $user->id) }}" style="background-image: url('../img/Economic.jpg')" class="list-group-item d-flex justify-content-between align-items-center">{{$user->name}}
    
    @if(isset($unread[$user->id]))
    
    <span class="badge badge-pill badge-primary">{{ $unread[$user->id]}}</span>
    @endif
    </a> 
         
    @endforeach
    
    </div>
    
    </div>