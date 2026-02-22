
import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';
import { Team } from '@/types/team';
import { Button } from '@/components/ui/button';
import favoriteTeamsRoutes from '@/routes/favorite-teams'
interface FavoriteTeamsProps {
    teams: Team[];
}

const FavoriteTeams: React.FC<FavoriteTeamsProps> = ({ teams }) => {
    const [expandedTeam, setExpandedTeam] = useState<number | null>(null);
    const { delete: unfavorite, processing } = useForm();

    const handleToggle = (teamId: number) => {
        setExpandedTeam(expandedTeam === teamId ? null : teamId);
    };

    const handleUnfavorite = (teamId: number) => {
        unfavorite(favoriteTeamsRoutes.destroy(teamId).url, {
            onSuccess: () => {
                if (expandedTeam === teamId) {
                    setExpandedTeam(null);
                }
            },
        });
    };

    if (teams.length === 0) {
        return <p>No favorite teams yet.</p>;
    }

    return (
        <div className="space-y-4">
            <h2 className='w-full text-center font-bold'>Favorite Teams</h2>
            {teams.map((team) => (
                <div key={team.id} className="border rounded-lg p-4">
                    <div className="flex items-center">
                        <div
                            className="flex items-center cursor-pointer flex-grow"
                            onClick={() => handleToggle(team.id)}
                        >
                            <img src={team.logo} alt={team.name} className="w-8 h-8 mr-4" />
                            <h3 className="text-lg font-semibold">{team.name}</h3>
                        </div>
                        <Button
                            variant="destructive"
                            onClick={() => handleUnfavorite(team.id)}
                            disabled={processing}
                        >
                            Remove
                        </Button>
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

function route(arg0: string, arg1: { teamId: number; }): string {
    throw new Error('Function not implemented.');
}
