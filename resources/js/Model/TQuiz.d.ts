import type {TQuestion} from "@/Model/TQuestion";

export interface TQuiz {
    id: int,
    created_at: Date,
    updated_at: Date,
    deleted_at: ?Date,
    opened_at: Date,
    // created_by: TUser,
    name: string,
    short_name: string,
    finished: boolean,
    questions: Array[TQuestion],
}
