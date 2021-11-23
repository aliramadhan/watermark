<x-app-layout>

    <div class="w-max-screen mx-auto ">
      <div class="relative flex space-x-4 overflow-hidden  max-h-full">
        @if(!file_exists('temp/pdf_'.auth()->user()->id.'.pdf'))

        <form class="flex flex-col h-100 justify-between z-10 lg:w-60 xl:w-72 sticky bg-white pb-4  px-6 shadow-xl  tracking-wide" action="{{route('user.store.upload2')}}" enctype="multipart/form-data" method="post">
            @csrf
            <h2 class="mb-2 font-semibold text-xl text-gray-700 tracking-wide mt-5">Upload</h2>               
            <div class="bg-white rounded-lg mb-3 px-2 py-1">                

                <div class="mb-3">
                    <label >PDF Document</label>               

                    <label class="w-max flex flex-col items-center px-4 py-2 bg-white  text-gray-600 rounded-lg  tracking-wide shadow-md uppercase border border-blue cursor-pointer hover:bg-blue-400 hover:text-white mt-1">
                         
                            <span class=" text-base leading-normal "><i class="fas fa-file-import mr-2"></i> Select pdf file</span>
                            <input class="hidden"  type="file" name="pdf" value="{{old('pdf')}}" />
                        </label>

                </div>

                <div class="mb-3">
                    <label >Signature</label>
                     <label class="w-max flex flex-col items-center px-4 py-2 bg-white  text-gray-600 rounded-lg  tracking-wide shadow-md uppercase border border-blue cursor-pointer hover:bg-blue-400 hover:text-white mt-1">
                         
                            <span class=" text-base leading-normal "><i class="fas fa-file-import mr-2"></i> Select signature </span>
                            <input class="hidden"   type="file" name="watermark" value="{{old('watermark')}}"/>
                        </label>
                  
                </div>
            </div>

            <h2 class="mb-2 font-semibold text-lg tracking-wide">Signature Result</h2>               
            <div class="bg-gray-100 border rounded-2xl mb-3 h-52"> 

            </div>

            <div class="bg-white rounded-lg mb-3 ">          
                <div class="w-full flex justify-center mt-4">
                    <button type="submit" name="submit" class="bg-blue-400 hover:bg-blue-600 duration-300 text-lg font-semibold tracking-wider px-4 py-2 rounded-lg text-white shadow-lg text-right ">
                     <i class="fas fa-upload"></i>  Upload File
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
                <label class="text-gray-600"><i class="fas fa-file-alt mr-1.5"></i> Select Page Set</label>
                <input type="number" name="pages" placeholder="1, 2, 3, 4 .. - 100" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 mt-1"  id="formPages" value="{{old('pages')}}">
            </div>       
            <div class="mb-4 flex flex-col">
                <label class="text-gray-600"><i class="far fa-sticky-note mr-1.5"></i>Opacity (Ketebalan)</label>
                <input type="number" name="opacity" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 mt-1"  id="formOpacity" value="{{old('opacity')}}" min="1" max="100" placeholder="1 - 100">
            </div>      
            <div class="mb-4 grid grid-cols-2 gap-4">
                <label class="col-span-2 -mb-4 font-semibold text-gray-700"><i class="fas fa-ruler-combined mr-1.5"></i>Coordinate </label>
                <div >
                    <label class="text-gray-500">Horizontal</label>
                    <input type="number" name="x" placeholder="X" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 w-full"  id="formX" value="{{old('x')}}">
                </div>
                <div >
                    <label class="text-gray-500">Vertical</label>
                    <input type="number" name="y" placeholder="Y" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 w-full"  id="formY" value="{{old('y')}}">
                </div>
            </div> 

            <div class="mb-4 grid grid-cols-2 gap-4">
                <label class="col-span-2 -mb-4 font-semibold text-gray-700"><i class="fas fa-pencil-ruler mr-1.5"></i> Size</label>
                <div>
                    <label class="text-gray-500">Width</label>
                    <input type="number" placeholder="Pixels" name="widthWatermark" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 w-full"  id="formWidht" value="{{old('widthWatermark')}}">
                </div>
                <div >
                    <label class="text-gray-500">Height</label>
                    <input type="number" placeholder="Pixels" name="heightWatermark" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 w-full"  id="formHeight" value="{{old('heightWatermark')}}">
                </div>
            </div>
            <div class="mb-4 grid grid-cols-2 border-t pt-4 -mx-5 px-5 text-sm">
                <label class="col-span-2 font-semibold text-gray-700 mb-2 text-base"><i class="fas fa-book mr-1.5"></i>File Information</label>

                <label class="text-gray-500">File Name</label>
                <label class="text-gray-500 truncate">: Filename.pdf</label>
                <label class="text-gray-500">File Size</label>
                <label class="text-gray-500">: 12 Mb</label>
                <label class="text-gray-500">Total Page</label>
                <label class="text-gray-500">: 18</label>
                <label class="text-gray-500">Upload Date</label>
                <label class="text-gray-500 truncate">: Selasa, 23 Nov 2021</label>
                <label class="text-gray-500">Editing By</label>
                <label class="text-gray-500 truncate">: {{Auth::user()->name}}</label>

            </div>

        </div>
        <div class="mt-2  -mx-6 -mb-4   bg-blue-400 py-3 px-6">
            <div class="grid grid-cols-2 w-100  border-b divide-x divide-gray-300 broder-gray-300  -mt-3 -mx-6 mb-4 h-20 text-gray-50">
                <button class="space-y-1 bg-blue-500 hover:bg-blue-600 duration-300 w-full">
                    <i class="fas fa-undo fa-xl pb-2"></i><br>
                    <label class="tracking-wider"> Undo</label>
                </button>
                <button class="space-y-1 bg-blue-500 hover:bg-blue-600 duration-300 w-full">
                    <i class="fas fa-redo fa-xl pb-2"></i><br>
                    <label class="tracking-wider"> Redo</label>
                </button>

            </div>

            <button type="submit" name="submit" class="bg-white text-blue-500 px-4 w-full mx-auto  py-2 my-2 rounded-lg font-semibold hover:bg-blue-500 hover:text-white duration-300 shadow-lg tracking-wider" id="edit">
                Save Signature
            </button>
        </div>
    </div>



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

            <div class="flex space-x-6 items-center justify-end bg-gradient-to-l from-gray-500  px-7 py-4 pb-5 shadow-xl  right-0 bottom-0 w-full absolute  text-right ">
             <button class="duration-300 bg-blue-500 hover:bg-blue-600 text-white py-2.5 px-5 text-xl rounded-md font-semibold shadow-lg tracking-wider sticky">
                <i class="fas fa-save"></i> Save</button>
                <button class="duration-300 bg-yellow-500 hover:bg-yellow-400 text-white py-2.5 px-5 text-xl rounded-md font-semibold shadow-lg tracking-wider sticky">
                    <i class="fas fa-file-download mr-4"></i> Export</button>
                </div>

                @endif
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
