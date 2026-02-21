export interface MatchTeam {
    id: number;
    name: string;
    logo: string;
    winner: boolean | null;
}

export interface MatchScore {
    home: number | null;
    away: number | null;
}

export interface MatchDto {
    id: number;
    date: string;           // ISO string
    status: string;         // HT, FT, NS, etc
    league: {
        name: string;
        country: string;
        logo: string;
        round: string;
    };
    venue: {
        name: string;
        city: string;
    };
    teams: {
        home: MatchTeam;
        away: MatchTeam;
    };
    score: {
        halftime: MatchScore;
        fulltime: MatchScore;
    };
}