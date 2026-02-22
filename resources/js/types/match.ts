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

export interface ScoreDetail {
    halftime: MatchScore;
    fulltime: MatchScore;
    extratime: MatchScore | null;
    penalty: MatchScore | null;
}

export interface LeagueDto {
    id: number;
    name: string;
    country: string;
    logo: string;
    round: string;
    season: number;
    standings: boolean;
}

export interface FixtureDto {
    id: number;
    referee: string | null;
    timezone: string;
    date: string; // ISO string
    venue: {
        id: number | null;
        name: string;
        city: string;
    };
    status: {
        long: string;
        short: string;
        elapsed: number | null;
        extra: number | null;
    };
}

export interface MatchDto {
    fixture: FixtureDto;
    league: LeagueDto;
    teams: {
        home: MatchTeam;
        away: MatchTeam;
    };
    goals: MatchScore;
    score: ScoreDetail;
}