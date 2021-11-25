<x-app-layout>
   <div class="w-max-screen mx-auto  overflow-y-hidden">
    <div class="relative flex space-x-4 max-h-full"  x-data="{ scope: true }">
        @if(!file_exists('temp/pdf_'.auth()->user()->id.'.pdf'))

        <div class="flex flex-col h-screen  justify-between z-10 lg:w-60 xl:w-72 sticky bg-white pb-4  px-6 shadow-xl  tracking-wide">   
            <div>
                <form action="{{route('user.store.upload2')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <h2 class="mb-2 font-semibold text-xl text-gray-700 tracking-wide mt-5">Upload</h2>               
                    <div class="bg-white rounded-lg mb-3 px-2 py-1">                

                        <div class="mb-3">
                            <label >PDF Document</label>               

                            <label class="w-max flex flex-col items-center px-4 py-2 bg-white  text-gray-600 rounded-lg  tracking-wide shadow-md uppercase border border-blue cursor-pointer hover:bg-blue-400 hover:text-white mt-1">

                                <span class=" text-base leading-normal "><i class="fas fa-file-import mr-2"></i> Select pdf file</span>
                                <input class="hidden"  type="file" name="pdf" value="{{old('pdf')}}"  id="myPdf"/>
                            </label>

                        </div>

                        <div class="mb-3">
                            <label >Signature</label>
                            <label class="w-max flex flex-col items-center px-4 py-2 bg-white  text-gray-600 rounded-lg  tracking-wide shadow-md uppercase border border-blue cursor-pointer hover:bg-blue-400 hover:text-white mt-1">

                                <span class=" text-base leading-normal "><i class="fas fa-file-import mr-2"></i> Select signature </span>
                                <input class="hidden" type="file" name="watermark" value="{{old('watermark')}}"  id="image" onchange="previewImage()"/>
                            </label>

                        </div>
                    </div>

                    <h2 class="mb-2 font-semibold text-lg tracking-wide">Signature Result</h2>               
                    <div class="bg-gray-100 border rounded-2xl mb-3 h-52"> 
                        <img  class="img-preview w-full h-full object-contain" />
                    </div>

                    <div class="bg-white rounded-lg mb-3 ">          
                        <div class="w-full flex justify-center mt-4">
                            <button type="submit" name="submit" class="bg-blue-400 hover:bg-blue-600 duration-300 text-lg font-semibold tracking-wider px-4 py-2 rounded-lg text-white shadow-lg text-right ">
                             <i class="fas fa-upload"></i>  Upload File
                         </button>
                     </div>

                 </div>

             </form>
         </div>
     </div>

     <div class="relative w-full p-8 my-3 h-5/6  flex flex-row space-x-4">
       <div class="shadow-lg w-4/12 text-center ">
         <canvas id="pdfViewer" class="w-full mx-auto h-full"></canvas>
     </div>
     <div class=" w-4/12 text-center text-gray-700 font-semibold text-4xl my-auto ">
        <label> Preview PDF File</label>
    </div>
</div>

@endif
@if(file_exists('temp/pdf_'.auth()->user()->id.'.pdf'))

