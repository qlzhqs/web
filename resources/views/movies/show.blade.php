@extends('layouts.main')

@section('content')
    <div class="movie-info border-b border-gray-800">
        <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row ">
            <img src="{{ $movie['poster_path'] }}" alt="poster" class=" w-64 md:w-96">
            <div class="md:ml-24">
               <h2 class="text-4xl font-semibold">{{ $movie['title'] }}</h2>
               <div class="flex flex-wrap items-center text-gray-400 tex-sm">
                    <svg class="fill-current text-orange-500 w-4" viewBox="0 0 24 24"><g data-name="Layer 2"><path d="M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z" data-name="star"/></g></svg>
                    <span class="ml-1">{{ $movie['vote_average'] }}</span>
                    <span class="mx-2">|</span>
                    <span class="mx-2">{{ $movie['release_date']}}</span>
                    <span class="mx-2">|</span>
                    {{-- <span class="mx-2">{{ $movie['production_companies'] }}</span> --}}
                    <span>
                      {{ $movie['genres'] }}
                    </span>

                    @if ($movie['production_companies'])
                        <span class="mx-2">|</span>
                        <span class="mx-2">{{$movie['production_companies'][0]['name'] }}</span>
                    @endif

                </div>
                <p class="text-gray-300 mt-8 ">
                    {{ $movie['overview'] }}
                </p>

                @if (format_uang($movie['budget'] <= 0))
                    <h4 class="text-white font-semibold mt-12">Budget and Revenue are Unknown</h4>
                    {{-- nampilin budget dan revenue --}}
                    {{-- format uang di buat di bagian app/helper, lalu masukan ke composer.json, setelah itu ketik
                        di comand line composer dump-autoload --}}
                @else
                    <h4 class="text-white font-semibold mt-12">Budget = ${{ format_uang($movie['budget']) }}</h4>
                    <h4 class="text-white font-semibold mt-4">Revenue = ${{ format_uang($movie['revenue']) }}</h4>
                @endif

                <div class="mt-12">
                    <h4 class="text-white font-semibold">Featured Crew</h4>
                    <div class="flex mt-4">
                        @foreach ($movie['credits']['crew'] as $crew)
                        @if ($crew['job'] == "Director")
                        <div class="mr-8">
                            <div>{{ $crew['name'] }}</div>
                            <div class="text-sm text-gray-400">{{ $crew['job'] }}</div>
                        </div>
                        @endif
                        {{-- untuk menampilkan 5 crew --}}
                        @if ($loop->index <4)

                        <div class="mr-8">
                            <div>{{ $crew['name'] }}</div>
                            <div class="text-sm text-gray-400">{{ $crew['job'] }}</div>
                        </div>
                        @else
                            @break
                        @endif

                        @endforeach

                    </div>
                </div>
{{-- jika ada trailer, tampilkan tombol play --}}
                    <div x-data="{ isOpen: false }">
                        @if (count($movie['videos']['results']) > 0)
                            <div class="mt-12">
                                <button
                                    @click="isOpen = true"
                                    class="flex inline-flex items-center bg-orange-500 text-gray-900 rounded font-semibold
                                    px-5 py-4 hover:bg-orange-600 transition ease-in-out duration-150"
                                >
                                    <svg class="w-6 fill-current" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M10 16.5l6-4.5-6-4.5v9zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                                    <span class="ml-2">Play Trailer</span>
                                </button>
                            </div>

                            <template x-if="isOpen">
                                <div
                                    style="background-color: rgba(0, 0, 0, .5);"
                                    class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto"
                                >
                                    <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                                        <div class="bg-gray-900 rounded">
                                            <div class="flex justify-end pr-4 pt-2">
                                                <button
                                                    @click="isOpen = false"
                                                    @keydown.escape.window="isOpen = false"
                                                    class="text-3xl leading-none hover:text-gray-300">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body px-8 py-8">
                                                <div class="responsive-container overflow-hidden relative" style="padding-top: 56.25%">
                                                    <iframe class="responsive-iframe absolute top-0 left-0 w-full h-full"
                                                    src="https://www.youtube.com/embed/{{ $movie['videos']['results'][0]['key'] }}" style="border:0;" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        @endif


                    </div>

            </div>
        </div>
    </div>
    <!-- Inspired by: https://tailwindcomponents.com/component/rate-widget-with-emoji -->
    @if(isset($myRating))
        <h1 class="text-center font-bold text-rose-300 text-xl">Your rating about this movie is : </h1>
        @if($myRating->rating == 1)
            <h1 class="text-center font-bold text-rose-300 text-xl">🤨</h1>
        @elseif($myRating->rating == 2)

            <h1 class="text-center font-bold text-rose-300 text-xl">🙂</h1>

        @elseif($myRating->rating == 3)
            <h1 class="text-center font-bold text-rose-300 text-xl">😊</h1>

        @elseif($myRating->rating == 4)
            <h1 class="text-center font-bold text-rose-300 text-xl">😚</h1>

        @elseif($myRating->rating == 5)
            <h1 class="text-center font-bold text-rose-300 text-xl">😍</h1>
        @endif
        <div class="container mx-auto px-8 pt-8">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your message at this rating:</label>
            <p  name="text" class="" placeholder="" disabled></p>
            <h6 class="font-bold text-gray-300 text-xl">{{$myRating->text}}</h6>
        </div>
    @else
    <div class="flex flex-col justify-center w-screen mt-5 gap-5" x-data="{rating: 0, hovering: 0}">
        <h1 class="text-center font-bold text-rose-300 text-xl">Give please rating about this movie if you watched :)</h1>
        @error('rating')
            <h4 class="text-center font-bold text-rose-300 text-xl">{{ $message }}</h4>
        @enderror
        <div class="flex flex-row justify-center gap-3 relative">
            <div
                    class="flex flex-row justify-center w-10 h-2 rounded-md transition-all duration-200 cursor-pointer"
                    x-bind:class="rating >= 1 ? 'bg-red-400' : 'bg-gray-300'"
                    x-on:click="rating = 1"
                    x-on:mouseover="hovering = 1"
                    x-on:mouseleave="hovering = 0">
                <p class="text-2xl mt-4 select-none pointer-events-none" x-bind:class="rating == 1 || hovering == 1 ? '' : 'invisible' ">🤨</p>
            </div>
            <div
                    class="flex flex-row justify-center w-10 h-2 rounded-md transition-all duration-200 cursor-pointer"
                    x-bind:class="rating >= 2 ? 'bg-red-400' : 'bg-gray-300'"
                    x-on:click="rating = 2"
                    x-on:mouseover="hovering = 2"
                    x-on:mouseleave="hovering = 0">
                <p class="text-2xl mt-4 select-none pointer-events-none" x-bind:class="rating == 2 || hovering == 2 ? '' : 'invisible' ">🙂</p>
            </div>
            <div
                    class="flex flex-row justify-center w-10 h-2 rounded-md transition-all duration-200 cursor-pointer"
                    x-bind:class="rating >= 3 ? 'bg-red-400' : 'bg-gray-300'"
                    x-on:click="rating = 3"
                    x-on:mouseover="hovering = 3"
                    x-on:mouseleave="hovering=0">
                <p class="text-2xl mt-4 select-none pointer-events-none" x-bind:class="rating == 3 || hovering == 3 ? '' : 'invisible' ">😊</p>
            </div>
            <div
                    class="flex flex-row justify-center w-10 h-2 rounded-md transition-all duration-200 cursor-pointer"
                    x-bind:class="rating >= 4 ? 'bg-red-400' : 'bg-gray-300'"
                    x-on:click="rating = 4"
                    x-on:mouseover="hovering = 4"
                    x-on:mouseleave="hovering = 0">
                <p class="text-2xl mt-4 select-none pointer-events-none" x-bind:class="rating == 4 || hovering == 4 ? '' : 'invisible' ">😚</p>
            </div>
            <div
                    class="flex flex-row justify-center w-10 h-2 rounded-md transition-all duration-700 cursor-pointer"
                    x-bind:class="rating >= 5 ? 'bg-red-400' : 'bg-gray-300'"
                    x-on:click="rating = 5"
                    x-on:mouseover="hovering = 5"
                    x-on:mouseleave="hovering = 0">
                <p class="text-2xl mt-4 select-none pointer-events-none" x-bind:class="rating == 5 || hovering == 5 ? '' : 'invisible' ">😍</p>
            </div>

        </div>
        @section('status')
            <h4 class="text-center font-bold text-green-600 text-xl"> {{ session('status') }}</h4>
        @endsection

        <form action="{{route('rating.store')}}" method="post">
            @csrf

            @method('POST')
            <div class="container mx-auto px-8 pt-8">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your message</label>
                <textarea id="message" name="text" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
            </div>

            <div class="flex flex-row justify-center gap-3 relative mt-4">
                <input type="hidden" value="{{$movie['id']}}" name="tmdb_id">

                <input id="rating" x-model="rating" max="5"  value="0" type="hidden" name="rating" class="bg-gray-300 text-black w-20" />
                <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                    Save
                </button>
            </div>
        </form>

    </div>

    @endif

    <div class="movie-cast border-b border-gray-800">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold">Cast</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-8">

                @foreach ($movie['cast'] as $cast)

                    <div class="mt-8">
                        <a href="{{ route('actors.show', $cast['id']) }}">
                            <img src="{{ 'https://image.tmdb.org/t/p/w200/'.$cast['profile_path'] }}" alt="cast" class="hover:opacity-75 transition ease-in-out
                            duration-150">
                        </a>
                        <div class="mt-2">
                            <a href="{{ route('actors.show', $cast['id']) }}"class="text-lg mt-2 hover:text-gray-300">{{ $cast['name'] }}</a>
                            <div class="text-sm text-grat-400">
                                {{ $cast['character'] }}
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div> <!-- end movie-cast -->

    <div class="movie-images" x-data="{ isOpen: false, image: ''}">
        <div class="container mx-auto px-4 py-16">
            <h2 class="text-4xl font-semibold">Images</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach ($movie['images'] as $image)

                    <div class="mt-8">
                        <a
                            @click.prevent="
                                isOpen = true
                                image='{{ 'https://image.tmdb.org/t/p/original/'.$image['file_path'] }}'
                            "
                            href="#"
                        >
                            <img src="{{ 'https://image.tmdb.org/t/p/w500/'.$image['file_path'] }}" alt="image1" class="hover:opacity-75 transition ease-in-out duration-150">
                        </a>
                    </div>

                @endforeach
            </div>
        </div>
    </div> <!-- end movie-images -->
    <section class="bg-white dark:bg-gray-900 py-8 lg:py-16 antialiased">
        <div class="max-w-2xl mx-auto px-4">
                @if(session('comment'))
                    <div class="alert alert-success">
                        {{ session('comment') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Comments</h2>
            </div>

            <form class="mb-6" action="{{route('comment.store')}}" method="post">
                @csrf
                <input type="hidden" value="{{$movie['id']}}" name="tmdb_id">
                <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <label for="comment" class="sr-only">Your comment</label>
                    <textarea id="comment" rows="6" name="comment"
                              class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                              placeholder="Write a comment..." required></textarea>
                </div>
                <button type="submit"
                        style="background-color: #1a202c"
                        class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center  bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Post comment
                </button>
            </form>
            @foreach($allComments as $c)
                <article class="p-6 mb-3 text-base bg-white border-t border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                <footer class="flex justify-between items-center mb-2">
                <div class="flex items-center">

                    <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold"><img
                                class="mr-2 w-6 h-6 rounded-full"
                                src="data:image/png;base64,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"
                                alt="Bonnie Green">{{$c->user->name}}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-03-12"
                                                                              title="March 12th, 2022">{{ $c->time }}</time></p>
                </div>

                </footer>
                <p class="text-gray-500 dark:text-gray-400">
                    {{$c->text}}
                </p>

                </article>
            @endforeach
           </div>
    </section>
@endsection
