@extends('layouts.master')
<style>
    #duration{
        width:240px
    }
</style>
@section('content')
 
@if(Session::has('success_message'))
            <div style="text-align: center" class="uk-alert uk-alert-success" data-uk-alert="">
                {{ Session::get('success_message') }}
            </div>
 @endif
  @if(Session::has('error_message'))
  
            <div style="text-align: center" class="uk-alert uk-alert-danger" data-uk-alert="">
                {{ Session::get('error_message') }}
            </div>
 @endif
   

<!-- if there are login errors, show them here -->
     @if (count($errors) > 0)

    <div class="uk-form-row">
        <div class="alert alert-danger" style="background-color: red;color: white">

              <ul>
                @foreach ($errors->all() as $error)
                  <li> {{  $error  }} </li>
                @endforeach
          </ul>
    </div>
  </div>
@endif
 
 <center><h3 class="heading_a">Leave Request</h3></center>
 <p>&nbsp;</p>
	 <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row" style=""  >
                               <label> Select Employee</label>
                                         <p></p>
                                            {!! Form::select('employee', 
                                     (['' => 'Select Employee Type'] +$employee ), 
                                         null, 
                                         ['required'=>'','class' => 'md-input' ] )  !!}

                            </div>
                   
                             
                             
                            <div class="uk-form-row">
                                <label>Duration (Days)</label>
                                <p></p>
                                   {!!  Form::select('duration', array('100' => '100', '95' => '95','90'=>'90','85'=>'85','80'=>'80','75'=>'75','70'=>'70','65'=>'65','60'=>'60','55'=>'55','50'=>'50','45'=>'45','40'=>'40','35'=>'35','30'=>'30','25'=>'25','20'=>'20','15'=>'15','10'=>'10','5'=>'5'), null, ['placeholder' => '' ,'id'=>"duration" ,'required'=>'']); !!} 
                  
                            </div>
                             <div class="uk-form-row">
                                <label>Start Date</label>
                                <input type="text" required="" data-uk-datepicker="{format:'DD-MM-YYYY'}" value="{{ old("start") }}" name="start"   class="md-input">
                      
                             </div>
                                
                              
                             </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Leave Type</label>
                                         <p></p>
                                             {!! Form::select('type', 
                                (['' => 'Select Account ']+$type ), 
                                    null, 
                                    ['required'=>'','class' => 'md-input type','id'=>"selec_adv_2"] )  !!}
                           

                            </div>
                            
                              <div class="uk-form-row"   >
                                <label>Reasons of Leave</label>
                                <input type="text" required=""  class="md-input md-input" name="reasons" value="{{ old('reasons') }}"   />
                                
                            </div>
                            <div class="uk-form-row">
                                <label>Reporting Date</label>
                                <input type="text" required=""  value="{{ old("end") }}" name="end"   class="md-input">
                      
                             </div>
                              
                             
                        </div>
                             
                        </div>
                    
                     
              

                 <div class="uk-grid" align='center'>
                            <div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary"><i class="fa fa-save" ></i>Save</button>
                            </div>
                </div>
                    <p>&nbsp;</p>
        </form>
 
 
 
 
 
 

@endsection

@section('scripts')

<script type="text/javascript">
      
$(document).ready(function(){
// console.log($('select[name="status"]'));
$(".type").on('change',function(e){
 
   $("#group").submit();
 
});
});

</script>  
@endsection
