import { Head } from '@inertiajs/react';
import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { dashboard } from '@/routes';
import FavoriteTeams from '@/components/favorite-teams';
import MatchesList from '@/components/maches-list';
import TeamSearch from '@/components/team-search';
import { Team } from '@/types/team';
import { MatchDto } from '@/types/match';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

export default function Dashboard({ favoriteTeams, matchData  }: { favoriteTeams: Team[], matchData: MatchDto[] }) {

    console.log('Favorite teams data received in Dashboard component:', favoriteTeams);
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-2">
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <FavoriteTeams teams={favoriteTeams} />
                    </div>

                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <TeamSearch favoriteTeams={favoriteTeams} />
                    </div>
                </div>
                <div className="relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                   <MatchesList matches={matchData} />
                </div>
            </div>
        </AppLayout>
    );
}
