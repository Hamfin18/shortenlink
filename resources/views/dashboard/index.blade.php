@extends('layouts.app')

@push('head')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <style>
        .hidden-area {
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="card mt-3 ">
        <div class="card-body">
            <h5 class="card-title text-center">URL SHORTENER</h5>
            <div>
                <div class="mb-3">
                    <label for="input" class="form-label">
                        Paste your URL here
                    </label>
                    <input type="text" class="form-control" name="input" id="input" aria-describedby="input">

                    <div class="hidden-area">
                        <input type="text" class="form-control mt-1 text-center border-success btn btn-outline-success"
                            id="result" readonly onclick="copyLink()">
                    </div>

                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary" id="submit" onclick="getShortlink()" disabled>
                        SHORTEN LINK
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#input').on('input', function() {
                if (isValidURL($(this).val().trim())) {
                    $('#submit').removeAttr('disabled');

                } else {
                    $('#submit').attr('disabled', true);
                    $(".hidden-area").hide();

                }
            });
        });

        //get shortlink
        function getShortlink() {
            let input = $('#input').val();
            $.ajax({
                url: '{{ route('getUrl') }}',
                type: 'POST',
                data: {
                    url: input,
                },
                success: function(response) {
                    // console.log(response);
                    setResult("{{ route('/') }}/" + response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function setResult(val) {
            $("#result").val(val);
            $(".hidden-area").show();
        }

        function copyLink() {
            var resultElement = $('#result');
            var originalValue = resultElement.val();
            var newValue = "Link Copied";

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(originalValue).then(function() {
                    resultElement.val(newValue);
                    setTimeout(function() {
                        resultElement.val(originalValue);
                    }, 1000);
                }).catch(function(err) {
                    console.error('Could not copy text: ', err);
                });
            } else {
                console.error('Clipboard API not supported.');
            }
        }



        function isValidURL(str) {
            var pattern = new RegExp('^(https?:\\/\\/)?' +
                '((([a-z0-9](?:[a-z0-9-]*[a-z0-9])?)\\.)+([a-z]{2,}|[a-z0-9-]{2,}\\.[a-z]{2,})|' +
                'localhost|' +
                '\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}|' +
                '\\[?[a-f0-9]*:[a-f0-9:]+\\]?)' +
                '(\\:\\d+)?(\\/[-a-z0-9%_.~+@]*)*' +
                '(\\?[;&a-z0-9%_.~+=-]*)?' +
                '(\\#[-a-z0-9_]*)?$', 'i');
            return !!pattern.test(str);
        }
    </script>
@endpush
