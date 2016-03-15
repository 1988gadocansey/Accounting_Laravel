@extends('layouts.master')

@section('content')
@if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <h1>Gengen <a href="{{ url('gengen/create') }}" class="btn btn-primary pull-right btn-sm">Add New Gengen</a></h1>
    <div class="table">

        <table class="table table-bordered table-striped table-hover" id="thegrid">
            <thead>
                <tr>

                    @foreach ($table_headers as $header)
                    @if(strtolower($header)!='id')
                    <th>{{ ucfirst($header) }}</th>
                    @endif
                    @endforeach
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
            @if(!empty($results))
            {{-- */$x=0;/* --}}

            @foreach($results as $result)
            <tr>
            @foreach($result as $key=>$value)

                <td>{{ $value }}</td>

            @endforeach
            </tr>
            @endforeach
            @endif
            </tbody>
        </table>

    </div>

@endsection

@section('javascript')
<script src="{!! url('public/libs/jquery/datatables/media/js/jquery.dataTables.min.js') !!}"></script>
<script src="{!! url('public/libs/jquery/plugins/integration/bootstrap/3/dataTables.bootstrap.js') !!}"></script>
 <link rel="stylesheet" href="{!! url('public/libs/jquery/plugins/integration/bootstrap/3/dataTables.bootstrap.css') !!}" type="text/css" />


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
                    "url": "{{url('gengen/search') }}",
                    "type": "POST"
                    },
         "columnDefs": [ {
              "searchable": false,
                "orderable": false,
                "targets": [0],
                "title":"#"
                },
            //     {
            //   "searchable": false,
            //     "orderable": false,
            //     "targets": [-1],
            //     "title":"View"
            // }
            //     ,
            //     {
            //   "searchable": false,
            //     "orderable": false,
            //     "targets": [-2],
            //     "title":"Edit"
            // },
            //     {
            //   "searchable": false,
            //     "orderable": false,
            //     "targets": [-3],
            //     "title":"Delete"
            // }
            ],
                "columns": [
                @foreach($table_headers as $header)
                @if(!in_array(strtolower($header),array('id')))

                { "data" : "{{ $header }}"    },
                @endif
                @endforeach
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