@extends('layouts.app')
@section('title', 'Create Post')
@section('content')
    <h1>Create Post</h1>
    <p>Welcome to the create post page!</p>

    {{-- <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data"> --}}
    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- Image preview --}}
        {{-- 
            Puts image in a session variable to be used in the preview.
            This has to also have a function for mobile devices to both take a picture and upload it from the device.
        --}}
        <img id="preview" src="{{ asset(session('image')) }}" alt="Image preview" />
        <label for="file">Import image</label>
        <input id="file" type="file" name="file" hidden accept="image/*" capture="camera"
            onchange="previewFile()" />

        <label for="title">Title</label>
        <input type="text" name="title" id="title">
        <label for="content">Content</label>
        <textarea name="content" id="content" cols="30" rows="10"></textarea>
        <button type="submit">Create Post</button>
    </form>


    {{-- Move into separate file later --}}
    <script>
        function previewFile() {
            const preview = document.querySelector('#preview');
            const file = document.querySelector('#file').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function() {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>

@endsection
