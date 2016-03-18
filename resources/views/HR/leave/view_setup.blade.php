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
 
 <h5>Leave Setups</h5>  
   
 
 
	<div class="uk-overflow-container">
            
            <table   class="uk-table" cellspacing="0" id="thegrid">
                <thead>

                </thead>
                <tbody>

                </tbody>
            </table>

            
                             
        </div>
 
@endsection
@section('scripts')
<script src="{!! url('public/datatables/jquery.dataTables.min.js') !!}"></script>
 
<script src="{!! url('public/datatables/plugins_datatables.min.js') !!}"></script>
 <script src="{!! url('public/datatables/datatables_uikit.min.js') !!}"></script> 

<script type="text/javascript">
        var theGrid = null;
        $(document).ready(function(){
            theGrid = $('#thegrid').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": true,
                "responsive": true,
                // "scrollY": 200,
                // "scrollX": true,
                "paging": true,
                "processing": true,
                "ajax":{
                    "url": "{{  url('/view_leave_setup/search') }}",
                    "type": "POST"
                    },
                 "columns": [
    {"data":"thecounter","searchable": false,"orderable": false,"title":"#","width":"10px"},
                @foreach($data as $header)                
                { "data" : "{!! $header->Field !!}" ,"searchable" : {{ json_encode($header->searchable) }}, "orderable" : {{ json_encode($header->orderable) }}, "title" : "{{ $header->title }}" , "visible" : {{ json_encode($header->visible) }}  },
                @endforeach
                {"data":"button_actions","title":"Actions","searchable":false,"orderable":false},
                // {"title":"Edit","searchable":false,"orderable":false},
                          ],
         

            });
         //this listens to the order and search events which are triggered when the table is searched or ordered
    //     theGrid.on( 'order.dt search.dt', function () {
    //     theGrid.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
    //         cell.innerHTML = i+theGrid.page.info().start+1;

    //     } );
    // } ).draw();

        });
        function doDelete(id) {
            if(confirm('You really want to delete this record?')) {
               $.ajax('{{url('[[route_path]]/delete')}}/'+id).success(function() {
                theGrid.ajax.reload();
               });

            }
            return false;
        }
    </script>
@endsection

