<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h2 class="mb-5">Laravel Image Watermarking Example</h2>

                <form action="{{route('user.store.upload')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <strong>{{ $message }}</strong>
                    </div>


                    <div class="col-md-12 mb-3 text-center">
                        <strong>Manipulated PDF:</strong><br />
                        <img src="/{{ Session::get('fileName') }}" width="600px"/>
                    </div>
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
                        <input type="file" name="image" class="form-control"  id="formFile">
                    </div>

                    <div class="mb-3">
                        <label>Watermark</label>
                        <input type="file" name="watermark" class="form-control"  id="formFile">
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" name="submit" class="btn btn-primary">
                            Upload File
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
