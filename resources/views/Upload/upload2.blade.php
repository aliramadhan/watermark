<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-4 gap-4 overflow-hidden sm:rounded-lg">
                
                <form class="flex flex-col " action="{{route('user.store.upload2')}}" enctype="multipart/form-data" method="post">
                    @csrf
                <h2 class="mb-2 font-semibold text-lg tracking-wide">Upload</h2>               
                <div class="bg-white rounded-lg mb-3 px-2 py-1">                
                 
                    <div class="mb-3">
                        <label class="mb-1">Upload Document</label>
                        <input type="file" name="pdf" class="form-control"  id="formFile" value="{{old('pdf')}}">
                    </div>

                    <div class="mb-3">
                        <label class="mb-1">Upload Signature</label>
                        <input type="file" name="watermark" class="form-control"  id="formFile" value="{{old('watermark')}}">
                    </div>
                </div>

                <h2 class="mb-2 font-semibold text-lg tracking-wide">Result</h2>               
                <div class="bg-white rounded-lg mb-3 h-52"> 
                   
                </div>
                
                <div class="bg-white rounded-lg mb-3 ">          

                    <div class="mb-3">
                        <label>X</label>
                        <input type="number" name="x" class="form-control"  id="formFile" value="{{old('x')}}">
                    </div>
                    <div class="mb-3">
                        <label>Y</label>
                        <input type="number" name="y" class="form-control"  id="formFile" value="{{old('y')}}">
                    </div>
                   
                    <div class="mb-3">
                        <label>Width</label>
                        <input type="number" name="widthWatermark" class="form-control"  id="formFile" value="{{old('widthWatermark')}}">
                    </div>
                    <div class="mb-3">
                        <label>Height</label>
                        <input type="number" name="heightWatermark" class="form-control"  id="formFile" value="{{old('heightWatermark')}}">
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" name="submit" class="btn btn-primary">
                            Upload File
                        </button>
                    </div>
               
                </div>
            </form>

            
                <div class="bg-white col-span-3">
                   
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <strong>{{ $message }}</strong>
                    </div>

                    <div class="col-md-12 mb-3 text-center">
                        <strong>Manipulated PDF:</strong><br />
                        <embed src="../filename.pdf" width="500" height="375" type="application/pdf">
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

                </div>
            </div>
           
        </div>
       
        </div>
 
</x-app-layout>
