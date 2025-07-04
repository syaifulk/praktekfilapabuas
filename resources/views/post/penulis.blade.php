@extends('layout')
@section('content')
<section class="text-gray-600 body-font">
 <div class="container mx-auto flex px-5 py-20 items-center justify-center flex-col">
    <img
    class="w-40 sm:w-48 md:w-56 lg:w-64 xl:w-72 object-cover rounded shadow"
    src="{{ $post->getFirstMediaUrl('featured_image') ?: 'https://dummyimage.com/600x400' }}"
    alt="Foto Penulis">
    <div class="text-center lg:w-2/3 w-full">
      <h1 class="title-font sm:text-3xl text-2xl mb-1 font-medium text-gray-900">{{ $post->title}}</h1>
      <h4 class="title-font sm:text-2xl text-1xl mb-3 font-medium text-gray-700">{{ $post->slug}}</h4>
      <p class="mb-8 leading-relaxed">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 500, '...') }}</p>
      <div class="flex justify-center">
        <button class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Button</button>
        <button class="ml-4 inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">Button</button>
      </div>
    </div>
  </div>
</section>
@endsection