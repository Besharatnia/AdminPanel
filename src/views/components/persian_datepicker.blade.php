@push('head')
    <link rel="stylesheet" href="{{asset('ap/plugins/perisan-datepicker/persian-datepicker.min.css')}}">
@endpush
<input type="text" class="form-control datepicker" name="{{@$name}}" value="{{@$value}}" />
@push('script')
    <script src="{{asset('ap/plugins/perisan-datepicker/persian-date.min.js')}}"></script>
    <script src="{{asset('ap/plugins/perisan-datepicker/persian-datepicker.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            persian_date_init($(".datepicker[name='{{@$name}}']"));
        });
        function persian_date_init(obj) {
            obj.pDatepicker({
                format: 'YYYY/MM/DD',
                autoClose: true,
                initialValueType: 'persian'
            });
        }
    </script>
@endpush
