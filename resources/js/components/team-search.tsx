import React, { useMemo, useState } from 'react'
import axios from 'axios'
import { useForm } from '@inertiajs/react'
import favoriteTeamsRoutes from '@/routes/favorite-teams'
import { Button } from '@/components/ui/button'
import { Team } from '@/types/team'

interface Props {
    favoriteTeams: Team[]
}

type FavoriteTeamForm = {
    team_id: number | null
}

const TeamSearch: React.FC<Props> = ({ favoriteTeams }) => {
    const [query, setQuery] = useState('')
    const [results, setResults] = useState<Team[]>([])
    const [loading, setLoading] = useState(false)
    const [error, setError] = useState<string | null>(null)

    const favoriteForm = useForm<FavoriteTeamForm>({ team_id: null })

    const favoriteIds = useMemo(
        () => new Set(favoriteTeams.map(team => team.id)),
        [favoriteTeams]
    )

    const handleSearch = async (e: React.FormEvent) => {
        e.preventDefault()
        if (!query) return

        setLoading(true)
        setError(null)

        try {
            const response = await axios.get('/search-by-name', {
                params: { name: query },
                headers: { Accept: 'application/json' },
            })

            // 🔹 Soporte para array directo
            const data = response.data
            setResults(Array.isArray(data) ? data : data.results ?? [])
        } catch (err: any) {
            console.error('Error searching teams:', err)
            setError('Failed to fetch teams. Try again.')
            setResults([])
        } finally {
            setLoading(false)
        }
    }

    const handleAddFavorite = (team: Team) => {
        if (favoriteIds.has(team.id)) return
        favoriteForm.setData('team_id', team.id)
        favoriteForm.post(favoriteTeamsRoutes.store.url(team.id), { preserveScroll: true })
    }

    return (
        <div className="space-y-6">
            <form onSubmit={handleSearch} className="flex gap-2">
                <input
                    type="text"
                    value={query}
                    onChange={e => setQuery(e.target.value)}
                    placeholder="Search team by name..."
                    className="border rounded px-3 py-2 w-full"
                />
                <Button type="submit" disabled={loading || !query}>
                    {loading ? 'Searching...' : 'Search'}
                </Button>
            </form>

            {error && <p className="text-red-500">{error}</p>}

            <div className="space-y-3">
                {results.length === 0 && !loading && query && <p>No teams found.</p>}

                {results.map(team => {
                    const isFavorite = favoriteIds.has(team.id)
                    return (
                        <div
                            key={team.id}
                            className="border rounded-lg p-4 flex items-center justify-between"
                        >
                            <div className="flex items-center gap-3">
                                <img src={team.logo} alt={team.name} className="w-8 h-8" />
                                <div>
                                    <p className="font-semibold">{team.name}</p>
                                    <p className="text-sm text-gray-500">{team.country}</p>
                                </div>
                            </div>

                            <Button
                                onClick={() => handleAddFavorite(team)}
                                disabled={isFavorite || favoriteForm.processing}
                                variant={isFavorite ? 'secondary' : 'default'}
                            >
                                {isFavorite ? 'Already added' : 'Add to favorites'}
                            </Button>
                        </div>
                    )
                })}
            </div>
        </div>
    )
}

export default TeamSearch