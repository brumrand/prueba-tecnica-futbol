import React, { useState } from 'react';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import { MatchDto } from '@/types/match';
import { TeamWithVenue } from '@/types/team';
import { useDarkMode } from '@/hooks/use-dark-mode';

interface MatchesListProps {
  matches: MatchDto[];
  favTeams: TeamWithVenue[];
}

type ViewMode = 'list' | 'calendar';

const MatchesList: React.FC<MatchesListProps> = ({ matches, favTeams }) => {
  const [expandedMatch, setExpandedMatch] = useState<number | null>(null);
  const [viewMode, setViewMode] = useState<ViewMode>('list');

  const isDarkMode = useDarkMode();

  const toggleMatch = (matchId: number) => {
    setExpandedMatch(expandedMatch === matchId ? null : matchId);
  };

  if (matches.length === 0) return <p>No matches available.</p>;

  // ---------- Calendar events ----------
  const calendarEvents = matches.map(match => ({
    id: String(match.fixture.id),
    title: `${match.teams.home.name} vs ${match.teams.away.name}`,
    date: match.fixture.date,
    extendedProps: match,
  }));

  // Helper: obtiene datos de equipos favoritos
const getMatchData = (match: MatchDto) => {
  const homeFav = favTeams.find(t => t.team.id === match.teams.home.id);
  const awayFav = favTeams.find(t => t.team.id === match.teams.away.id);

  const star = (isFav: boolean | undefined) => (isFav ? 'Seguido - ' : 'Rival - '); // estrella solo si es favorito

  return (
    <div className="mt-2 border-t pt-2 space-y-1">
                      <p><strong>Date:</strong> {new Date(match.fixture.date).toLocaleString()}</p>
                <p><strong>League:</strong> {match.league.name}</p>
                <p><strong>Score:</strong> {match.score.fulltime.home ?? '-'} : {match.score.fulltime.away ?? '-'}</p>
                <p><strong>Status:</strong> {match.fixture.status.long}</p>
      <div>
        <strong>{star(!!homeFav)}Home Team:</strong> <img src={match.teams.home.logo} className="w-6 h-6 mr-2" />{match.teams.home.name} 
      </div>

      <div>
        <strong>{star(!!awayFav)}Away Team:</strong> <img src={match.teams.away.logo} className="w-6 h-6 mr-2" />{match.teams.away.name}
      </div>
    </div>
  );
};

  return (
    <div className="space-y-4">
      {/* HEADER */}
      <div className="flex justify-between items-center">
        <h2 className="font-bold">Matches</h2>
        <div className="flex gap-2">
          <button
            onClick={() => setViewMode('list')}
            className={`px-3 py-1 rounded ${
              viewMode === 'list'
                ? 'bg-blue-600 text-white'
                : 'bg-gray-200 dark:bg-slate-700 dark:text-white'
            }`}
          >
            List
          </button>
          <button
            onClick={() => setViewMode('calendar')}
            className={`px-3 py-1 rounded ${
              viewMode === 'calendar'
                ? 'bg-blue-600 text-white'
                : 'bg-gray-200 dark:bg-slate-700 dark:text-white'
            }`}
          >
            Calendar
          </button>
        </div>
      </div>

      {/* ================= LIST VIEW ================= */}
      {viewMode === 'list' && (
        <div className="space-y-4">
          {matches.map(match => (
            <div
              key={match.fixture.id}
              className="border rounded-lg p-4 dark:border-slate-700"
            >
              <div
                className="flex items-center cursor-pointer"
                onClick={() => toggleMatch(match.fixture.id)}
              >
                <div className="flex items-center w-1/3">
                  <img src={match.teams.home.logo} className="w-6 h-6 mr-2" />
                  {match.teams.home.name}
                </div>

                <div className="w-1/3 text-center font-bold">
                  {match.score.fulltime.home ?? '-'} : {match.score.fulltime.away ?? '-'}
                </div>

                <div className="flex justify-end w-1/3">
                  {match.teams.away.name}
                  <img src={match.teams.away.logo} className="w-6 h-6 ml-2" />
                </div>
              </div>

              {expandedMatch === match.fixture.id && (
                <div className="mt-4 text-sm space-y-1">


                  {/* ---------- Favorite Teams Info ---------- */}
                  {getMatchData(match)}
                </div>
              )}
            </div>
          ))}
        </div>
      )}

      {/* ================= CALENDAR VIEW ================= */}
      {viewMode === 'calendar' && (
        <div className={`rounded-lg p-4 ${isDarkMode ? 'fc-dark' : 'bg-white'}`}>
          <FullCalendar
            plugins={[dayGridPlugin, interactionPlugin]}
            initialView="dayGridMonth"
            events={calendarEvents}
            height="auto"
            headerToolbar={{
              left: 'prev,next today',
              center: 'title',
              right: 'dayGridMonth,dayGridWeek',
            }}
            eventClick={(info) => {
              const match = info.event.extendedProps as MatchDto;
              setExpandedMatch(match.fixture.id);
            }}
          />
        </div>
      )}


      {viewMode === 'calendar' && expandedMatch && (
        <div className="border rounded-lg p-4 dark:border-slate-700">
          {matches
            .filter(m => m.fixture.id === expandedMatch)
            .map(match => (
              <div key={match.fixture.id}>
                <h3 className="font-bold mb-2">
                  {match.teams.home.name} vs {match.teams.away.name}
                </h3>

                {getMatchData(match)}
              </div>
            ))}
        </div>
      )}
    </div>
  );
};

export default MatchesList;