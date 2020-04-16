<?php
$select_id = rand();
$data = $data ?? [];
$options['multiple'] = isset($options['multiple']) ? 'multiple' : '';
$options['function'] = isset($options['function']) ? $options['function'] : '';
?>
@push('head')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('ap/plugins/select2/dist/css/select2.min.css')}}">
@endpush
<select class="form-control select2" style="width: 100%;" id="select{{$select_id}}" {{$options['multiple']}}>
    @foreach($data as $key=>$val)
        <option value="{{$key}}">{{__($val)}}</option>
    @endforeach
</select>
@push('script')
    <!-- Select2 -->
    <script src="{{asset('ap/plugins/select2/dist/js/select2.full.js')}}"></script>

    <script>
        $('#select{{$select_id}}').select2();
        $('#select{{$select_id}}').change(function () {
            {{$options['function']}}
        });
    </script>
@endpush
