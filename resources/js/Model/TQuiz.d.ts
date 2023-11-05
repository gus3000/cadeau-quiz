import type {TQuestion} from "@/Model/TQuestion";

export interface TQuiz {
    id: int,
    created_at: Date,
    updated_at: Date,
    deleted_at: ?Date,
    opened_at: Date,
    created_by: TUser,
    name: string,
    short_name: string,
    logo_url: string,
    finished: boolean,
    questions: TQuestion[],
}
