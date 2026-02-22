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
            <h2 className='w-full text-center font-bold'>Matches</h2>
            {matches.map(match => (
                <div key={match.id} className="border rounded-lg p-4">
                    {/* HEADER */}
                    <div
                        className="flex items-center cursor-pointer"
                        onClick={() => toggleMatch(match.id)}
                    >
                        {/* Home team */}
                        <div className="flex items-center w-1/3">
                            <img
                                src={match.teams.home.logo}
                                alt={match.teams.home.name}
                                className="w-6 h-6 mr-2"
                            />
                            <span className="font-medium">
                                {match.teams.home.name}
                            </span>
                        </div>

                        {/* Score */}
                        <div className="w-1/3 text-center font-bold">
                            {match.score.fulltime.home ?? '-'} : {match.score.fulltime.away ?? '-'}
                        </div>

                        {/* Away team */}
                        <div className="flex items-center justify-end w-1/3">
                            <span className="font-medium mr-2">
                                {match.teams.away.name}
                            </span>
                            <img
                                src={match.teams.away.logo}
                                alt={match.teams.away.name}
                                className="w-6 h-6"
                            />
                        </div>
                    </div>

                    {/* DETAILS */}
                    {expandedMatch === match.id && (
                        <div className="mt-4 text-sm space-y-2">
                            <p>
                                <strong>League:</strong> {match.league?.name ?? 'Unknown League'} ({match.league?.country ?? 'N/A'})
                            </p>
                            <p>
                                <strong>Round:</strong> {match.league?.round ?? 'N/A'}
                            </p>
                            <p>
                                <strong>Date:</strong>{' '}
                                {match.date
                                    ? new Date(match.date).toLocaleString()
                                    : 'Unknown date'}
                            </p>
                            <p>
                                <strong>Status:</strong> {match.status ?? 'Unknown'}
                            </p>
                            <p>
                                <strong>Venue:</strong> {match.venue?.name ?? 'No venue'} – {match.venue?.city ?? 'Unknown city'}
                            </p>

                            <div className="pt-2">
                                <strong>Halftime:</strong>{' '}
                                {match.score?.halftime?.home ?? '-'} : {match.score?.halftime?.away ?? '-'}
                            </div>
                        </div>
                    )}
                </div>
            ))}
        </div>
    );
};

export default MatchesList;