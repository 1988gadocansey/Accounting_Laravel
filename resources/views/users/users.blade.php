@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! url('public/assets/css/bootstrap.min.css') !!}" media="all">

@endsection
@section('content')
        @if(Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
         @endif
          @if(Session::has('error_message'))
            <div class="alert alert-danger">
                {{ Session::get('error_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No User found!</p>
      <a href="{{ url('users') }}">Back</a>
    </div>
@else
 <h5>Users</h5>  
   
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('users')  !!}"  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('role', 
                                (['' => 'Select roles'] + $roles), 
                                  old("role",""),
                                    ['class' => 'md-input parent','id'=>"parent", 'data-md-selectize'=>''] )  !!}
                         </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('status', 
                                (['' => 'Select Account  Status'] + $status), 
                                  old("status",""),
                                    ['class' => 'md-input parent','id'=>"parent", 'data-md-selectize'=>''] )  !!}
                         </div>
                        </div>
                         
                         

                        
                         
                         
                         
                    
                    </div>
                </form> 
                    
                </div>
            </div>
 
	<div class="uk-overflow-container">
            
                        <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                           <th class=" ">No</th>
                                           <th class=" ">Username</th>
                                           <th class=" ">Email</th>
                                           <th class=" ">Roles</th>         
                                           <th class=" ">Status</th>
                                           <th class=" ">Date Added</th>
                                           <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="selects">
                                        
                                        @foreach($data as $datas=> $item) 
                                       
                                        <tr align="">
                                            <td>   {!! $datas+1 !!} </td>
                                             
                                            <td> {{ $item->USERNAME }}</td>
                                            <td> {{ @$item->EMAIL }}</td>
                                            <td> {{ @$item->ROLE_ID }}</td>
                                            <td> {{$item->STATUS }}</td>
                                            <td>{{ $item->CREATED_AT }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a  db_id ='{{ $item->ID }}' href=""  role="button" data-toggle="modal" class="btn btn-default btn-sm" title="Assign Permission"><i class="fa fa-lock" title="assign permission"></i></a>
                                                        <a db_id='{{ $item->ID }}' href="#delete" class="btn btn-default btn-sm btn_delete" title="Delete"><i class="fa fa-trash"></i></a>
                                                 </div>
                                                    
                                            </td>
                                              
                                        </tr>
                                         @endforeach
                                    </tbody>
                             </table>
            
                             {!! $data->appends(old())->render() !!}
                             
        </div>
 @endif
@endsection
@section('scripts')


<script type="text/javascript">
      
$(document).ready(function(){
// console.log($('select[name="status"]'));
$(".parent").on('change',function(e){
 
   $("#group").submit();
 
});
});
 
</script>
 

<!--Delete enrty script-->
<!--Delete enrty script-->
<script>
$(document).ready(function (){
$('.btn_delete').on('click', function(e) {
        e.preventDefault();
        //var ok=confirm("Are you sure you want to delete this user??");        
        var url = 'users/delete';
        var data = $(this).attr('db_id');
UIkit.modal.confirm("Are you sure you want to delete this user??"
               , function(){
        modal = UIkit.modal.blockUI("<div class='uk-text-center'>Deleting User<br/><img class='uk-thumbnail uk-margin-top' src='{!! url('public/assets/img/spinners/spinner.gif')  !!}' /></div>"); 
        //setTimeout(function(){ modal.hide() }, 500) })()            
        $.ajax({
        url: url,
        type:"POST",
        data:'id='+data
        }).done(function(data){
           modal.hide();
           console.log(data);
           location.reload();
//        return (function(modal){ modal = UIkit.modal.blockUI("<div class='uk-text-center'>Processing Transcript Order<br/><img class='uk-thumbnail uk-margin-top' src='{!! url('public/assets/img/spinners/spinner.gif')  !!}' /></div>"); setTimeout(function(){ modal.hide() }, 500) })();
        });
               
    
                    
    }
                       );
   
        
   

   
 
});
     
 
});    
</script>
@endsection
