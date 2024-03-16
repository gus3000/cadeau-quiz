import type {TQuestion} from "@/Model/TQuestion";

export interface TQuiz {
    id: int,
    created_at: string,
    updated_at: string,
    deleted_at: ?string,
    opened_at: Date,
    created_by: TUser,
    name: string,
    short_name: string,
    logo_url: string,
    default_duration: number,
    default_number_of_answers: number,
    restricted_to_allowed_users: boolean,
    locked: boolean,
    finished: boolean,
    questions: TQuestion[],
}
