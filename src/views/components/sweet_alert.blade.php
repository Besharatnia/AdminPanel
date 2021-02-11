<?php
$data = $data ?? [];
$options['function'] = isset($options['function']) ? $options['function'] : '';
?>
@push('head')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('ap/plugins/sweetalert/sweetalert.css?v=1')}}">
@endpush
@push('script')
    <!-- Select2 -->
    <script src="{{asset('ap/plugins/sweetalert/sweetalert.min.js?v-1')}}"></script>
@endpush
