<!DOCTYPE html>
<html lang="en">
<head>
    <title>database MySQL Tool</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTheme/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminTheme/app-assets/css/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('adminTheme/app-assets/css/bootstrap-extended.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('adminTheme/app-assets/css/colors.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('adminTheme/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('adminTheme/app-assets/css/components.css') }}">
    <script src="{{ asset('adminTheme/app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('adminTheme/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('adminTheme/app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('adminTheme/app-assets/js/scripts/components.js') }}"></script>
    <script src="{{ asset('adminTheme/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('adminTheme/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <style type="text/css">
        .text-database{
            color: #2D44AC;
        }
        .dataTables_filter{
            /*text-align: right;*/
        }
        #wrapper {
            padding-left: 0;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }
        #wrapper.toggled {
            padding-left: 250px;
        }
        #sidebar-wrapper {
            z-index: 1000;
            position: fixed;
            left: 250px;
            width: 0;
            height: 100%;
            margin-left: -250px;
            overflow-y: auto;
            background: #fff;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }
        #wrapper.toggled #sidebar-wrapper {
            width: 250px;
        }
        #page-content-wrapper {
            width: 100%;
            position: absolute;
            padding: 15px;
        }
        #wrapper.toggled #page-content-wrapper {
            position: absolute;
            margin-right: -250px;
        }
        /* Sidebar Styles */
        .sidebar-nav {
            position: absolute;
            top: 0;
            width: 305px;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .sidebar-nav li {
            text-indent: 5px;
            padding-bottom: 2px;
        }
        .sidebar-nav li a {
            display: block;
            text-decoration: none;
            color: #2D44AC;
        }
        .sidebar-nav li a span:hover {
            text-decoration: none;
            color: red;
            background: rgba(255,255,255,0.2);
        }
        .sidebar-nav li a:active,
        .sidebar-nav li a:focus {
            text-decoration: none;
        }
        .sidebar-nav > .sidebar-brand {
            font-size: 25px;
            line-height: 40px;
            text-align: center;
        }
        .sidebar-nav > .sidebar-brand a {
            color: red;
            position: relative;
            top: 10px;
        }
        .sidebar-nav > .sidebar-brand a:hover {
            color: red;
            background: none;
        }
        .column-list{
            padding-left: 30px;
        }
        .column-list li{
            list-style-type: none;
            font-size: 12px;
        }
        .text-red{
            color: red;
        }
        .text-database{
            color: #2D44AC;
        }
        @media(min-width:768px) {
            #wrapper {
                padding-left: 330px;
            }
            #wrapper.toggled {
                padding-left: 0;
            }
            #sidebar-wrapper {
                width: 325px;
            }
            #wrapper.toggled #sidebar-wrapper {
                width: 0;
            }
            #page-content-wrapper {
                padding: 20px;
                position: relative;
            }
            #wrapper.toggled #page-content-wrapper {
                position: relative;
                margin-right: 0;
            }
            .main-content{
                padding: 10px;
            }
            .display-none{
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid" id="wrapper">
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        <strong>database</strong>
                    </a>
                </li>
                <hr>
                @php 
                    $tableNameInDBName = 'Tables_in_'.env('DB_DATABASE');
                    $tablesList = DB::select('SHOW TABLES');
                @endphp
                @foreach ($tablesList as $key => $value)
                    <li>
                        <a href="#"><span class="column-list-open"><i class="fa fa-plus"></i></span> <span class="table-name">{{$value->$tableNameInDBName}}</span> <span class="select-query-span" table-name="{{$value->$tableNameInDBName}}">select</span></a>
                        <ul class="column-list display-none">
                            @php
                                $columnList = \Schema::getColumnListing($value->$tableNameInDBName);
                            @endphp
                            @foreach($columnList as $column)
                                <li>{{$column}}</li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="row main-content">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <h2 style="margin-top:0px;"><span class="text-database">C</span>elcius <span class="text-database">M</span>ySQL <span class="text-database">T</span>ool</h2>
                        <p>The form below contains a textarea for query:</p>
                    </div>
                    <div class="col-md-4">
                        <div class="graph pull-right">
                            <a href="{{ route('emt.mySqlStatistics') }}" class="btn btn-primary">MYSQL Statistics</a>
                        </div>
                    </div>
                </div>
                <form method="post" action="{{route('emt.run')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="comment">Query:</label>
                        <textarea class="form-control" name="qry" required="required" rows="5" id="comment">{{ old('qry') }}</textarea>
                        <span class="text-danger">
                            @if(\Session::has('error'))
                                {{\Session::get('error')}}
                                @php \Session::forget('error') @endphp
                            @endif
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="comment">Format:</label>
                        <select class="form-control" name="format" id="format">
                            <option value="">Select Format</option>
                            <option value="Array">Array</option>
                            <option value="Json">Json</option>
                        </select>      
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" value="SUBMIT" class="btn btn-success">Execute</button>
                        <button type="submit" name="submit" value="DOWNLOAD" class="btn btn-info">Download CSV</button>
                        <button type="submit" name="submit" value="DOWNLOADSQL" class="btn btn-primary">Download SQL</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" style="margin-top:10px;">
            <div class="col-md-8">
                <h2 class="text-database" style="margin-top:0px;"><span class="text-database">C</span>elcius <span class="text-database">M</span>ySQL <span class="text-database">T</span>ool</h2>
            </div>
            <div class="col-md-4">
                <div class="graph pull-right">
                    <a href="{{route('emt.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <form method="post" action="{{route('emt.run')}}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="comment">Result:</label>
                @if($type!='select'|| ($format == 'Array' || $format == 'Json'))
                    <?php
                        echo '<pre>';
                        print_r($data);
                    ?>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            @if(!empty($data) && count($data) > 0)
                            <div class="">
                                @php
                                    $columnArray = (array) json_decode(json_encode($data[0]));
                                    $columnList = array_keys($columnArray);
                                    $columnList = array_combine($columnList, $columnList);
                                @endphp
                                <form class="search-filter-form" name="search_filter">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::select('where[0][col]',$columnList,null,['class'=>'form-control','id'=>'column-name']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <select name="where[0][op]" class="form-control" id="op">
                                                    <option>=</option>
                                                    <option>&lt;</option>
                                                    <option>&gt;</option>
                                                    <option>&lt;=</option>
                                                    <option>&gt;=</option>
                                                    <option>!=</option>
                                                    <option>LIKE</option>
                                                    <option>LIKE %%</option>
                                                    <option>IN</option>
                                                    <option>IS NULL</option>
                                                    <option>NOT LIKE</option>
                                                    <option>NOT IN</option>
                                                    <option>IS NOT NULL</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {!! Form::text('where[0][op]',null,array('class'=>'form-control','id'=>'search-value')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <button class="btn btn-info custom-search-button">Search</button>
                                                <button class="btn btn-danger search-reset-button">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <table id="datatables" class="table table-striped table-no-bordered table-hover">
                                    <thead>
                                        <tr>
                                            @foreach($data[0] as $key => $value)
                                                <th>{{$key}}</th>
                                            @endforeach
                                            <!-- <th>Actions</th> -->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            @foreach($data[0] as $key => $value)
                                                <th>{{$key}}</th>
                                            @endforeach
                                            <!-- <th>Actions</th> -->
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @else
                                <h2>No Records Found !!</h2>
                            @endif
                        </div>
                    </div>
                  @endif
            </div>
            <div class="form-group">
              <a href="{{route('emt.index')}}" class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>
</body>
<script type="text/javascript">
    @if(($format != 'Array' && $format != 'Json') && (!empty($data) && is_array($data) && count($data) > 0))
    $(document).ready(function() {
        var columnList = <?php echo json_encode($data[0]); ?>;
        var qry = '<?php echo $qry; ?>';
        aoColumns = [];
        $.each(columnList,function(key,value){
            var column = { 
               data: key,
               name: key,
            };
            aoColumns.push(column);
        });
        $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, 1000], [10, 25, 50, 1000]],
            "order": [[ 0, "desc" ]],
            orderable:true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('adminEmtListTables', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('adminEmtListTables'));
            },
            ajax: {
                url: "{{ route('emt.getQueryData') }}",
                data: function(d) {
                    d.qry = qry;
                    d.column = $("#column-name").val();
                    d.op = $("#op").val();
                    d.value = $("#search-value").val();
                }
            },
            "columns": aoColumns
        });
        $('.search-reset-button').click(function(e){
            e.preventDefault();
            $("#search-value").val('');
            $('#datatables').DataTable().draw(true);
        });
        $('.custom-search-button').click(function(e){
            e.preventDefault();
            $('#datatables').DataTable().draw(true);
        });
    })
    @endif
    $("body").on('click','.table-name',function(e) {
        e.preventDefault();
        query = $('#comment').val();
        tableName = $(this).text();
        query = query+tableName;
        $('#comment').val(query);

    });
    $("body").on('click','.column-list-open',function(e) {
        var columnSpan = $(this).parent().parent();
        columnSpan.find('.column-list').toggle();
    });
    $("body").on('click','.select-query-span',function(e) {
        var tableName = $(this).attr('table-name');
        query = 'select * from '+tableName;
        $('#comment').val(query);
    });
</script>
</html>
