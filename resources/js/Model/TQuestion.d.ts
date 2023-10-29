import type {TAnswer} from "@/Model/TAnswer";
import type {TQuiz} from "@/Model/TQuiz";

export interface TQuestion {
    id: int,
    created_at: Date,
    updated_at: Date,
    deleted_at: ?Date,
    quiz: TQuiz,
    text: string,
    order: int,
    open: boolean,
    finished: boolean,
    answers: Array[TAnswer],
}
