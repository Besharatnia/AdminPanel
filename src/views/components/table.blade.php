<?php
$search = $search ?? 'true';
$filter = $filter ?? 'true';
$dom = $dom ?? 'Bfrtip';
$options['pagination'] = isset($options['pagination']) ? $options['pagination'] : 'true';
$order = $order ?? 'true';
$options['length'] = isset($options['length']) ? $options['length'] : 'false';
$rowPerPage = $rowPerPage ?? '100';
$table_id = $table_id ?? rand(1, 100000);
?>
@stack('script')
@push('head')
    <style>
        @if($search=="false")
        .dataTables_filter, .dataTables_info {
            display: none;
        }
        @endif
    </style>
    <!-- Data Table-->
    <link rel="stylesheet" href="{{asset('ap/plugins/datatables-bs4/css/jquery.dataTables.css?v=1')}}">
    <link rel="stylesheet" href="{{asset('ap/plugins/datatables-bs4/css/dataTables.bootstrap4.css?v=1.0')}}">
    <link rel="stylesheet" href="{{asset('ap/plugins/datatables-bs4/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('ap/plugins/datatables-bs4/css/fixedColumns.dataTables.min.css')}}">
@endpush
@if($edit_all??false)
    <button type="button"
            data-parent=2
            class="btn btn-circle btn-kowsar btn-edit-row btn-xs margin-l-5">
        <i
            class="fal fa-pencil"></i></button>
@endif
<table id="table{{$table_id}}" class="table table-hover compact wrap {{@$style}}" data-page-size="10">
    <thead>
    <tr>
        {{ $header }}
    </tr>
    </thead>
    <tbody>
    {{$datas}}
    </tbody>
</table>
@push('after_content')
    @component('ap.components.modal' , ['id'=>'edit_modal'.$table_id,'type'=>'','title'=>'ویرایش ردیف'])
        @slot('body')

        @endslot
    @endcomponent
