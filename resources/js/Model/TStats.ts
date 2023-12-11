export interface TStats {
    players: TPlayerStats[],
    statsType: TStatsType,
}

export enum TStatsType {
    Quiz,
    Question
}

export interface TPlayerStats {
    name: string,
    score: number,
    goodAnswers: number|null,
}
