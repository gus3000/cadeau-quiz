import type {TQuestion} from "@/Model/TQuestion";

export interface TAnswer {
    id: int,
    created_at: Date,
    updated_at: Date,
    text: string,
    correct: ?boolean,
    question: TQuestion,
}
