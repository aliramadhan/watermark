<x-app-layout>

    <div class="w-max-screen mx-auto ">
      <div class="relative flex space-x-4 overflow-hidden  max-h-full">
        @if(!file_exists('temp/pdf_'.auth()->user()->id.'.pdf'))

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
                <div class="d-grid mt-4">
                    <button type="submit" name="submit" class="btn btn-primary">
                        Upload File
                    </button>
                </div>

            </div>
        </form>
        @endif
        @if(file_exists('temp/pdf_'.auth()->user()->id.'.pdf'))


        <div class="flex flex-col h-100 justify-between z-10 lg:w-60 xl:w-72 sticky bg-white pb-4  px-6 shadow-xl  tracking-wide">   
            <div>
                <h2 class="mb-8 font-semibold text-xl text-gray-700 tracking-wide mt-5">Signature Settings</h2>    
                <div class="mb-4 flex flex-col">
                    <label class="text-gray-600">Select Page Set</label>
                    <input type="number" name="pages" placeholder="1, 2, 3, 4 .. - 100" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 mt-1"  id="formPages" value="{{old('pages')}}">
                </div>       
                <div class="mb-4 flex flex-col">
                    <label class="text-gray-600">Opacity (Transparant)</label>
                    <input type="number" name="opacity" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 mt-1"  id="formOpacity" value="{{old('opacity')}}" min="1" max="100" placeholder="1 - 100">
                </div>      
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <label class="col-span-2 -mb-4 font-semibold text-gray-700">Coordinate </label>
                    <div >
                        <label class="text-gray-500">Horizontal</label>
                        <input type="number" name="x" placeholder="X" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 w-full"  id="formX" value="{{old('x')}}">
                    </div>
                    <div >
                        <label class="text-gray-500">Vertikal</label>
                        <input type="number" name="y" placeholder="Y" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 w-full"  id="formY" value="{{old('y')}}">
                    </div>
                </div> 

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <label class="col-span-2 -mb-4 font-semibold text-gray-700">Size</label>
                    <div>
                        <label class="text-gray-500">Width</label>
                        <input type="number" placeholder="Pixels" name="widthWatermark" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 w-full"  id="formWidht" value="{{old('widthWatermark')}}">
                    </div>
                    <div >
                        <label class="text-gray-500">Height</label>
                        <input type="number" placeholder="Pixels" name="heightWatermark" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 w-full"  id="formHeight" value="{{old('heightWatermark')}}">
                    </div>
                </div>

            </div>
            <div class="mt-8  -mx-6 -mb-4   bg-blue-400 py-3 px-4">
                <div class="grid grid-cols-2 w-100  border-b divide-x divide-gray-300 broder-gray-300  -mt-3 -mx-4 mb-4 h-20 text-gray-50">
                    <button class="space-y-1 bg-indigo-500 hover:bg-blue-500 duration-300 w-full">
                        <i class="fas fa-undo fa-xl pb-2"></i><br>
                        <label class="tracking-wider"> Undo</label>
                    </button>
                    <button class="space-y-1 bg-indigo-500 hover:bg-blue-500 duration-300 w-full">
                        <i class="fas fa-redo fa-xl pb-2"></i><br>
                        <label class="tracking-wider"> Redo</label>
                    </button>

                </div>

                <button type="submit" name="submit" class=" w-full bg-white text-blue-500 px-5 py-2 my-2 rounded-lg font-semibold hover:bg-blue-500 hover:text-white duration-300 shadow-lg tracking-wider" id="edit">
                    Save Signature
                </button>
            </div>
        </div>
        
        @endif

        <div class="relative w-full p-8 my-3 h-full pb-32">

            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <strong>{{ $message }}</strong>
            </div>
            @endif
            @if(file_exists('temp/pdf_'.auth()->user()->id.'.pdf'))
            <div class="shadow-lg  text-center ">

                <div id="divEmbed">
                    @if(file_exists('temp/pdf_'.auth()->user()->id.'.pdf'))
                    <embed id='embedPDF' class="w-full" src='../temp/pdf_{{auth()->user()->id}}.pdf'  width="100%" height='600' type='application/pdf'>
                        @else
                        <embed id='embedPDF' class="w-full" src='../temp/pdf_{{auth()->user()->id}}.pdf' width="100%"  height='600' type='application/pdf'>

                            @endif
                        </div>
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

                <div class="bg-gradient-to-l from-gray-600 to-indigo-500  px-7 py-4 pb-5 shadow-xl  right-0 bottom-0 w-full absolute  text-right">
                    <button class="bg-yellow-500 hover:bg-yellow-500 text-white py-2.5 px-5 text-xl rounded-md font-semibold shadow-lg tracking-wider sticky">
                        <i class="fas fa-file-download mr-4"></i> Export</button>
                    </div>
                </div>

               
            </div>


            <script src="http://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous">
        </script>
        <script>
         jQuery(document).ready(function(){
            jQuery('#edit').click(function(e){
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
               jQuery.ajax({
                  url: "{{ route('user.edit.watermark.pdf') }}",
                  method: 'post',
                  data: {
                    _token: "{{ csrf_token() }}",
                    pages: jQuery('#formPages').val(),
                    opacity: jQuery('#formOpacity').val(),
                    x: jQuery('#formX').val(),
                    y: jQuery('#formY').val(),
                    width: jQuery('#formWidht').val(),
                    height: jQuery('#formHeight').val(),
                },
                success: function(result){
                    $("#divEmbed").html(result.embedPDF);
                }});
           });
        });
    </script>
</x-app-layout>
