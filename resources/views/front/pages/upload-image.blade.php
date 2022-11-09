@extends('layouts.front')

@section('main')
    <!-- Container (Contact Section) -->
    <div id="contact" class="container">
        <h1 class="text-center" style="margin-top: 100px">Image Upload</h1>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message }}</strong>
            </div>

            <img src="{{ asset('public/images/' . Session::get('image')) }}" />
        @endif

        <form method="POST" action="{{ route('fron.image-upload.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="profile_image_1" class="form-label">Profile Image</label>
                <input type="file" accept="image/*" name="image" id="profile_image_1" class="form-control"
                    placeholder="Profile Image" aria-describedby="profile_image_1">
                @error('image')
                    <small id="profile_image_1" class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Upload Image</button>

        </form>



    </div>
@endsection
