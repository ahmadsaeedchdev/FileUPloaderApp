@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('common.flash-message')
        @error('file')
         <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="col-md-10">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>Files</div>
                        <div>
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#file-uploader">Import</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($files->isNOtEmpty())
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                  @foreach($files as $key => $file)
                                     <tr>
                                         <td>{{ $key + 1 }}</td>
                                         <td>{{ $file->name }}</td>
                                         <td><a href="{{ route('files.show',$file->id)}}" class="btn btn-primary" )>View</a></td>
                                     </tr>
                                  @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-info">
                            You have not upload any file.
                        </div>
                       @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Modal --}}
<div class="modal fade" id="file-uploader" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Uploade File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('files.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Uploade File</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file" id="uploadeFile">
                        <label class="custom-file-label" for="uploadeFile">Choose file e.g:xlxs,cvs</label>
                    </div>
                    @error('file')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
         </form>
      </div>
    </div>
</div>
@endsection
