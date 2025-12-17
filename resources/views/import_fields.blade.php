@extends('app')
  
@section('content')
<main class="login-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Choose columns from drop down</div>
    
                    <form action="{{ route('import_process') }}" method="POST">
                            @csrf

                            <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file }}"/>

                            <table class="table">
            
                                <thead>
                                <tr>
                                    @foreach ($headings[0][0] as $csv_header_field)
                                        {{--                                            @dd($headings)--}}
                                        <th class="px-6 py-3 bg-gray-50">
                                            <span class="text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ $csv_header_field }}</span>
                                        </th>
                                    @endforeach
                                </tr>
                                </thead>
                            

                                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @foreach($csv_data as $row)
                                    <tr class="bg-white">
                                        @foreach ($row as $key => $value)
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                                {{ $value }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                <tr>
                                    @foreach ($csv_data[0] as $key => $value)
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                            <select name="fields[{{ $key }}]" class="form-control">
                                                @foreach (config('app.db_fields') as $db_key => $db_field)
                                                    <option value="{{ $db_field }}"
                                                                @if ($key === $db_key) selected @endif>{{ $db_field }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>

                            <div class="col-md-6 offset-md-4 py-3">
                                <button type="submit" class="btn btn-primary">
                                    Insert
                                </button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
<main>
@endsection
