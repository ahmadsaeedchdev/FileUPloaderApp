@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('common.flash-message')
        <div class="col-lg-10 col-md-12">
            <div class="card">
                <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <div class="card-title">{{ $file->name }}</div>
                        <div>
                            <a href="{{ route('files.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                      </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($fileResponse->isNOtEmpty() && (!empty($fileResponse['rows'])))
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    @foreach($fileResponse['columns'] as $column)
                                        <th>{{ $column }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fileResponse['rows'] as $key => $elements)
                                    <tr>
                                        @if(is_array($elements))
                                            @foreach($elements as $element)
                                                <td>{{  $element  }}</td>
                                            @endforeach
                                        @else
                                            <td>{{ ' ' }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-info">
                            You have not any data in this {{ $file->name }} file.
                        </div>
                       @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
