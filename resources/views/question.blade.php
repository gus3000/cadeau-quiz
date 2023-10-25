<x-layout>
    <div id="app" class="flex w-full h-screen justify-center items-center">
        <div class="w-full max-w-xl p-3">
            <h1 class="font-bold text-5xl text-center text-indigo-700">
                Cadeau Quiz
            </h1>
            <x-question :$question/>
        </div>
    </div>
</x-layout>
