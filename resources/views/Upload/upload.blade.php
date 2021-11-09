<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.3.5/dist/alpine.min.js"
      defer
    ></script>

    <title>Processing Page</title>
</head>

<body>
    <div class="container mt-4" style="max-width: 600px">
        <h2 class="mb-5">Laravel Example</h2>

        <form action="{{route('user.store.upload')}}" enctype="multipart/form-data" method="post">
            @csrf
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <strong>{{ $message }}</strong>
            </div>


            <div class="col-md-12 mb-3 text-center">
                <strong>Manipulated image:</strong><br />
               
                <img src="/{{ Session::get('fileName') }}" width="600px" class="img-preview" />
               
            </div>
            @else
                  <img class="img-preview mb-4" width="600px">
            @endif

            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mb-3">
                <label>Image</label>
                <input type="file" name="image" class="form-control"  id="image" onchange="previewImage()">
            <div class="mb-3">
                <label>Signature</label>
                <input type="file" name="watermark" class="form-control"  id="formFile">
            </div>

            <div class="d-grid mt-4">
                <button type="submit" name="submit" class="btn btn-primary">
                    Upload File
                </button>
            </div>
        </form>
    </div>
</body>
<script type="text/javascript">
  function previewImage(){

      const image = document.querySelector('#image');
      const imgPreview = document.querySelector('.img-preview');

      imgPreview.style.display = "block";

      const oFReader = new FileReader();
      oFReader.readAsDataURL(image.files[0]);

      oFReader.onload =function(oFReader){
       imgPreview.src = oFReader.target.result;
    }
}
</script>

</html>