<div x-data="{ open: true }" class="h-100 flex ">
    <button @click="open = ! open" class="fixed bg-white rounded-full h-12 w-12 z-10 left-12 top-24  hover:bg-blue-400 hover:text-white duration-300 shadow-lg"><i class="fas fa-angle-right fa-xl"></i></button> 

    <div class="flex flex-col h-100 justify-between z-10 lg:w-60 xl:w-72 sticky bg-white pb-4  px-6 shadow-xl  tracking-wide relative"   x-show="open" x-transition>  
       <button @click="open = ! open" class="absolute text-blue-600 bg-white rounded-full h-12 w-12 z-20 -right-6 top-10 border hover:bg-blue-400 hover:text-white duration-300"><i class="fas fa-angle-left fa-xl"></i></button> 
       <div>



        <h2 class="mb-8 font-semibold text-xl text-gray-700 tracking-wide mt-5">Signature Settings</h2>    
        <div class="mb-4 flex flex-col">
            <label class="text-gray-600"><i class="fas fa-file-alt mr-1.5"></i> Select Page Set</label>
            <input type="text" name="pages" placeholder="1, 2, 3, 4 .. - 100" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 mt-1"  id="formPages" value="{{old('pages')}}">
        </div>       
        <div class="mb-4 flex flex-col">
            <label class="text-gray-600"><i class="far fa-sticky-note mr-1.5"></i>Opacity (Ketebalan)</label>
            <input type="number" name="opacity" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 mt-1"  id="formOpacity" value="{{old('opacity')}}" min="1" max="100" placeholder="1 - 100">
        </div>      
        <div class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2 -mb-2 flex items-center justify-between font-semibold ">
                <label class=" text-gray-700 "><i class="fas fa-ruler-combined mr-1.5"></i>Coordinate
                </label>
                <button @click="scope = ! scope" class="bg-white rounded-lg hover:bg-blue-400 hover:text-white duration-300 py-1 tracking-wide text-gray-700 shadow border px-2 text-sm"><i class="fas fa-search-plus mr-1" ></i> Set Here</button> 
            </div>
            <div >
                <label class="text-gray-500">Horizontal</label>
                <input type="number" name="x" placeholder="X" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 w-full"  id="formX" value="{{old('x')}}" max="200">
            </div>
            <div >
                <label class="text-gray-500">Vertical</label>
                <input type="number" name="y" placeholder="Y" class="bg-gray-100 hover:border-indigo-400 duration-300 rounded-lg border-gray-200 py-1.5 px-3.5 w-full"  id="formY" value="{{old('y')}}" max="285">
            </div>
        </div> 

        <div class="mb-4 grid grid-cols-2 gap-4">
              <div class="col-span-2 -mb-2 flex items-center justify-between font-semibold ">
                <label class=" text-gray-700 "><i class="fas fa-pencil-ruler mr-1.5"></i> Size
                </label>
                <button @click="scope = ! scope" class="bg-white rounded-lg hover:bg-blue-400 hover:text-white duration-300 py-1 tracking-wide text-gray-700 shadow border px-2 text-sm"><i class="fas fa-share-square mr-1"></i> Use default</button> 
            </div>
 
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
            <label class="text-gray-500 truncate">: {{$queue->file_name}}</label>
            <label class="text-gray-500">File Size</label>
            <label class="text-gray-500">: {{$queue->fileSize}}</label>
            <label class="text-gray-500">Total Page</label>
            <label class="text-gray-500">: {{$queue->total_page}}</label>
            <label class="text-gray-500">Upload Date</label>
            <label class="text-gray-500 truncate">: {{Carbon\Carbon::parse($queue->created_at)->format('l F Y')}}</label>
            <label class="text-gray-500">Uploaded By</label>
            <label class="text-gray-500 truncate">: {{Auth::user()->name}}</label>
            <div class="col-span-2 border-b pt-2 mb-2"></div>
            <label class="text-gray-700">Editing By</label>
            <label class="text-gray-700 truncate">: {{Auth::user()->name}}</label>
            <label class="text-gray-700">Last Update</label>
            <label class="text-gray-700 truncate">: {{Carbon\Carbon::parse($queue->created_at)->format('l F Y')}}</label>
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
            Apply Signature
        </button>
    </div>
</div>
</div>


<div class="relative w-full p-8 mb-3 mt-0 h-full pb-32" >


    @if(file_exists('temp/pdf_'.auth()->user()->id.'.pdf'))

    <div class=" flex flex-row justify-between items-center pb-2 text-green-500">
     @if ($message = Session::get('success'))
     <div class="alert alert-success">
        <strong>{{ $message }}</strong>
    </div>

    @endif
    <form method="POST" action="{{route('user.delete.upload2',$queue->id)}}" class="justify-end flex flex-row w-full">
      @csrf
      @method('DELETE')
      <button class="text-white bg-red-500  px-4 py-2 rounded-lg text-xl font-semibold tracking-wider hover:bg-red-600"> <i class="fas fa-trash mr-2"></i> Delete</button>
  </form>
</div>

