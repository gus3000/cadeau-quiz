export interface TStats {
    players: TPlayerStats[],
}

export interface TPlayerStats {
    name: string,
    score: number,
    goodAnswers: number,
}
