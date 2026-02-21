
import React, { useState } from 'react';
import { Team } from '@/types/team';

interface FavoriteTeamsProps {
    teams: Team[];
}

const FavoriteTeams: React.FC<FavoriteTeamsProps> = ({ teams }) => {
    const [expandedTeam, setExpandedTeam] = useState<number | null>(null);

    const handleToggle = (teamId: number) => {
        setExpandedTeam(expandedTeam === teamId ? null : teamId);
    };

    if (teams.length === 0) {
        return <p>No favorite teams yet.</p>;
    }

    return (
        <div className="space-y-4">
            {teams.map((team) => (
                <div key={team.id} className="border rounded-lg p-4">
                    <div
                        className="flex items-center cursor-pointer"
                        onClick={() => handleToggle(team.id)}
                    >
                        <img src={team.logo} alt={team.name} className="w-8 h-8 mr-4" />
                        <h3 className="text-lg font-semibold">{team.name}</h3>
                    </div>
                    {expandedTeam === team.id && (
                        <div className="mt-4 space-y-2">
                            <p><strong>Country:</strong> {team.country}</p>
                            <p><strong>Founded:</strong> {team.founded}</p>
                            {team.venue && (
                                <p><strong>Venue:</strong> {team.venue.name}</p>
                            )}
                        </div>
                    )}
                </div>
            ))}
        </div>
    );
};

export default FavoriteTeams;