<div class="shadow-lg  text-center h-screen bg-gradient-to-l from-gray-100 to-purple-200 " >

    <div id="divEmbed" x-show="scope"  x-transition class="h-full">
        @if(file_exists('temp/output_pdf'.auth()->user()->id.'.pdf'))
        <embed id='embedPDF' class="w-full h-full" src='../temp/output_pdf{{auth()->user()->id}}.pdf'  width="100%" height='600' type='application/pdf'>
            @else
            <embed id='embedPDF' class="w-full h-full" src='../temp/pdf_{{auth()->user()->id}}.pdf' width="100%"  height='600' type='application/pdf'>
                @endif

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
            <div x-show="!scope" class=" flex flex-row space-x-10 px-10">
                <canvas id="canvas" class="bg-white cursor-move  mt-12 shadow-lg" height="285" width="200" >             
                </canvas> 
                <i class="fas fa-arrow-left text-6xl my-auto animate-pulse text-yellow-400"></i>
                <div class="my-auto">
                <p id="demo" class="text-center font-semibold text-4xl text-gray-700 text-left mb-4">
                    Select Coordinate <br>On This Canvas
                </p>
                <button  @click="scope = ! scope" class="rounded-lg bg-blue-500 text-white font-semibold px-4 py-2 text-2xl rounded-lg hover:bg-blue-600 duration-300"> Back to Editing Mode</button>
                </div>
            </div>
        </div>

        @endif
    </div>

    <div class="flex space-x-6 items-center justify-end bg-gradient-to-l from-gray-500  px-7 py-4 pb-5 shadow-xl  right-0 bottom-0 w-full absolute  text-right ">
     <button class="duration-300 bg-blue-500 hover:bg-blue-600 text-white py-2.5 px-5 text-xl rounded-md font-semibold shadow-lg tracking-wider sticky">
        <i class="fas fa-save"></i> Save</button>
        <button class="duration-300 bg-yellow-500 hover:bg-yellow-400 text-white py-2.5 px-5 text-xl rounded-md font-semibold shadow-lg tracking-wider sticky">
            <i class="fas fa-file-download mr-4"></i> Export</button>
        </div>

    </div>


</div>
</div>


<script src="http://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous">
</script>
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>

<script type="text/javascript">

    function getCursorPosition(canvas, event) {
        const rect = canvas.getBoundingClientRect()
        const x = event.clientX - rect.left
        const y = event.clientY - rect.top
        console.log("x: " + x + " y: " + y)
        var coords = "X coords: " + x + ", Y coords: " + y;
        document.getElementById("demo").innerHTML = coords;
        document.getElementById("formX").value = x;
        document.getElementById("formY").value = y;
    }

    const canvas = document.querySelector('canvas')
    canvas.addEventListener('mousedown', function(e) {
        getCursorPosition(canvas, e)

    })


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

 // Loaded via <script> tag, create shortcut to access PDF.js exports.
 var pdfjsLib = window['pdfjs-dist/build/pdf'];
// The workerSrc property shall be specified.
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

$("#myPdf").on("change", function(e){
    var file = e.target.files[0]
    if(file.type == "application/pdf"){
        var fileReader = new FileReader();  
        fileReader.onload = function() {
            var pdfData = new Uint8Array(this.result);
            // Using DocumentInitParameters object to load binary data.
            var loadingTask = pdfjsLib.getDocument({data: pdfData});
            loadingTask.promise.then(function(pdf) {
              console.log('PDF loaded');
              
              // Fetch the first page
              var pageNumber = 1;
              pdf.getPage(pageNumber).then(function(page) {
                console.log('Page loaded');
                
                var scale = 1.5;
                var viewport = page.getViewport({scale: scale});

                // Prepare canvas using PDF page dimensions
                var canvas = $("#pdfViewer")[0];
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                var renderContext = {
                  canvasContext: context,
                  viewport: viewport
              };
              var renderTask = page.render(renderContext);
              renderTask.promise.then(function () {
                  console.log('Page rendered');
              });
          });
          }, function (reason) {
              // PDF loading error
              console.error(reason);
          });
        };
        fileReader.readAsArrayBuffer(file);
    }
});

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
