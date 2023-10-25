@pushOnce('scripts')
    <script>
        function selectAnswer(answer) {
            console.log("selected : ", answer);
        }

        selectAnswer("coucou");
    </script>
@endpushonce

<div class="bg-white p-12 rounded-lg shadow-lg w-full mt-8">
    {{--            @if (count($records) === 1)--}}
    {{--            @endif--}}
    <p class="text-2xl font-bold">{{ $question->text }}</p>
    @foreach($question->answers_in_random_order as $answer)
        <label
            class="block mt-4 border border-gray-300 grounded-lg py-2 px-6 text-lg">
            <input
                class="answer"
                type="radio"
                name="{{$question->id}}"
                onchange="selectAnswer(this)"
            />
            {{ $answer }}
        </label>
    @endforeach
</div>
