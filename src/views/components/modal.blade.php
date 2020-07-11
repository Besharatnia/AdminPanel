<div class="modal {{$type}} fade" id="{{$id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{@$title}}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{$body}}
            </div>
            <div class="modal-footer modal-footer-uniform">
                <button type="button" class="btn btn-bold btn-pure btn-secondary"
                        data-dismiss="modal">{{$close??"بستن"}}</button>
                <button id="submit{{$id}}" type="button" class="btn btn-bold btn-pure btn-kowsar float-right btn-submit">{{$save??"ذخیره"}}</button>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        $('#submit{{$id}}').click(function () {
            {!! $function??"" !!}
        });
    </script>
@endpush
