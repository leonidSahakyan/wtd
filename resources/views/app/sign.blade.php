@extends('app.layouts.app')
@section('content')
<section class="contact-one">
    <form action="{{route('ForPdf')}}" method="post">
        @csrf
        <input name="pdfSign" id="pdfSign" type="text">

        <button> Viwe PDF</button>
    </form>
    <form  method="post" class="savePng m-3" id="savePng" name="savePng"  >
        @csrf
        <input type="text" style="display: none" class="m-2" id="savePngData"  name="savePngData" value="" >
    </form>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 m-3">
            <div name="sig" class="sig" id="sig"></div>
                <button  class="png" name="png" id="png">Save</button>
{{--                <button id="disable">Disable</button>--}}
                <button id="clear">Clear</button>
            </div>
        </div>
    </div>
</section>

@push('css')
    <style>
        .kbw-signature { width: 400px; height: 200px; }
        .kbw-signature {
            display: inline-block;
            border: 1px solid #a0a0a0;

            -ms-touch-action: none;
        }
        .kbw-signature-disabled {
            opacity: 0.35;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset('assets/js/jquery.signature.js') }}"></script>
    <script>
            var sig = $('#sig').signature();
            $('#disable').click(function() {
                var disable = $(this).text() === 'Disable';
                $(this).text(disable ? 'Enable' : 'Disable');
                sig.signature(disable ? 'disable' : 'enable');
            });
            $('#clear').click(function() {
                sig.signature('clear');
            });
            $('#png').click(function(e) {
                Loading.add($('#png'));
                var sign = sig.signature('toDataURL');
             $('#savePngData').val(sign);
              var data = $('#savePng').serializeFormJSON();
              console.log(data);
                $.ajax({
                    type: "POST",
                    url: "{{ route('signImg') }}",
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success.status === 0) {
                            // toastr['error'](response.message, 'Error');
                            alert('Error')
                        }
                        if (response.success.status === 1) {
                            alert('Saved.', 'Success');
                            $('#pdfSign').val(response.success.signPath);


                        }
                        if(response.success.status){
                            console.log("hi")
                        }

                        Loading.remove($('#png'));
                    }
                });
            });


    </script>
@endpush
@endsection
