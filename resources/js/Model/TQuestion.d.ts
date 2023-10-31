import type {TAnswer} from "@/Model/TAnswer";
import type {TQuiz} from "@/Model/TQuiz";

export interface TQuestion {
    id: int,
    created_at: Date,
    updated_at: Date,
    deleted_at: ?Date,
    quiz: TQuiz,
    text: string,
    duration: float,
    order: int,
    /** ⚠ UTC */
    opened_at: Date,
    answers: Array[TAnswer],
}
