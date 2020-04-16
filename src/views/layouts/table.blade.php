<?php
$columns = isset($columns) ? $columns : [];
$datas = isset($datas) ? $datas : [];
$table_id = rand();
$options['search'] = isset($options['search']) ? $options['search'] : 'true';
$options['dom'] = isset($options['dom']) ? $options['dom'] : 'frtip';
$options['pagination'] = isset($options['pagination']) ? $options['pagination'] : 'true';
$options['order'] = isset($options['order']) ? $options['order'] : 'true';
$options['length'] = isset($options['length']) ? $options['length'] : 'false';
$options['filter'] = isset($options['filter']) ? $options['filter'] : 'true';
$options['rowPerPage'] = isset($options['rowPerPage']) ? $options['rowPerPage'] : '10';
$options['other'] = isset($options['other']) ? json_decode($options['other']) : null;
$options['function'] = isset($options['function']) ? $options['function'] : "false";
?>
@push('head')
    <!-- Data Table-->
    <link rel="stylesheet" href="{{asset('ap/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
@endpush
<table id="table{{$table_id}}" class="table table-hover no-wrap" data-page-size="10">
    <thead>
    <tr>
        @foreach($columns as $column)
            <th>{{__($column)}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($datas as $data)
        <tr>
            @foreach($data as $filed)
                <td {{is_numeric($filed)?"data-order='$filed'":""}}>{{is_numeric($filed)?number_format($filed):$filed}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
@push('script')
    <!-- This is data table -->
    <script src="{{asset('ap/plugins/datatables-bs4/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('ap/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script>
        if (typeof option == 'undefined')
            option = {};
        if (typeof serverSide == 'undefined')
            serverSide = {};
        serverSide['{{$table_id}}'] = Boolean(parseInt('{{ isset($url) ? "1" : "0" }}'));
        option['{{$table_id}}'] = {
            pageLength: '{{$options['rowPerPage']}}',
            dom: '{{$options['dom']}}',
            ordering: '{{$options['order']}}',
            bPaginate: '{{$options['pagination']}}',
            bLengthChange: '{{$options['length']}}',
            bFilter: '{{$options['filter']}}',
            serverSide: serverSide['{{$table_id}}'],
            processing: true,
            /*responsive: {
                details: {
                    renderer: function (api, rowIdx, columns) {
                        let data = $.map(columns, function (col, i) {
                            return col.hidden ?
                                '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">'
                                + '<td>' + col.title + ':' + '</td>'
                                + '<td>' + col.data + '</td>'
                                + '</tr>' :
                                '';
                        }).join('');
                        return data ? $('<table/>').append(data) : false;
                    }
                }
            },*/
            language: {
                {{--url: '/language/data-table/{{Lang::locale()}}.json',--}}
                "decimal": ".",
                "thousands": ","
            }
        };
        if (serverSide['{{$table_id}}'])
            option['{{$table_id}}'].ajax = {
                url: '{{$url??''}}',
                type: 'POST'
            };
        option[
            '{{$table_id}}'] = $.extend(true, option['{{$table_id}}'], JSON.parse('@json($options['other'])'));
        if (typeof table == 'undefined')
            table = {};
        table['{{$table_id}}'] = $("#table{{$table_id}}").DataTable(option['{{$table_id}}']);

        @if($options["function"] != "false")
        $("#table{{$table_id}}").addClass('hover');
        $('#table{{$table_id}}').on('click', 'td', function () {
            let data = table['{{$table_id}}'].row(this).data();
            {{$options['function'] }}
        });
        @endif
        $('#table{{$table_id}}').on('draw.dt', function () {
        });

        $('#searchBtn{{$table_id}}').on('click', function () {
            let search = $('#searchTxt{{$table_id}}').val();
            if (search != '')
                $('#table{{$table_id}}').DataTable().search(search).draw();
        });

        $.fn.dataTable.ext.errMode = 'none';
        setTimeout(e => {

        }, 5000)

    </script>
@endpush
