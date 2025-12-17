@extends('app')
  
@section('content')
<main class="login-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload CSV</div>
    
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
    
                        <form action="{{ route('import_parse') }}" method="POST" class="mb-4" enctype="multipart/form-data">
                        @csrf

                            <div class="form-group row">
                                <label for="csv_file" class="col-md-4 col-form-label text-md-right">CSV file to import</label>
                                <div class="col-md-6">
                                    <input type="file" id="csv_file" class="form-control border-0" name="csv_file" >
                                    @if ($errors->has('csv_file'))
                                        <span class="text-danger">{{ $errors->first('csv_file') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </form>

                        <div class="overflow-hidden overflow-x-auto min-w-full align-middle sm:rounded-md">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="px-3 py-3 bg-gray-50">
                                        <span class="text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">First name</span>
                                    </th>
                                    <th class="px-3 py-3 bg-gray-50">
                                        <span class="text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Last name</span>
                                    </th>
                                    <th class="px-3 py-3 bg-gray-50">
                                        <span class="text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Phone</span>
                                    </th>
                                    <th class="px-3 py-3 bg-gray-50">
                                        <span class="text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Address</span>
                                    </th>
                                </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @foreach($contacts as $contact)
                                    <tr class="bg-white">
                                        <td class="px-3 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $contact->first_name }}
                                        </td>
                                        <td class="px-3 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $contact->last_name }}
                                        </td>
                                        <td class="px-3 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $contact->phone }}
                                        </td>
                                        <td class="px-3 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            {{ $contact->address }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex">
                            {!! $contacts->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection


