import type {TAnswer} from "@/Model/TAnswer";

export interface TQuestion {
    id: int,
    name: string,
    text: string,
    answers: Array[TAnswer],
}
