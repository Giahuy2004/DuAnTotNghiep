@extends('layout')

@section('content')
    <h1>Danh sách yêu thích của bạn</h1>

    @if ($wishlists->isEmpty())
        <p>Danh sách yêu thích của bạn đang trống.</p>
    @else
        <ul>
            @foreach ($wishlists as $wishlist)
                <li>
                    {{ $wishlist->product->name }} 
                    - <a href="{{ route('wishlist.destroy', $wishlist->id) }}" 
                         onclick="event.preventDefault(); document.getElementById('delete-form-{{ $wishlist->id }}').submit();">
                        Xóa
                    </a>

                    <form id="delete-form-{{ $wishlist->id }}" action="{{ route('wishlist.destroy', $wishlist->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
