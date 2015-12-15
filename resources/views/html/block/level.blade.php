@foreach ($level as $key => $value)
    @if($key%3==1) 
        <?php $color = 'colored-success';?>
    @elseif($key%3==2) 
        <?php $color = 'colored-danger';?> 
    @else 
        <?php $color = 'colored-primary';?>
    @endif
<div class="radio">
    <label>
        <input value="{{$value->id}}" @if((isset($user)) && $user->level_id==$value->id){{'checked=checked'}}@endif name="rdbLevel" type="radio" class="{{$color}} level">
        <span class="text">{{$value->name}}</span>
    </label>
</div>
@endforeach