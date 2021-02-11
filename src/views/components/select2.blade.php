<?php
$data = $data ?? [];
$id = $id ?? rand(0, 10000);
$style = $style ?? "width: 100%;"
?>
@push('head')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('ap/plugins/select2/dist/css/select2.min.css')}}">
@endpush
<select name="{{$name??""}}" class="select2 {{$class??""}}" style="{{$style}}" id="select{{$id}}" {{$multiple??""}}>
    {{$datas}}
</select>
@push('script')
    <!-- Select2 -->
    <script src="{{asset('ap/plugins/select2/dist/js/select2.full.js')}}"></script>

    <script>
        @if(@$init!==false)
        init_select($('#select{{$id}}'));
        @endif

        function init_select(obj) {
            obj.select2({
                tags: "{{$tag??false}}",
                @isset($parent)
                dropdownParent: $('#{{$parent}}'),
                @endisset
                closeOnSelect: "{{$closeOnSelect??true}}",
                matcher: function (params, data) {
                    if ($.trim(params.term) === '') {
                        return data;
                    }
                    if (typeof data.text === 'undefined') {
                        return null;
                    }
                    var q = fixPersianNumbers(params.term.toLowerCase());
                    if (data.text.toLowerCase().indexOf(q) > -1 || data.id.toLowerCase().indexOf(q) > -1) {
                        return $.extend({}, data, true);
                    }
                    return null;
                }
            });
            obj.change(function () {
                {{$options['function'] ?? ''}}
            });
        }
    </script>
@endpush
