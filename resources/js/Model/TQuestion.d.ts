import type {TAnswer} from "@/Model/TAnswer";
import type {TQuiz} from "@/Model/TQuiz";
import {TMedia} from "@/Model/TMedia";

export interface TQuestion {
    id: int,
    created_at: Date,
    updated_at: Date,
    deleted_at: ?Date,
    quiz: TQuiz,
    text: string,
    duration: float,
    closed: boolean,
    finished: boolean,
    order: int,
    /** ⚠ UTC */
    opened_at: Date,
    correct_answer: ?TAnswer,
    answers: TAnswer[],
    media: TMedia,
    time_remaining_with_grace_period: float,
}
