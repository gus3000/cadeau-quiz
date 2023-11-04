import type {TAnswer} from "@/Model/TAnswer";

export interface TGuess {
    id: int,
    created_at: Date,
    updated_at: Date,
    answer: TAnswer,
}
