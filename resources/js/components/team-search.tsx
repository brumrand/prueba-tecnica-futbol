import { router, useForm } from '@inertiajs/react'
import React, { useMemo } from 'react'

import { dashboard } from '@/routes'
import favoriteTeamsRoutes from '@/routes/favorite-teams'
import type { Team, TeamWithVenue } from '@/types/team'

import { Button } from '@/components/ui/button'

interface Props {
    favoriteTeams: TeamWithVenue[]
    initialResults: Team[]
    initialQuery: string
}

const TeamSearch: React.FC<Props> = ({
    favoriteTeams,
    initialResults,
    initialQuery,
}) => {
    const favCount = favoriteTeams.length
    const favoriteForm = useForm<{ team_id: number | null }>({ team_id: null })
    const {
        data,
        setData,
        get: search,
        processing: loading,
        errors,
    } = useForm({
        search: initialQuery || '',
    })

    const favoriteIds = useMemo(
        () => new Set(favoriteTeams.map(team => team.team.id)),
        [favoriteTeams],
    )

    const handleSearch = (e: React.SubmitEvent) => {
        e.preventDefault()
        const options = {
            preserveState: true,
            preserveScroll: true,
        }
        search(dashboard().url, options)
    }

    const handleAddFavorite = (team: Team) => {
        if (favoriteIds.has(team.id)) return
        favoriteForm.setData('team_id', team.id)
        favoriteForm.post(favoriteTeamsRoutes.store.url(team.id), {
            preserveScroll: true,
        })
    }

    React.useEffect(() => {
        const down = (e: KeyboardEvent) => {
            if (e.key === 'k' && (e.metaKey || e.ctrlKey)) {
                e.preventDefault()
                router.get(
                    dashboard().url,
                    {},
                    {
                        preserveState: true,
                        preserveScroll: true,
                    },
                )
            }
        }
        document.addEventListener('keydown', down)
        return () => document.removeEventListener('keydown', down)
    }, [])

    return (
        <div className="h-full space-y-6">
            <h2 className="w-full text-center font-bold">Team Searcher</h2>
            <form onSubmit={handleSearch} className="flex gap-2">
                <input
                    type="text"
                    value={data.search}
                    onChange={e => setData('search', e.target.value)}
                    placeholder="Search team by name..."
                    className="w-full rounded border px-3 py-2"
                />
                <Button type="submit" disabled={loading || !data.search}>
                    {loading ? 'Searching...' : 'Search'}
                </Button>
            </form>

            {errors.search && <p className="text-red-500">{errors.search}</p>}

            <div className="max-h-[60vh] space-y-3 overflow-y-auto pr-2">
                {favCount >= 5 && (
                    <p className="text-yellow-600">
                        You have reached the maximum of 5 favorite teams. Remove
                        one to add more.
                    </p>
                )}
                {initialResults.length === 0 && !loading && initialQuery && (
                    <p>No teams found.</p>
                )}

                {initialResults.map(searchedTeam => {
                    const isFavorite = favoriteIds.has(searchedTeam.id)
                    return (
                        <div
                            key={searchedTeam.id}
                            className="flex items-center justify-between rounded-lg border p-4"
                        >
                            <div className="flex items-center gap-3">
                                <img
                                    src={searchedTeam.logo}
                                    alt={searchedTeam.name}
                                    className="h-8 w-8"
                                />
                                <div>
                                    <p className="font-semibold">
                                        {searchedTeam.name}
                                    </p>
                                    <p className="text-sm text-gray-500">
                                        {searchedTeam.country}
                                    </p>
                                </div>
                            </div>

                            <Button
                                onClick={() => handleAddFavorite(searchedTeam)}
                                disabled={
                                    isFavorite ||
                                    favoriteForm.processing ||
                                    favCount >= 5
                                }
                                variant={isFavorite ? 'secondary' : 'default'}
                            >
                                {isFavorite
                                    ? 'Already added'
                                    : 'Add to favorites'}
                            </Button>
                        </div>
                    )
                })}
            </div>
        </div>
    )
}

export default TeamSearch