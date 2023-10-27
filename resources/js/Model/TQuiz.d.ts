import type {TQuestion} from "@/Model/TQuestion";

export interface TQuiz {
    id: int,
    name: string,
    short_name: string,
    questions: Array[TQuestion],
}
