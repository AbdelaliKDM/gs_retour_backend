@extends('layouts/contentNavbarLayout')

@section('title', __("app.{$documentation->name}"))

@section('vendor-script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/vendor/js/quill.js') }}"></script>
@endsection

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/quill.css') }}" />
@endsection

@section('content')

<h4 class="fw-bold py-3 mb-3">
  <span class="text-muted fw-light">{{__('app.documentation')}} / </span> {{ __("app.{$documentation->name}")}}
</h4>

<div class="card mb-4">
  <div class="card-body">
    <form class="form-horizontal" onsubmit="event.preventDefault()" action="#"
          enctype="multipart/form-data" id="form">

      <!-- Language selection tabs -->
      <ul class="nav nav-pills mb-3" id="language-tabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="english-tab" data-bs-toggle="pill" data-bs-target="#english-content"
                  type="button" role="tab" aria-controls="english-content" aria-selected="true">
            {{__('app.locales.english')}}
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="arabic-tab" data-bs-toggle="pill" data-bs-target="#arabic-content"
                  type="button" role="tab" aria-controls="arabic-content" aria-selected="false">
            {{__('app.locales.arabic')}}
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="french-tab" data-bs-toggle="pill" data-bs-target="#french-content"
                  type="button" role="tab" aria-controls="french-content" aria-selected="false">
            {{__('app.locales.french')}}
          </button>
        </li>
      </ul>

      <!-- Tab content with editors -->
      <div class="tab-content" id="language-editors">
        <!-- English Editor -->
        <div class="tab-pane fade show active" id="english-content" role="tabpanel" aria-labelledby="english-tab">
          <div id="english-editor" class="mb-3"></div>
          <div id="english-documentation" hidden>{!! $documentation->content_en !!}</div>
        </div>

        <!-- Arabic Editor -->
        <div class="tab-pane fade" id="arabic-content" role="tabpanel" aria-labelledby="arabic-tab">
          <div id="arabic-editor" class="mb-3" dir="rtl"></div>
          <div id="arabic-documentation" hidden>{!! $documentation->content_ar !!}</div>
        </div>

        <!-- French Editor -->
        <div class="tab-pane fade" id="french-content" role="tabpanel" aria-labelledby="french-tab">
          <div id="french-editor" class="mb-3"></div>
          <div id="french-documentation" hidden>{!! $documentation->content_fr !!}</div>
        </div>
      </div>

      <input type="hidden" id="name" name="name" value="{{$documentation->name}}" />
      <input type="hidden" id="content_en" name="content_en" />
      <input type="hidden" id="content_ar" name="content_ar" />
      <input type="hidden" id="content_fr" name="content_fr" />
    </form>

    <div class="col" style="text-align: center">
      <button id="submit" class="btn btn-primary">{{__('Submit')}}</button>
    </div>
  </div>
</div>

@endsection

@section('page-script')
<script>
  $(document).ready(function() {
    // Initialize Quill editors
    const englishQuill = new Quill("#english-editor", {
      theme: "snow",
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          [{ 'align': [] }],
          ['link', 'image'],
          ['clean']
        ]
      }
    });

    const arabicQuill = new Quill("#arabic-editor", {
      theme: "snow",
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          [{ 'align': [] }],
          ['link', 'image'],
          ['clean']
        ]
      }
    });

    const frenchQuill = new Quill("#french-editor", {
      theme: "snow",
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          [{ 'align': [] }],
          ['link', 'image'],
          ['clean']
        ]
      }
    });

    // Load existing content into editors
    englishQuill.clipboard.dangerouslyPasteHTML($('#english-documentation').html());
    arabicQuill.clipboard.dangerouslyPasteHTML($('#arabic-documentation').html());
    frenchQuill.clipboard.dangerouslyPasteHTML($('#french-documentation').html());

    // Set RTL for Arabic editor
    arabicQuill.format('align', 'right');
    arabicQuill.format('direction', 'rtl');

    // Auto-select tab based on current locale
    const currentLocale = "{{session('locale')}}";
    if (currentLocale === 'ar') {
      $('#arabic-tab').tab('show');
    } else if (currentLocale === 'fr') {
      $('#french-tab').tab('show');
    }

    // Handle form submission
    $('#submit').on('click', function() {
      var formdata = new FormData();

      // Get content from all editors
      const englishContent = englishQuill.getSemanticHTML();
      const arabicContent = arabicQuill.getSemanticHTML();
      const frenchContent = frenchQuill.getSemanticHTML();
      const name = document.getElementById('name').value;

      // Append form data
      formdata.append('name', name);
      formdata.append('content_en', englishContent);
      formdata.append('content_ar', arabicContent);
      formdata.append('content_fr', frenchContent);

      $.ajax({
        url: '{{ url('documentation/update') }}',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: formdata,
        dataType: 'JSON',
        contentType: false,
        processData: false,
        success: function(response) {
          if (response.status == 1) {
            Swal.fire(
              "{{ __('Success') }}",
              "{{ __('success') }}",
              'success'
            ).then(function() {
              location.reload();
            });
          } else {
            console.log(response.message);
            Swal.fire(
              "{{ __('Error') }}",
              response.message,
              'error'
            );
          }
        },
        error: function(data) {
          var errors = data.responseJSON;
          console.log(errors);
          Swal.fire(
            "{{ __('Error') }}",
            errors.message,
            'error'
          );
        }
      });
    });
  });
</script>
@endsection