@extends('layouts.app')

@section('page-title', 'Librarys')
@section('page-heading', 'Librarys')

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        List of libraries
    </li>
@stop

@section('content')

    @include('partials.messages')
 
    <div class="card">
        <div class="card-body">
            <form action="" method="GET" id="users-form" class="pb-2 mb-3 border-bottom-light">
                <div class="row my-3 flex-md-row flex-column-reverse">
                    <div class="col-md-4 mt-md-0 mt-2">
                        <div class="input-group custom-search-form">
                            <input type="text"
                                   class="form-control input-solid"
                                   name="search"
                                   autocomplete="off" 
                                   value="{{ Input::get('search') }}"
                                   placeholder="Search library">

                                <span class="input-group-append">
                                    @if (Input::has('search') && Input::get('search') != '')
                                        <a href="{{ route('library.index') }}"
                                               class="btn btn-light d-flex align-items-center text-muted"
                                               role="button">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                    <button class="btn btn-light" type="submit" id="search-users-btn">
                                        <i class="fas fa-search text-muted"></i>
                                    </button>
                                </span>
                        </div>
                    </div>

                    <div class="col-md-2 mt-2 mt-md-0">
                        {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control input-solid']) !!}
                    </div>

                    <div class="col-md-4">
                        <a href="{{ route('library.create') }}?type=finalbook&action=submit" class="btn btn-primary btn-rounded float-right">
                            <i class="fas fa-plus mr-2"></i>
                            Add Final Book
                        </a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('library.create') }}?action=add-book" class="btn btn-primary btn-rounded float-right">
                            <i class="fas fa-plus mr-2"></i>
                            Borrow Book
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive" id="users-table-wrapper">
                <table class="table table-striped table-borderless">
                    <thead>
                    <tr>
                        <th class="">Reg. No</th>
                        <th class="">Book Title</th>
                        <th>ISBN</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (count($libraries))
                            @foreach ($libraries as $library)
                                <tr>
                                    <td>
                                        {{ $library->first_name.' '.$library->last_name }}
                                        <strong>({{ $library->regno }})</strong>
                                    </td>
                                    <td>{{ $library->book_title }}</td>
                                    <td>
                                        {{ $library->book_isbn }}
                                    </td>
                                    <td>
                                        @foreach($statuses as $key => $type)
                                            @if($library->type == $key)
                                                {{ $type }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $library->status }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('library.edit', $library->id) }}@if($library->type=='finalbook')?type=finalbook @endif" class="btn btn-icon"
                                           title="Edit library" data-toggle="tooltip" data-placement="top">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('library.delete', $library->id) }}" class="btn btn-icon"
                                           title="Delete library"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           data-method="DELETE"
                                           data-confirm-title="Comfirm"
                                           data-confirm-text="Are you sure that you want to delete this library"
                                           data-confirm-delete="Yes, Delete it.">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7"><em>No books found</em></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $("#status").change(function () {
            $("#users-form").submit();
        });
    </script>
@stop
