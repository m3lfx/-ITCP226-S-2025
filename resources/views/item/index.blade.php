@extends('layouts.base')
@section('body')
    <div id="items" class="container">
        @include('layouts.flash-messages')
        <a class="btn btn-primary" href="{{ route('items.create') }}" role="button">add</a>
        {{-- action="{{ route('item-import') }}" --}}
        <form method="POST" enctype="multipart/form-data" >
            @csrf
            <input type="file" id="uploadName" name="item_upload" required>
            <button type="submit" class="btn btn-info btn-primary ">Import Excel File</button>

        </form>
        <div class="card-body" style="height: 210px;">
            <input type="text" id='itemSearch' placeholder="--search--">
        </div>
        <div class="table-responsive">
            <table id="itable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>item ID</th>
                        <th>Image</th>
                        <th>description</th>
                        <th>sell price</th>
                        <th>cost price</th>
                        <th>quantity</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->item_id }}</td>
                            @if ($item->image)
                                <td><img src="{{ url($item->image) }}" alt="item image" width="50" height="50">
                                </td>
                            @else
                                <td><img src="#" alt="item image" width="50" height="50">
                                </td>
                            @endif

                            <td>{{ $item->description }}</td>
                            <td>{{ $item->sell_price }}</td>
                            <td>{{ $item->cost_price }}</td>
                            <td>{{ $item->quantity }}</td>
                            @if ($item->deleted_at === null)
                                <td><a href="{{ route('items.edit', $item->item_id) }}"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('items.destroy', $item->item_id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button><i class="fas fa-trash" style="color:red"></i></button>
                                    </form>
                                    <i class="fa-solid fa-rotate-left" style="color:gray"></i>
                                </td>
                            @else
                                <td><i class="fas fa-edit" style="color:gray"></i>
                                    <i class="fas fa-trash" style="color:gray"></i>
                                    <a href="{{ route('items.restore', $item->id) }}"><i class="fa-solid fa-rotate-left"
                                            style="color:blue"></i></a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
@endsection
