import React, { useState } from 'react';
import { MatchDto } from '@/types/match';

interface MatchesListProps {
    matches: MatchDto[];
}

const MatchesList: React.FC<MatchesListProps> = ({ matches }) => {
    const [expandedMatch, setExpandedMatch] = useState<number | null>(null);

    const toggleMatch = (matchId: number) => {
        setExpandedMatch(expandedMatch === matchId ? null : matchId);
    };

    if (matches.length === 0) {
        return <p>No matches available.</p>;
    }

    return (
        <div className="space-y-4">
            <h2 className="w-full text-center font-bold">Matches</h2>
            {matches.map((match) => (
                <div
                    key={`${match.fixture.id}-${match.fixture.status.short}-${match.fixture.date}`}
                    className="border rounded-lg p-4"
                >
                    {/* HEADER */}
                    <div
                        className="flex items-center cursor-pointer"
                        onClick={() => toggleMatch(match.fixture.id)}
                    >
                        {/* Home team */}
                        <div className="flex items-center w-1/3">
                            <img
                                src={match.teams.home.logo}
                                alt={match.teams.home.name}
                                className="w-6 h-6 mr-2"
                            />
                            <span className="font-medium">{match.teams.home.name}</span>
                        </div>

                        {/* Score */}
                        <div className="w-1/3 text-center font-bold">
                            {match.score.fulltime.home ?? '-'} : {match.score.fulltime.away ?? '-'}
                        </div>

                        {/* Away team */}
                        <div className="flex items-center justify-end w-1/3">
                            <span className="font-medium mr-2">{match.teams.away.name}</span>
                            <img
                                src={match.teams.away.logo}
                                alt={match.teams.away.name}
                                className="w-6 h-6"
                            />
                        </div>
                    </div>

                    {/* DETAILS */}
                    {expandedMatch === match.fixture.id && (
                        <div className="mt-4 text-sm space-y-2">
                            <p>
                                <strong>League:</strong> {match.league.name} ({match.league.country})
                            </p>
                            <p>
                                <strong>Round:</strong> {match.league.round}
                            </p>
                            <p>
                                <strong>Season:</strong> {match.league.season}
                            </p>
                            <p>
                                <strong>Standings Enabled:</strong> {match.league.standings ? 'Yes' : 'No'}
                            </p>

                            <p>
                                <strong>Date:</strong>{' '}
                                {match.fixture.date
                                    ? new Date(match.fixture.date).toLocaleString()
                                    : 'Unknown date'}
                            </p>
                            <p>
                                <strong>Timezone:</strong> {match.fixture.timezone}
                            </p>
                            <p>
                                <strong>Referee:</strong> {match.fixture.referee ?? 'N/A'}
                            </p>
                            <p>
                                <strong>Status:</strong> {match.fixture.status.long} ({match.fixture.status.short}) – Elapsed:{' '}
                                {match.fixture.status.elapsed ?? 0} min
                            </p>

                            <p>
                                <strong>Venue:</strong> {match.fixture.venue.name} – {match.fixture.venue.city}
                            </p>

                            <div>
                                <strong>Halftime:</strong> {match.score.halftime.home ?? '-'} : {match.score.halftime.away ?? '-'}
                            </div>
                            <div>
                                <strong>Fulltime:</strong> {match.score.fulltime.home ?? '-'} : {match.score.fulltime.away ?? '-'}
                            </div>
                            {match.score.extratime && (
                                <div>
                                    <strong>Extra time:</strong> {match.score.extratime.home ?? '-'} : {match.score.extratime.away ?? '-'}
                                </div>
                            )}
                            {match.score.penalty && (
                                <div>
                                    <strong>Penalty:</strong> {match.score.penalty.home ?? '-'} : {match.score.penalty.away ?? '-'}
                                </div>
                            )}

                            <div className="pt-2">
                                <strong>Winner:</strong> {match.teams.home.winner ? match.teams.home.name : match.teams.away.winner ? match.teams.away.name : 'Draw / TBD'}
                            </div>
                        </div>
                    )}
                </div>
            ))}
        </div>
    );
};

export default MatchesList;