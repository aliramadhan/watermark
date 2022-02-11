<x-app-layout>
	<table>
		<thead>
			<tr>
				<th>No.</th>
				<th>File Name</th>
				<th>File Path</th>
				<th>File Size</th>
				<th>File Width</th>
				<th>File Height</th>
				<th>File Image</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($watermarks as $watermark)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$watermark->file_name}}</td>
					<td>{{$watermark->file_path}}</td>
					<td>{{$watermark->size}}</td>
					<td>{{$watermark->width}}</td>
					<td>{{$watermark->height}}</td>
					<td><img src="../{{$watermark->file_path}}" width="50px"></td>
					<td>
						@if($watermarks->count() > 1)
						<form method="POST" action="{{route('user.delete.watermark',$watermark->id)}}" onsubmit="return confirm('Are U sure to delete this watermark?')">
					      @csrf
					      @method('DELETE')
					      <button type="submit" class="text-white bg-red-500  px-4 py-2 rounded-lg text-xl font-semibold tracking-wider hover:bg-red-600"> <i class="fas fa-trash mr-2"></i> Delete</button>
					    </form>
					    @endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</x-app-layout>