@endpush
@push('script')
    <!-- This is data table -->
    <script src="{{asset('ap/plugins/datatables-bs4/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('ap/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('ap/plugins/datatables-bs4/js/dataTables.fixedColumns.min.js')}}"></script>
    <script src="{{asset('ap/plugins/datatables-bs4/js/dataTables.responsive.min.js')}}"></script>
    @if(@$excel)
        <script src="{{asset('ap/plugins/datatables-bs4/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('ap/plugins/datatables-bs4/js/jszip.min.js')}}"></script>
        <script src="{{asset('ap/plugins/datatables-bs4/js/buttons.html5.min.js')}}"></script>
    @endif
    @if(@$pdf)
        <script src="{{asset('ap/plugins/datatables-bs4/js/pdfmake.min.js')}}"></script>
        <script src="{{asset('ap/plugins/datatables-bs4/js/vfs_fonts.js')}}"></script>
        <script src="{{asset('ap/plugins/datatables-bs4/js/buttons.html5.min.js')}}"></script>
    @endif
    @component('ap.components.sweet_alert')
    @endcomponent
    <script>
        var disableClick = false;
        if (typeof option == 'undefined')
            option = {};
        if (typeof serverSide == 'undefined')
            serverSide = {};
        serverSide['{{$table_id}}'] = Boolean(parseInt('{{ isset($url) ? "1" : "0" }}'));
        option['{{$table_id}}'] = {
            pageLength: '{{@$rowPerPage}}',
            dom: '{{@$dom}}',
            ordering: {{$order}},
            paging: '{{$options['pagination']}}',
            bLengthChange: '{{$options['length']}}',
            bFilter: '{{$filter}}',
            serverSide: serverSide['{{$table_id}}'],
            processing: serverSide['{{$table_id}}'],
            @if($first_hidden??false)
            "columnDefs": [
                {"visible": false, "targets": 0}
            ],
            @endif
            "fnDrawCallback": function () {
                if ($("#table{{$table_id}}" + '_paginate .pagination li').length > 3) {
                    $("#table{{$table_id}}_paginate").css('opacity', 1);
                } else {
                    $("#table{{$table_id}}_paginate").css('opacity', 0);
                }
            },
            buttons: [
                    @if(@$excel)
                {
                    "extend": "excel", "text": "<i class='text-success fal fa-file-excel'></i>"
                },
                    @endif
                    @if(@$pdf)
                {
                    "extend": "pdf", "text": "<i class='text-success fal fa-file-pdf'></i>"
                },
                @endif
            ],
            @if(@$fixed)
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                rightColumns: 0,
                leftColumns: 1
            },
            @endif
            order: {!! json_encode($sort??[]) !!},
            language: {
                "lengthMenu": "نمایش _MENU_ ردیف در صفحه",
                "zeroRecords": "چیزی یافت نشد",
                "info": "نمایش صفحه _PAGE_ از _PAGES_",
                "infoEmpty": "چیزی یافت نشد",
                "infoFiltered": "(فیلتر از _MAX_ کل records)",
                "loadingRecords": "در حال بارگزاری...",
                "processing": "در حال دریافت ...",
                "search": "جستجو:",
                "paginate": {
                    "first": "اولین",
                    "last": "آخرین",
                    "next": "بعدی",
                    "previous": "قبلی"
                },
                "decimal": ".",
                "thousands": ","
            }
        };
        if (serverSide['{{$table_id}}'])
            option['{{$table_id}}'].ajax = {
                url: '{{$url??''}}',
                type: 'POST',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
                }
            };
        if (typeof table == 'undefined')
            table = {};
        if ("{{$filter}}" != "false") {
            $('#table{{$table_id}} thead tr').clone(true).appendTo('#table{{$table_id}} thead');
            $('#table{{$table_id}} thead tr:eq(0) th').each(function (i) {
                var title = $(this).text();
                $(this).html('<input class="header_filter form-control" type="text" placeholder="' + "" + '" />');

                $('input', this).on('keyup change', function () {
                    let value = this.value.replace(/\ي/g, 'ی');
                    value = value.replace(/\ك/g, 'ک');
                    if (table['{{$table_id}}'].column(i).search() !== value) {
                        table['{{$table_id}}']
                            .column(i)
                            .search(value)
                            .draw();
                    }
                });
            });
        }
        table['{{$table_id}}'] = $("#table{{$table_id}}").DataTable(option['{{$table_id}}']);
        @if(@$fixed)
            table['{{$table_id}}'].on('draw', function () {
            $("table#table{{$table_id}}").find('thead').remove();
            $(document).find('.DTFC_LeftBodyLiner').css('padding-right', '0');
            $(document).find('.DTFC_LeftBodyLiner').css('width', 'unset');
            $(document).find('.DTFC_LeftBodyLiner').css('overflow-y', 'hidden');
            $(document).find('.DTFC_LeftBodyLiner table thead').remove();
            $(document).find('.DTFC_LeftBodyWrapper').css('width', 'calc(100% + 8px)');
        });
        $("table#table{{$table_id}}").find('thead').remove();
        $(document).find('.DTFC_LeftBodyLiner').css('padding-right', '0');
        $(document).find('.DTFC_LeftBodyLiner').css('width', 'unset');
        $(document).find('.DTFC_LeftBodyLiner').css('overflow-y', 'hidden');
        $(document).find('.DTFC_LeftBodyLiner table thead').remove();
        $(document).find('.DTFC_LeftBodyWrapper').css('width', 'calc(100% + 8px)');
        @endif
        $("#table{{$table_id}}").addClass('hover');
        $('#table{{$table_id}}').on('click', 'a', function (e) {
            disableClick = true;
        });
        $('#table{{$table_id}}').on('click', 'td', function () {
            if (disableClick) {
                disableClick = false;
                return;
            }
            let obj = $(this);
            if (obj.parent().find('.btn-edit-row').data('edit')) return;
            {{$function??""}}
        });
        $('#table{{$table_id}}').on('draw.dt', function () {
        });

        $('#searchBtn{{$table_id}}').on('click', function () {
            let search = $('#searchTxt{{$table_id}}').val();
            if (search != '')
                $('#table{{$table_id}}').DataTable().search(search).draw();
        });

        $.fn.dataTable.ext.errMode = 'none';

        function editRow(obj, popup = true, save = false) {
            var tr = obj;
            if (!save && tr.find('.btn-edit-row').data('edit') != true) {
                if (popup) {
                    $("#edit_modal{{$table_id}} .modal-body").empty();
                    var index = 0;
                    tr.find('td').each(function () {
                        if ($(this).data('edit') != undefined && $(this).data('edit') != "") {
                            let editElem = $($.parseHTML($(this).data('edit')));
                            editElem.addClass('input');
                            try {
                                editElem.val($(this).html().replace(/<br>/g, "\n").trim());
                            } catch (e) {

                            }
                            if (editElem.is("select")) {
                                var val = $(this).text().trim();
                                if (val == "") {
                                    val = $(this).data('val');
                                }
                                editElem.val(editElem.find('option:contains(' + val + ')').val());
                            } else {
                                editElem.css('width', '100%');
                            }
                            editElem.data('td', index);
                            $("#edit_modal{{$table_id}} .modal-body").append($(this).parents().eq(2).find('thead tr:eq(1) th:eq(' + index + ')').text() + "<br>");
                            $("#edit_modal{{$table_id}} .modal-body").append(editElem);
                            $("#edit_modal{{$table_id}} .modal-body").append("<br>");
                            // $(this).html(editElem);
                        }
                        index++;
                    });
                    $("#edit_modal{{$table_id}}").modal('show');
                    $("#edit_modal{{$table_id}}").data('id', tr.data('id'));
                } else {
                    tr.find('td').each(function () {
                        if ($(this).data('edit') != undefined) {
                            let editElem = $($.parseHTML($(this).data('edit')));
                            editElem.addClass('input');
                            try {
                                editElem.val($(this).html().replace(/<br>/g, "\n").trim());
                            } catch (e) {

                            }
                            if (editElem.is("select")) {
                                var val = $(this).text().trim();
                                if (val == "") {
                                    val = $(this).data('val');
                                }
                                editElem.val(editElem.find('option:contains(' + val + ')').val());
                            }
                            $(this).html(editElem);
                        }
                    });
                    tr.find('.btn-edit-row').data('edit', true).html("ذخیره");
                }
            } else {
                const formData = new FormData();
                let button = tr.find('.btn-edit-row');
                if (popup) {
                    $('#edit_modal{{$table_id}}').LoadingOverlay("show");
                    formData.append('id', $('#edit_modal{{$table_id}}').data('id'))
                    $('#edit_modal{{$table_id}} .modal-body').find('select,input,textarea').each(function () {
                        let ob = $(this);
                        var td = ob.data('td');
                        if (ob.attr('type') == "checkbox"){
                            td = ob.parent().data('td');
                        }
                        var td = $("tr[data-id=" + $('#edit_modal{{$table_id}}').data('id') + "] td:eq(" + td + ")");
                        if (ob.is("select"))
                            td.html(ob.find("option:selected").text());
                        else {
                            if (ob.attr('type') == "file")
                                td.html("");
                            else if (ob.attr('type') == "checkbox")
                                td.html(ob.is(":checked") ? "بله" : "خیر");
                            else
                                td.html(ob.val());
                        }
                        if (ob.attr('type') == "file")
                            formData.append(ob.attr('name'), ob.prop('files')[0]);
                        else if (ob.attr('type') == "checkbox")
                            formData.append(ob.attr('name'), ob.is(':checked'));
                        else
                            formData.append(ob.attr('name'), ob.val());
                    });
                    let button = $('#submitedit_modal{{$table_id}}');
                } else {
                    tr.LoadingOverlay("show");
                    formData.append('id', tr.data('id'))
                    tr.find('td').each(function () {
                        if ($(this).data('edit') != undefined && $(this).data('edit') != "") {
                            let ob = $(this).find('.input');
                            if(ob.find('input[type=checkbox]').length>0) ob = ob.find('input[type=checkbox]:first');
                            if (ob.is("select"))
                                $(this).html(ob.find("option:selected").text());
                            else {
                                if (ob.attr('type') == "file")
                                    $(this).html("");
                                else if (ob.attr('type') == "checkbox")
                                    $(this).html(ob.is(":checked") ? "بله" : "خیر");
                                else
                                    $(this).html(ob.val());
                            }
                            if (ob.attr('type') == "file")
                                formData.append(ob.attr('name'), ob.prop('files')[0]);
                            else if (ob.attr('type') == "checkbox") {
                                console.log(ob);
                                formData.append(ob.attr('name'), ob.is(':checked'));
                            }
                            else
                                formData.append(ob.attr('name'), ob.val());
                        }
                    });
                }

                axios.post('{{@$edit_route}}', formData).then(function (response) {
                    if (response.data['ok']) {
                        if (popup) {
                            $('#edit_modal{{$table_id}}').LoadingOverlay("hide");
                            $('#edit_modal{{$table_id}}').modal('hide');
                        } else
                            button.html('<i class="fal fa-pencil"></i>');
                    } else {
                        if (!popup)
                            button.html("خطا");
                        $.toast({
                            text: response.data['message'],
                            position: 'bottom-left',
                            loaderBg: '#bc0000',
                            icon: 'error',
                            hideAfter: 3500
                        });
                    }
                }).catch(function (error) {
                    if (error.response && error.response.status == 403) {
                        $.toast({
                            text: "دسترسی غیر مجاز",
                            position: 'bottom-left',
                            loaderBg: '#bc0000',
                            icon: 'error',
                            hideAfter: 3500
                        });
                    }
                }).finally(function () {
                    if (!popup)
                        tr.LoadingOverlay("hide");
                });
                if (!popup)
                    button.data('edit', false);
            }
        }

        $("#submitedit_modal{{$table_id}}").click(function () {
            editRow($(this), true, true);
        });

        $(function () {
            $(document).on('click', '.btn-edit-row', function () {
                var tr = $(this).parents().eq(parseInt($(this).data('parent')) - 1);
                if (tr.find('tr').length == 0)
                    editRow(tr, true);
                else
                    tr.find('tr').each(function () {
                        editRow($(this), false);
                    });
            });
            $(document).on('click', '.btn-remove-row', function () {
                var tr = $(this).parents().eq(parseInt($(this).data('parent')) - 1);
                let data = {"id": tr.data('id')};
                swal({
                    title: "",
                    text: "از حذف این ردیف اطمینان دارید؟",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "تایید",
                    cancelButtonText: "خیر"
                }, function () {
                    tr.LoadingOverlay("show");
                    axios.post('{{@$remove_route}}', data).then(function (response) {
                        if (response.data['ok'])
                            tr.remove();
                        else {
                            $.toast({
                                text: response.data['message'],
                                position: 'bottom-left',
                                loaderBg: '#bc0000',
                                icon: 'error',
                                hideAfter: 3500
                            });
                        }
                    }).catch(function (error) {
                        if (error.response && error.response.status == 403) {
                            $.toast({
                                text: "دسترسی غیر مجاز",
                                position: 'bottom-left',
                                loaderBg: '#bc0000',
                                icon: 'error',
                                hideAfter: 3500
                            });
                        }
                    }).finally(function () {
                        tr.LoadingOverlay("hide");
                    });
                });
            });
            $(document).on('click', '.btn-add-row', function () {
                $("#edit_modal{{$table_id}} .modal-title").html('ردیف جدید');
                let row = $('#table{{$table_id}}').find('tbody tr:first-child').clone();
                row.find('td').each(function () {
                    if ($(this).data('edit') != undefined)
                        $(this).html("");
                });
                row.removeAttr('data-id')
                $('#table{{$table_id}}').find('tbody').before(row);
                <!--$('#table{$table_id}}').find('tbody tr:first-child');-->
                row.find('.btn-edit-row').click();
            });
        });
    </script>
@endpush
