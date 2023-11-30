import type {TQuestion} from "@/Model/TQuestion";
import {TGuess} from "@/Model/TGuess";

export interface TAnswer {
    id: int,
    created_at: Date,
    updated_at: Date,
    text: string,
    correct: ?boolean,
    question: TQuestion,
    guesses: TGuess[],
}
